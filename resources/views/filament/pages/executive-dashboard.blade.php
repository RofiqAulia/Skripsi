<x-filament-panels::page>

{{-- ══════════════════════════════════════════════════════
     FILTER BAR
══════════════════════════════════════════════════════ --}}
<div class="ed-filter-bar">
    <span class="ed-filter-label">
        <x-heroicon-m-funnel style="width: 1.25rem; height: 1.25rem; color: #3b82f6;"/> 
        Filter Period:
    </span>
    <div class="ed-filter-group">
        <select wire:model.live="selectedYear" class="ed-select">
            @foreach($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
        <select wire:model.live="selectedMonth" class="ed-select">
            <option value="">All Months</option>
            @foreach(['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $num => $name)
                <option value="{{ $num }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <span class="ed-filter-period-info">
        Showing data:
        <strong>
            @if($selectedMonth)
                {{ ['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'][$selectedMonth] }}
            @else All Months
            @endif
            {{ $selectedYear }}
        </strong>
    </span>
</div>

{{-- ══════════════════════════════════════════════════════
     MONITORING NOTIFICATIONS
══════════════════════════════════════════════════════ --}}
@if($pendingPsp > 0 || $pendingDocs > 0 || $pendingMentoring > 0 || $pendingFinancialPlan > 0 || $pendingProgramStudy > 0)
    <div class="ed-notifications mb-4">
        @if($pendingPsp > 0)
            <div class="ed-alert alert-amber">
                <div class="ed-alert-icon"><x-heroicon-s-exclamation-triangle style="width:1.25rem;height:1.25rem;"/></div>
                <div class="ed-alert-body">
                    <strong>There are PSPs requiring follow-up</strong> ({{ $pendingPsp }} pending)
                </div>
                <a href="{{ url('/admin/psp-applications') }}" class="ed-alert-action">Follow Up &rarr;</a>
            </div>
        @endif
        
        @if($pendingDocs > 0)
            <div class="ed-alert alert-sky">
                <div class="ed-alert-icon"><x-heroicon-s-document-text style="width:1.25rem;height:1.25rem;"/></div>
                <div class="ed-alert-body">
                    <strong>There are documents requiring follow-up</strong> ({{ $pendingDocs }} pending)
                </div>
                <a href="{{ url('/admin/documents') }}" class="ed-alert-action">Follow Up &rarr;</a>
            </div>
        @endif
        
        @if($pendingMentoring > 0)
            <div class="ed-alert alert-fuchsia">
                <div class="ed-alert-icon"><x-heroicon-s-video-camera style="width:1.25rem;height:1.25rem;"/></div>
                <div class="ed-alert-body">
                    <strong>There are mentoring sessions requiring follow-up</strong> ({{ $pendingMentoring }} pending)
                </div>
                <a href="{{ url('/admin/mentoring-sessions') }}" class="ed-alert-action">Follow Up &rarr;</a>
            </div>
        @endif

        @if($pendingFinancialPlan > 0)
            <div class="ed-alert alert-teal">
                <div class="ed-alert-icon"><x-heroicon-s-wallet style="width:1.25rem;height:1.25rem;"/></div>
                <div class="ed-alert-body">
                    <strong>There are Financial Plans requiring follow-up</strong> ({{ $pendingFinancialPlan }} pending)
                </div>
                <a href="{{ url('/admin/financial-plans') }}" class="ed-alert-action">Follow Up &rarr;</a>
            </div>
        @endif

        @if($pendingProgramStudy > 0)
            <div class="ed-alert alert-indigo">
                <div class="ed-alert-icon"><x-heroicon-s-academic-cap style="width:1.25rem;height:1.25rem;"/></div>
                <div class="ed-alert-body">
                    <strong>There are Program Studies requiring follow-up</strong> ({{ $pendingProgramStudy }} pending)
                </div>
                <a href="{{ url('/admin/program-studies') }}" class="ed-alert-action">Follow Up &rarr;</a>
            </div>
        @endif
    </div>
@endif

{{-- ══════════════════════════════════════════════════════
     KPI CARDS
══════════════════════════════════════════════════════ --}}
<div class="ed-kpi-grid">
    <!-- 1. JUMLAH PESERTA TERDAFTAR -->
    <div class="ed-kpi accent-indigo">
        <div class="ed-kpi-icon"><x-heroicon-o-users style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>REGISTERED MENTEES</span>
            <h2>{{ $totalMentees }}</h2>
            <small>Mentees registered</small>
        </div>
    </div>

    <!-- 2. JUMLAH LOLOS APPROVE PSP -->
    <div class="ed-kpi accent-amber">
        <div class="ed-kpi-icon"><x-heroicon-o-document-check style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>APPROVED PSP</span>
            <h2>{{ $pspApproved }} / {{ $totalMentees }}</h2>
            <small>{{ $pspPct }}% dari mentee registered</small>
        </div>
    </div>

    <!-- 3. JUMLAH PESERTA LOLOS TOEFL/IELTS STATUS ACCEPTED -->
    <div class="ed-kpi accent-sky">
        <div class="ed-kpi-icon"><x-heroicon-o-academic-cap style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>PASSED TOEFL / IELTS</span>
            <h2>{{ $toeflLolos }} / {{ $totalMentees }}</h2>
            <small>{{ $toeflPct }}% dari mentee registered</small>
        </div>
    </div>

    <!-- 4. DOCUMENT PROGRESS -->
    <div class="ed-kpi accent-orange">
        <div class="ed-kpi-icon"><x-heroicon-o-document-text style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>DOCUMENT PROGRESS</span>
            <h2>{{ $docsApproved }} / {{ $totalMentees }}</h2>
            <small>{{ $docsPct }}% dari mentee registered - individuals users with 100% submissions approve</small>
        </div>
    </div>

    <!-- 5. MENTORING SESSIONS -->
    <div class="ed-kpi accent-fuchsia">
        <div class="ed-kpi-icon"><x-heroicon-o-video-camera style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>MENTORING SESSIONS</span>
            <h2>{{ $mentoringDone }}</h2>
            <small>sessions completed (done)</small>
        </div>
    </div>

    <!-- 6. SCHOLARSHIP ACCEPTED -->
    <div class="ed-kpi accent-emerald">
        <div class="ed-kpi-icon"><x-heroicon-o-trophy style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>SCHOLARSHIP ACCEPTED</span>
            <h2>{{ $saLolos }} / {{ $totalMentees }}</h2>
            <small>{{ $saPct }}% dari mentee registered</small>
        </div>
    </div>

    <!-- 7. FINANCIAL PLAN -->
    <div class="ed-kpi accent-teal">
        <div class="ed-kpi-icon"><x-heroicon-o-wallet style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>FINANCIAL PLAN</span>
            <h2>{{ $fpApproved }} / {{ $saLolos }}</h2>
            <small>{{ $fpPct }}% dari scholarship accepted</small>
        </div>
    </div>

    <!-- 8. SUCCESS RATE -->
    <div class="ed-kpi accent-rose">
        <div class="ed-kpi-icon"><x-heroicon-o-chart-pie style="width:2rem;height:2rem;"/></div>
        <div class="ed-kpi-body">
            <span>OVERALL PROGRESS</span>
            <h2>{{ $overallProgress }}%</h2>
            <small>Average across milestones</small>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     ROW 1: Line Chart + Doughnut Chart
══════════════════════════════════════════════════════ --}}
<div class="ed-row">
    <div class="ed-panel ed-panel-wide">
        <h3><x-heroicon-m-presentation-chart-line style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Scholarship Applications per Period
            <small style="font-weight:400;color:var(--text-muted);font-size:.8rem;margin-left:auto;">
                ({{ $selectedMonth ? (['1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'][$selectedMonth] ?? '') . ' ' . $selectedYear : $selectedYear }})
            </small>
        </h3>
        <div style="position:relative;height:260px;">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <div class="ed-panel ed-panel-narrow">
        <h3><x-heroicon-m-chart-pie style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Scholarship Status</h3>
        <div style="position:relative;height:220px;display:flex;justify-content:center;">
            <canvas id="doughnutChart"></canvas>
        </div>
        <div class="ed-legend">
            <span><span class="dot dot-emerald"></span> Accepted: {{ $doughnut['lolos'] }}</span>
            <span><span class="dot dot-amber"></span> Pending: {{ $doughnut['pending'] }}</span>
            <span><span class="dot dot-rose"></span> Rejected: {{ $doughnut['tidak_lolos'] }}</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     ROW 2: Horizontal Bar (Negara) + Pie (PSP)
══════════════════════════════════════════════════════ --}}
<div class="ed-row">
    <div class="ed-panel ed-panel-wide">
        <h3><x-heroicon-m-globe-alt style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Accepted Scholarships by Destination Country
            <small style="font-weight:400;color:var(--text-muted);font-size:.8rem;margin-left:auto;">
                ({{ $selectedMonth ? (['1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'][$selectedMonth] ?? '') . ' ' . $selectedYear : $selectedYear }})
            </small>
        </h3>
        <div style="position:relative;height:260px;">
            <canvas id="countryBarChart"></canvas>
        </div>
    </div>
    <div class="ed-panel ed-panel-narrow">
        <h3><x-heroicon-m-document-chart-bar style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> PSP Status Distribution</h3>
        <div style="position:relative;height:220px;display:flex;justify-content:center;">
            <canvas id="pspPieChart"></canvas>
        </div>
        <div class="ed-legend">
            @foreach($pspPie as $status => $count)
            <span>
                <span class="dot" style="background:{{ ['submission'=>'#3b82f6','review'=>'#f59e0b','approved'=>'#10b981','rejected'=>'#f43f5e'][$status] ?? '#94a3b8' }}"></span>
                {{ ucfirst($status) }}: {{ $count }}
            </span>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     ROW 3: Grouped Bar — Mentoring per Bulan (full width)
