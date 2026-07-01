<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\MentoringSession;
use App\Models\MentoringReport;

class MentorStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $mentorId = auth()->user()?->mentor?->id;
        
        if (!$mentorId) {
            return [];
        }

        $totalMentees = MentoringSession::where('mentor_id', $mentorId)->distinct('user_id')->count('user_id');
        $sessionsCompleted = MentoringSession::where('mentor_id', $mentorId)->where('status', 'done')->count();
        $upcomingSessions = MentoringSession::where('mentor_id', $mentorId)->where('status', 'scheduled')->count();
        
        $reportsToReview = MentoringReport::whereHas('session', function($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->where('status', MentoringReport::STATUS_UNDER_REVIEW)->count();

        return [
            Stat::make('Total Mentees', $totalMentees)
                ->description('Total active mentees assigned')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Sessions Completed', $sessionsCompleted)
                ->description('Total completed sessions')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Upcoming Sessions', $upcomingSessions)
                ->description('Scheduled meetings')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Reports to Review', $reportsToReview)
                ->description('Needs your action')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($reportsToReview > 0 ? 'warning' : 'gray'),
        ];
    }
}
