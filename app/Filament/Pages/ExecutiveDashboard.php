<?php

namespace App\Filament\Pages;

use App\Models\Document;
use App\Models\MentoringSession;
use App\Models\PspApplication;
use App\Models\ScholarshipApplication;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class ExecutiveDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartBar;
    protected static ?string $navigationLabel = 'Executive Dashboard';
    protected static ?string $title = 'Executive Dashboard';
    protected static ?int $navigationSort = -1;

    protected string $view = 'filament.pages.executive-dashboard';

    // ── Livewire filter state ──
    public int $selectedYear;
    public string $selectedMonth = ''; // '' = all months

    public function mount(): void
    {
        $this->selectedYear = (int) date('Y');
    }

    // ── Date range from filter ──
    private function dateRange(): array
    {
        if ($this->selectedMonth !== '') {
            return [
                Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth(),
                Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth(),
            ];
        }
        return [
            Carbon::create($this->selectedYear, 1, 1)->startOfYear(),
            Carbon::create($this->selectedYear, 12, 31)->endOfYear(),
        ];
    }

    // ── Line chart labels & periods ──
    private function linePeriods(): array
    {
        [$from, $to] = $this->dateRange();
        $periods = [];

        if ($this->selectedMonth !== '') {
            // Daily: each day in the selected month
            $day = $from->copy();
            while ($day->lte($to)) {
                $periods[] = ['label' => $day->format('d M'), 'from' => $day->copy()->startOfDay(), 'to' => $day->copy()->endOfDay()];
                $day->addDay();
            }
        } else {
            // Monthly: all 12 months of the year
            for ($m = 1; $m <= 12; $m++) {
                $start = Carbon::create($this->selectedYear, $m, 1)->startOfMonth();
                $end   = $start->copy()->endOfMonth();
                $periods[] = ['label' => $start->format('M'), 'from' => $start, 'to' => $end];
            }
        }
        return $periods;
    }


    public function getViewData(): array
    {
        [$from, $to] = $this->dateRange();

        // ── KPI Stats ──
        $totalMentees = User::role('mentee')->whereBetween('created_at', [$from, $to])->count();
        $pspApproved  = PspApplication::where('status', 'approved')->whereBetween('created_at', [$from, $to])->count();

        $toeflLolos = Document::where('type', 'ielts_toefl')
            ->where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $saBase      = ScholarshipApplication::whereBetween('updated_date', [$from, $to]);
        $saLolos     = (clone $saBase)->where('status', 'lolos')->count();
        $saTotal     = (clone $saBase)->count();
        $successRate = $saTotal > 0 ? round($saLolos / $saTotal * 100, 1) : 0;

        $mentoringDone = MentoringSession::where('status', 'done')->whereBetween('created_at', [$from, $to])->count();
        
        $requiredTypes = array_keys(Document::REQUIRED_TYPES);
        $requiredCount = count($requiredTypes);
        $fullySubmittedUsers = 0;
        $menteesWithDocs = User::role('mentee')
            ->whereBetween('created_at', [$from, $to])
            ->with(['documents' => function ($q) use ($requiredTypes) {
                $q->whereIn('type', $requiredTypes);
            }])
            ->get();
        foreach ($menteesWithDocs as $m) {
            $uploadedTypes = $m->documents->pluck('type')->unique()->count();
            if ($uploadedTypes === $requiredCount) {
                $fullySubmittedUsers++;
            }
        }
        $docsApproved = $fullySubmittedUsers;
        $docsTotal = $totalMentees;

        // ── Financial Plan Stats ──
        $fpBase = \App\Models\FinancialPlan::whereBetween('created_at', [$from, $to]);
        $fpTotal = (clone $fpBase)->count();
        $fpApproved = (clone $fpBase)->where('status', 'approved')->count();
        $fpAvgReadiness = $fpTotal > 0 ? round((clone $fpBase)->avg('readiness_percentage'), 1) : 0;
        $fpTotalGap = (clone $fpBase)->sum('funding_gap');

        // PSP+Lolos cross-insight
        $pspAndLolos = ScholarshipApplication::where('status', 'lolos')
            ->whereNotNull('psp_application_id')
            ->whereHas('pspApplication', fn ($q) => $q->where('status', 'approved'))
            ->count();

        // ── Line Chart: Scholarship per period ──
        $periods    = $this->linePeriods();
        $lineLabels = array_column($periods, 'label');
        $lineTotal  = $lineLolos = $lineTidakLolos = [];

        foreach ($periods as $p) {
            $base = ScholarshipApplication::whereBetween('updated_date', [$p['from'], $p['to']]);
            $lineTotal[]       = (clone $base)->count();
            $lineLolos[]       = (clone $base)->where('status', 'lolos')->count();
            $lineTidakLolos[]  = (clone $base)->where('status', 'tidak_lolos')->count();
        }

        // ── Doughnut: SA Status ──
        $doughnut = [
            'lolos'       => (clone $saBase)->where('status', 'lolos')->count(),
            'pending'     => (clone $saBase)->where('status', 'pending')->count(),
            'tidak_lolos' => (clone $saBase)->where('status', 'tidak_lolos')->count(),
        ];

        // ── Horizontal Bar: Lolos per Negara ──
        $byCountry = ScholarshipApplication::join('scholarships', 'scholarship_applications.scholarship_id', '=', 'scholarships.id')
            ->selectRaw('scholarships.country, SUM(scholarship_applications.status = "lolos") as lolos, count(*) as total')
            ->whereBetween('scholarship_applications.updated_date', [$from, $to])
            ->whereNotNull('scholarships.country')
            ->groupBy('scholarships.country')
            ->orderByDesc('lolos')
            ->limit(10)
            ->get();

        // ── Pie: PSP Status ──
        $pspPie = PspApplication::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // ── Grouped Bar: Mentoring per Periode (filter-aware) ──
        $mentPeriods  = $this->linePeriods();
        $mentLabels   = $mentDone = $mentPending = $mentCancelled = [];
        foreach ($mentPeriods as $p) {
            $mentLabels[]    = $p['label'];
            $mentDone[]      = MentoringSession::where('status', 'done')
                                ->whereBetween('created_at', [$p['from'], $p['to']])->count();
            $mentPending[]   = MentoringSession::where('status', 'pending')
                                ->whereBetween('created_at', [$p['from'], $p['to']])->count();
            $mentCancelled[] = MentoringSession::where('status', 'cancelled')
                                ->whereBetween('created_at', [$p['from'], $p['to']])->count();
        }

        // ── Table: Top Beasiswa ──
        $topScholarships = ScholarshipApplication::join('scholarships', 'scholarship_applications.scholarship_id', '=', 'scholarships.id')
            ->selectRaw('scholarships.title, scholarships.country, count(*) as total, SUM(scholarship_applications.status="lolos") as lolos')
            ->whereBetween('scholarship_applications.updated_date', [$from, $to])
            ->groupBy('scholarships.id', 'scholarships.title', 'scholarships.country')
            ->orderByDesc('lolos')
            ->limit(10)
            ->get();

        // ── Table: Per Program Studi ──
        $byProgram = ScholarshipApplication::join('program_studies', 'scholarship_applications.program_study_id', '=', 'program_studies.id')
            ->selectRaw('program_studies.name, count(*) as total, SUM(scholarship_applications.status="lolos") as lolos')
            ->whereBetween('scholarship_applications.updated_date', [$from, $to])
            ->groupBy('program_studies.name')
            ->orderByDesc('lolos')
            ->limit(10)
            ->get();

        // ── Table: Mentee Progress (top 15) ──
        try {
            $menteeProgress = User::role('user')
                ->with([
                    'documents',
                    'pspApplication',
                    'sessions',
                    'scholarshipApplications',
                    'financialPlans',
                ])
                ->limit(15)
                ->get()
                ->map(fn ($u) => [
                    'name'         => $u->name,
                    'docs_uploaded' => $u->documents->count(),
                    'docs_approved' => $u->documents->where('status', 'approved')->count(),
                    'docs_total'   => count(Document::REQUIRED_TYPES) + $u->documents->where('category', 'other')->count(),
                    'psp'          => $u->pspApplication?->status ?? '—',
                    'sessions_done'=> $u->sessions->where('status', 'done')->count(),
                    'sessions_total'=> $u->sessions->count(),
                    'sa_lolos'     => $u->scholarshipApplications->where('status', 'lolos')->count(),
                    'fp'           => $u->financialPlans->first()?->status ?? '—',
                ]);
        } catch (\Exception) {
            $menteeProgress = collect();
        }

        // ── Years for filter dropdown ──
        $years = range(date('Y'), date('Y') - 3);

        // ── Monitoring Notifications (Always active, regardless of date filter) ──
        $pendingPsp = PspApplication::where('status', 'submission')->count();
        $pendingDocs = Document::where('status', 'uploaded')->count();
        $pendingMentoring = MentoringSession::where('status', 'pending')->count();

        return compact(
            'totalMentees', 'saLolos', 'saTotal', 'successRate',
            'pspApproved', 'mentoringDone', 'docsApproved', 'pspAndLolos',
            'fpTotal', 'fpApproved', 'fpAvgReadiness', 'fpTotalGap',
            'lineLabels', 'lineTotal', 'lineLolos', 'lineTidakLolos',
            'doughnut',
            'byCountry',
            'pspPie',
            'mentLabels', 'mentDone', 'mentPending', 'mentCancelled',
            'topScholarships', 'byProgram', 'menteeProgress',
            'years', 'toeflLolos', 'docsTotal',
            'pendingPsp', 'pendingDocs', 'pendingMentoring'
        );
    }
}