══════════════════════════════════════════════════════ --}}
<div class="ed-panel">
    <h3><x-heroicon-m-chart-bar style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Mentoring Sessions per Period
        <small style="font-weight:400;color:var(--text-muted);font-size:.8rem;margin-left:auto;">
            ({{ $selectedMonth ? (['1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'][$selectedMonth] ?? '') . ' ' . $selectedYear : 'All Months ' . $selectedYear }})
        </small>
    </h3>
    <div style="position:relative;height:240px;">
        <canvas id="mentoringBarChart"></canvas>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TABLES ROW
══════════════════════════════════════════════════════ --}}
<div class="ed-row">
    {{-- Top Scholarships --}}
    <div class="ed-panel" style="padding:0;overflow:hidden;">
        <h3 style="padding:1.5rem 1.5rem 0.5rem;margin:0;"><x-heroicon-m-academic-cap style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Top Scholarships</h3>
        <div class="ed-table-wrap">
            <table class="ed-table">
                <thead><tr><th>Scholarship</th><th>Country</th><th style="text-align:center;">Total</th><th style="text-align:center;">Accepted</th><th>Rate</th></tr></thead>
                <tbody>
                    @forelse($topScholarships as $row)
                    @php $rate = $row->total > 0 ? round($row->lolos/$row->total*100) : 0; @endphp
                    <tr>
                        <td style="font-weight:500;">{{ Str::limit($row->title, 28) }}</td>
                        <td style="color:var(--text-muted);">{{ $row->country ?: '—' }}</td>
                        <td style="text-align:center;">{{ $row->total }}</td>
                        <td style="text-align:center;"><x-filament::badge color="success">{{ $row->lolos }}</x-filament::badge></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div class="ed-mini-bar"><div class="ed-mini-fill" style="width:{{ $rate }}%;background:#10b981;"></div></div>
                                <small style="color:var(--text-muted);">{{ $rate }}%</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="ed-empty-row">No data for this period</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Per Study Program --}}
    <div class="ed-panel" style="padding:0;overflow:hidden;">
        <h3 style="padding:1.5rem 1.5rem 0.5rem;margin:0;"><x-heroicon-m-book-open style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> By Study Program</h3>
        <div class="ed-table-wrap">
            <table class="ed-table">
                <thead><tr><th>Study Program</th><th style="text-align:center;">Total</th><th style="text-align:center;">Accepted</th><th>Rate</th></tr></thead>
                <tbody>
                    @forelse($byProgram as $row)
                    @php $rate = $row->total > 0 ? round($row->lolos/$row->total*100) : 0; @endphp
                    <tr>
                        <td style="font-weight:500;">{{ Str::limit($row->name, 30) }}</td>
                        <td style="text-align:center;">{{ $row->total }}</td>
                        <td style="text-align:center;"><x-filament::badge color="success">{{ $row->lolos }}</x-filament::badge></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div class="ed-mini-bar"><div class="ed-mini-fill" style="width:{{ $rate }}%;background:#10b981;"></div></div>
                                <small style="color:var(--text-muted);">{{ $rate }}%</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="ed-empty-row">No data for this period</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MENTEE PROGRESS TABLE (full width)
