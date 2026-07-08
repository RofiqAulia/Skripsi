<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\MentoringSession;
use App\Models\MentoringReport;
use Livewire\Attributes\Reactive;
use Carbon\Carbon;

class MentorStatsWidget extends StatsOverviewWidget
{
    #[Reactive]
    public int $selectedYear;

    #[Reactive]
    public string $selectedMonth = '';

    protected function dateRange(): array
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

    protected function getStats(): array
    {
        $mentorId = auth()->user()?->mentor?->id;
        
        if (!$mentorId) {
            return [];
        }

        [$from, $to] = $this->dateRange();

        $totalMentees = MentoringSession::where('mentor_id', $mentorId)->distinct('user_id')->count('user_id');
        
        $sessionsCompleted = MentoringSession::where('mentor_id', $mentorId)
            ->where('status', 'done')
            ->whereBetween('created_at', [$from, $to])
            ->count();
            
        $upcomingSessions = MentoringSession::where('mentor_id', $mentorId)
            ->where('status', 'scheduled')
            ->whereBetween('created_at', [$from, $to])
            ->count();
        
        $reportsToReview = MentoringReport::whereHas('session', function($q) use ($mentorId, $from, $to) {
            $q->where('mentor_id', $mentorId)
              ->whereBetween('created_at', [$from, $to]);
        })->where('status', MentoringReport::STATUS_UNDER_REVIEW)->count();

        return [
            Stat::make('Total Mentees', $totalMentees)
                ->description('Total active mentees assigned')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Sessions Completed', $sessionsCompleted)
                ->description('Completed in selected period')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Upcoming Sessions', $upcomingSessions)
                ->description('Scheduled in selected period')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Reports to Review', $reportsToReview)
                ->description('Needs your action (selected period)')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($reportsToReview > 0 ? 'warning' : 'gray'),
        ];
    }
}