══════════════════════════════════════════════════════ --}}
<div class="ed-panel" style="padding:0;overflow:hidden;">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1.5rem 1.5rem 0.5rem;">
        <h3 style="margin:0;"><x-heroicon-m-user-group style="width:1.25rem;height:1.25rem;color:#3b82f6;"/> Individual Mentee Progress</h3>
        <span style="font-size:0.75rem;background:var(--bg-muted);padding:.2rem .5rem;border-radius:4px;color:var(--text-muted);">Top 15</span>
    </div>
    <div class="ed-table-wrap">
        <table class="ed-table">
            <thead>
                <tr>
                    <th style="text-align:center;width:3rem;">#</th>
                    <th>Mentee Name</th>
                    <th style="text-align:center;">Documents</th>
                    <th style="text-align:center;">PSP Status</th>
                    <th style="text-align:center;">Mentoring Sessions</th>
                    <th style="text-align:center;">Scholarships Accepted</th>
                    <th style="text-align:center;">Financial Plan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menteeProgress as $i => $m)
                <tr>
                    <td style="text-align:center;color:var(--text-muted);">{{ $i + 1 }}</td>
                    <td style="font-weight:500;">{{ $m['name'] }}</td>
                    <td style="text-align:center;">
                        @php
                            $docsColor = $m['docs_uploaded'] === $m['docs_total'] ? 'success' : ($m['docs_uploaded'] > 0 ? 'warning' : 'gray');
                        @endphp
                        <x-filament::badge :color="$docsColor">
                            {{ $m['docs_uploaded'] }}/{{ $m['docs_total'] }}
                        </x-filament::badge>
                    </td>
                    <td style="text-align:center;">
                        @php
                            $pspColor = ['approved'=>'success','rejected'=>'danger','review'=>'warning','submission'=>'info'][$m['psp']] ?? 'gray';
                        @endphp
                        <x-filament::badge :color="$pspColor">{{ Str::ucfirst($m['psp']) }}</x-filament::badge>
                    </td>
                    <td style="text-align:center;">
                        @php
                            $sessColor = $m['sessions_done'] > 0 ? 'info' : 'gray';
                        @endphp
                        <x-filament::badge :color="$sessColor">
                            {{ $m['sessions_done'] }}/{{ $m['sessions_total'] }}
                        </x-filament::badge>
                    </td>
                    <td style="text-align:center;">
                        @if($m['sa_lolos'] > 0)
                            <x-filament::badge color="success" icon="heroicon-s-trophy">
                                {{ $m['sa_lolos'] }}
                            </x-filament::badge>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @php
                            $fpColor = match($m['fp']) {
                                'approved' => 'success',
                                'revision_needed' => 'danger',
                                'under_review' => 'warning',
                                'submitted' => 'info',
                                'draft' => 'gray',
                                default => 'gray'
                            };
                        @endphp
                        <x-filament::badge :color="$fpColor">{{ Str::ucfirst(str_replace('_', ' ', $m['fp'])) }}</x-filament::badge>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="ed-empty-row">No mentee data available</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     CHART.JS INITIALIZATION
══════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        initCharts();
    });
    
    // Listen for dark mode toggle to re-render charts with correct colors
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                initCharts();
            }
        });
    });
    observer.observe(document.documentElement, { attributes: true });

    let charts = {};

    function initCharts() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#a1a1aa' : '#71717a'; // zinc-400 vs zinc-500
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

        Chart.defaults.color = textColor;
        Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { labels: { color: textColor } } }
        };

        const gridOptions = {
            color: gridColor,
            tickColor: gridColor,
            borderColor: gridColor
        };

        // Destroy existing charts before re-initializing
        Object.values(charts).forEach(chart => chart.destroy());

        // Data from PHP
        const lineLabels    = @json($lineLabels);
        const lineTotal     = @json($lineTotal);
        const lineLolos     = @json($lineLolos);
        const lineTidakLolos = @json($lineTidakLolos);

        const doughnutData  = [@json($doughnut['lolos']), @json($doughnut['pending']), @json($doughnut['tidak_lolos'])];

        const countryLabels = @json($byCountry->pluck('country'));
        const countryLolos  = @json($byCountry->pluck('lolos'));
        const countryTotal  = @json($byCountry->pluck('total'));

        const pspLabels     = @json(array_keys($pspPie));
        const pspValues     = @json(array_values($pspPie));

        const mentLabels    = @json($mentLabels);
        const mentDone      = @json($mentDone);
        const mentPending   = @json($mentPending);
        const mentCancelled = @json($mentCancelled);

        // 1. LINE CHART
        charts.lineChart = new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [
                    { label: 'Total', data: lineTotal, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.08)', tension: 0.4, fill: true, pointRadius: 4, pointHoverRadius: 6 },
                    { label: 'Accepted', data: lineLolos, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.08)', tension: 0.4, fill: true, pointRadius: 4, pointHoverRadius: 6 },
                    { label: 'Rejected', data: lineTidakLolos, borderColor: '#f43f5e', backgroundColor: 'rgba(244,63,94,0.06)', tension: 0.4, fill: true, pointRadius: 4, pointHoverRadius: 6 },
                ]
            },
            options: { 
                ...commonOptions, 
                scales: { 
                    x: { grid: gridOptions, ticks: { color: textColor } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: textColor }, grid: gridOptions } 
                } 
            }
        });

        // 2. DOUGHNUT CHART
        charts.doughnutChart = new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Pending', 'Rejected'],
                datasets: [{ 
                    data: doughnutData, 
                    backgroundColor: ['#10b981','#f59e0b','#f43f5e'], 
                    borderWidth: 2, 
                    borderColor: isDark ? '#18181b' : '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: { ...commonOptions, plugins: { legend: { display: false } }, cutout: '70%' }
        });

        // 3. HORIZONTAL BAR: Country
        charts.countryBarChart = new Chart(document.getElementById('countryBarChart'), {
            type: 'bar',
            data: {
                labels: countryLabels,
                datasets: [
                    { label: 'Accepted', data: countryLolos, backgroundColor: '#10b981', borderRadius: 4 },
                    { label: 'Total', data: countryTotal, backgroundColor: isDark ? '#3f3f46' : '#e4e4e7', borderRadius: 4 },
                ]
            },
            options: {
                indexAxis: 'y',
                ...commonOptions,
                scales: { 
                    x: { beginAtZero: true, ticks: { stepSize: 1, color: textColor }, grid: gridOptions },
                    y: { grid: gridOptions, ticks: { color: textColor } }
                }
            }
        });

        // 4. PIE CHART: PSP
        charts.pspPieChart = new Chart(document.getElementById('pspPieChart'), {
            type: 'pie',
            data: {
                labels: pspLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                datasets: [{
                    data: pspValues,
                    backgroundColor: ['#3b82f6','#f59e0b','#10b981','#ef4444'],
                    borderWidth: 2, 
                    borderColor: isDark ? '#18181b' : '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: { ...commonOptions, plugins: { legend: { display: false } } }
        });

        // 5. GROUPED BAR: Mentoring
        charts.mentoringBarChart = new Chart(document.getElementById('mentoringBarChart'), {
            type: 'bar',
            data: {
                labels: mentLabels,
                datasets: [
                    { label: 'Done', data: mentDone, backgroundColor: '#10b981', borderRadius: 4 },
                    { label: 'Pending', data: mentPending, backgroundColor: '#f59e0b', borderRadius: 4 },
                    { label: 'Cancelled', data: mentCancelled, backgroundColor: '#f43f5e', borderRadius: 4 },
                ]
            },
            options: { 
                ...commonOptions, 
                scales: { 
                    x: { stacked: false, grid: gridOptions, ticks: { color: textColor } }, 
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: textColor }, grid: gridOptions } 
                } 
            }
        });
    }
    
    if (typeof Chart !== 'undefined') {
        initCharts();
    }
</script>

{{-- ══════════════════════════════════════════════════════
     STYLES (Standalone & Dark Mode Compatible)
══════════════════════════════════════════════════════ --}}
<style>
    /* CSS Variables for Light/Dark Mode */
    :root {
        --bg-panel: #ffffff;
        --bg-body: #f8fafc;
        --bg-muted: #f1f5f9;
        --border-color: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --ring-color: rgba(0,0,0,0.05);
    }
    .dark {
        --bg-panel: #18181b; /* zinc-900 */
        --bg-body: #09090b; /* zinc-950 */
        --bg-muted: rgba(255,255,255,0.05);
        --border-color: rgba(255,255,255,0.1);
        --text-main: #f4f4f5; /* zinc-100 */
        --text-muted: #a1a1aa; /* zinc-400 */
        --ring-color: rgba(255,255,255,0.1);
    }

    /* Alerts / Notifications */
    .ed-notifications { display: flex; flex-direction: column; gap: 0.75rem; }
    .ed-alert { 
        display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; 
        border-radius: 0.75rem; border-left: 4px solid transparent; 
        background: var(--bg-panel); font-size: 0.875rem; color: var(--text-main);
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border: 1px solid var(--border-color);
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
    .ed-alert-icon { display: flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; flex-shrink: 0; }
    .ed-alert-body { flex-grow: 1; display: flex; align-items: center; gap: 0.5rem; }
    .ed-alert-body strong { color: var(--text-main); font-weight: 600; }
    .ed-alert-action { font-weight: 600; text-decoration: none; padding: 0.35rem 0.75rem; border-radius: 0.5rem; transition: background 0.2s; white-space: nowrap; }
    
    .alert-amber { border-left-color: #f59e0b; }
    .alert-amber .ed-alert-icon { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .alert-amber .ed-alert-action { color: #d97706; background: rgba(245,158,11,0.1); }
    .alert-amber .ed-alert-action:hover { background: rgba(245,158,11,0.2); }
    
    .alert-sky { border-left-color: #0ea5e9; }
    .alert-sky .ed-alert-icon { background: rgba(14,165,233,0.1); color: #0ea5e9; }
    .alert-sky .ed-alert-action { color: #0284c7; background: rgba(14,165,233,0.1); }
    .alert-sky .ed-alert-action:hover { background: rgba(14,165,233,0.2); }
    
    .alert-fuchsia { border-left-color: #d946ef; }
    .alert-fuchsia .ed-alert-icon { background: rgba(217,70,239,0.1); color: #d946ef; }
    .alert-fuchsia .ed-alert-action { color: #c026d3; background: rgba(217,70,239,0.1); }
    .alert-fuchsia .ed-alert-action:hover { background: rgba(217,70,239,0.2); }

    .alert-teal { border-left-color: #14b8a6; }
    .alert-teal .ed-alert-icon { background: rgba(20,184,166,0.1); color: #14b8a6; }
    .alert-teal .ed-alert-action { color: #0f766e; background: rgba(20,184,166,0.1); }
    .alert-teal .ed-alert-action:hover { background: rgba(20,184,166,0.2); }

    .alert-indigo { border-left-color: #6366f1; }
    .alert-indigo .ed-alert-icon { background: rgba(99,102,241,0.1); color: #6366f1; }
    .alert-indigo .ed-alert-action { color: #4338ca; background: rgba(99,102,241,0.1); }
    .alert-indigo .ed-alert-action:hover { background: rgba(99,102,241,0.2); }

    /* Filter Bar */
    .ed-filter-bar {
        display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
        background: var(--bg-panel); border-radius: 0.75rem; padding: 1rem 1.5rem;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border: 1px solid var(--border-color);
        margin-bottom: 1.5rem; color: var(--text-main);
    }
    .ed-filter-label { font-weight: 600; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
    .ed-filter-group { display: flex; gap: 0.75rem; align-items: center; }
    .ed-select {
        padding: 0.5rem 2rem 0.5rem 1rem; border: 1px solid var(--border-color);
        border-radius: 0.5rem; font-size: 0.875rem; color: var(--text-main);
        background: var(--bg-panel); cursor: pointer; transition: all .2s; outline: none;
    }
    .ed-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 1px #3b82f6; }
    .ed-filter-period-info { font-size: 0.875rem; color: var(--text-muted); background: var(--bg-muted); padding: 0.35rem 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-color); }
    .ed-filter-period-info strong { color: var(--text-main); margin-left: 0.25rem; }

    /* KPI Grid */
    .ed-kpi-grid {
        display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width: 1024px){ .ed-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media(max-width: 640px){ .ed-kpi-grid { grid-template-columns: repeat(1, minmax(0, 1fr)); } }

    .ed-kpi {
        background: var(--bg-panel); border-radius: 0.75rem; padding: 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border: 1px solid var(--border-color);
        border-top: 4px solid transparent; transition: transform .2s; color: var(--text-main);
    }
    .ed-kpi:hover { transform: translateY(-2px); }
    .ed-kpi.accent-indigo { border-top-color: #6366f1; }
    .ed-kpi.accent-emerald{ border-top-color: #10b981; }
    .ed-kpi.accent-rose   { border-top-color: #f43f5e; }
    .ed-kpi.accent-amber  { border-top-color: #f59e0b; }
    .ed-kpi.accent-sky    { border-top-color: #0ea5e9; }
    .ed-kpi.accent-fuchsia{ border-top-color: #d946ef; }
    .ed-kpi.accent-teal   { border-top-color: #14b8a6; }
    .ed-kpi.accent-orange { border-top-color: #f97316; }

    .ed-kpi-icon { padding: 0.5rem; border-radius: 0.5rem; flex-shrink: 0; display:flex; align-items:center; justify-content:center; }
    .accent-indigo .ed-kpi-icon { background: rgba(99,102,241,0.1); color: #6366f1; }
    .accent-emerald .ed-kpi-icon{ background: rgba(16,185,129,0.1); color: #10b981; }
    .accent-rose .ed-kpi-icon   { background: rgba(244,63,94,0.1); color: #f43f5e; }
    .accent-amber .ed-kpi-icon  { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .accent-sky .ed-kpi-icon    { background: rgba(14,165,233,0.1); color: #0ea5e9; }
    .accent-fuchsia .ed-kpi-icon{ background: rgba(217,70,239,0.1); color: #d946ef; }
    .accent-teal .ed-kpi-icon   { background: rgba(20,184,166,0.1); color: #14b8a6; }
    .accent-orange .ed-kpi-icon { background: rgba(249,115,22,0.1); color: #f97316; }

    .ed-kpi-body span  { font-size: 0.7rem; color: var(--text-muted); display: block; font-weight: 600; letter-spacing: 0.05em; }
    .ed-kpi-body h2    { font-size: 1.5rem; font-weight: 700; margin: 0.2rem 0; line-height: 1.2; }
    .ed-kpi-body small { font-size: 0.75rem; color: var(--text-muted); }

    /* Panels */
    .ed-panel {
        background: var(--bg-panel); border-radius: 0.75rem; padding: 1.5rem;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border: 1px solid var(--border-color);
        margin-bottom: 1.5rem; color: var(--text-main);
    }
    .ed-panel h3 {
        font-size: 1rem; font-weight: 600; margin: 0 0 1.25rem; display: flex; align-items: center; gap: 0.5rem;
    }

    /* Row layout */
    .ed-row { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 0; }
    @media(max-width: 1024px) { .ed-row { grid-template-columns: 1fr; } }
    .ed-panel-wide  { }
    .ed-panel-narrow { }

    /* Legend */
    .ed-legend { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted); }
    .ed-legend span { display: flex; align-items: center; gap: 0.35rem; }
    .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    .dot-emerald { background: #10b981; }
    .dot-amber { background: #f59e0b; }
    .dot-rose { background: #f43f5e; }

    /* Tables */
    .ed-table-wrap { overflow-x: auto; }
    .ed-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left; }
    .ed-table thead tr { background: var(--bg-muted); }
    .ed-table th { padding: 0.75rem 1.5rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border-color); white-space: nowrap; }
    .ed-table td { padding: 0.75rem 1.5rem; border-bottom: 1px solid var(--border-color); color: var(--text-main); }
    .ed-table tbody tr { transition: background-color 0.1s; }
    .ed-table tbody tr:hover { background: var(--bg-muted); }
    .ed-empty-row { text-align: center; color: var(--text-muted); padding: 2rem; }

    /* Mini Bar */
    .ed-mini-bar { height: 6px; background: var(--bg-muted); border-radius: 9999px; margin-bottom: 2px; min-width: 60px; width: 100%; flex-grow: 1; }
    .ed-mini-fill { height: 100%; border-radius: 9999px; }
</style>

</x-filament-panels::page>
