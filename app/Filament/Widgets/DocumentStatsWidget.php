<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DocumentStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $requiredTypes = array_keys(Document::REQUIRED_TYPES);
        $requiredCount = count($requiredTypes);

        // Total registered users (exclude admin by checking if they DON'T have admin-like roles)
        try {
            $totalUsers = User::role('user')->count();
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // Fallback: count all users
            $totalUsers = User::count();
        }

        // Users with ALL required docs approved
        $fullyApproved = 0;
        $pendingUsers  = 0;
        $revisiDocs  = 0;

        if ($totalUsers > 0) {
            $users = User::with(['documents' => function ($q) use ($requiredTypes) {
                $q->whereIn('type', $requiredTypes);
            }])->get();

            foreach ($users as $user) {
                $approvedTypes = $user->documents
                    ->where('status', 'approved')
                    ->pluck('type')
                    ->unique()
                    ->toArray();

                if (count(array_intersect($approvedTypes, $requiredTypes)) === $requiredCount) {
                    $fullyApproved++;
                }
            }

            $pendingUsers = Document::where('status', 'uploaded')->distinct('user_id')->count('user_id');
            $revisiDocs = Document::where('status', 'revisi')->count();
        }

        $completionPct = $totalUsers > 0 ? round(($fullyApproved / $totalUsers) * 100) : 0;

        // Most missing document type
        $uploadedTypes = Document::whereIn('type', $requiredTypes)
            ->where('status', 'approved')
            ->select('type')
            ->selectRaw('COUNT(DISTINCT user_id) as user_count')
            ->groupBy('type')
            ->pluck('user_count', 'type');

        $mostMissing = null;
        $lowestCount = $totalUsers;
        foreach ($requiredTypes as $type) {
            $count = $uploadedTypes->get($type, 0);
            if ($count < $lowestCount) {
                $lowestCount = $count;
                $mostMissing = Document::typeLabel($type);
            }
        }

        $englishQualified = User::where(function($query) {
            $query->where('toefl_score', '>=', 500)
                  ->orWhere('ielts_score', '>=', 6.5);
        })->count();

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Registered mentoring participants')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Language Qualified', $englishQualified)
                ->description('Users meeting TOEFL/IELTS standard')
                ->icon('heroicon-o-check-badge')
                ->color('success'),

            Stat::make('Document Completion', $completionPct . '%')
                ->description($fullyApproved . ' of ' . $totalUsers . ' users fully approved')
                ->icon('heroicon-o-document-check')
                ->color($completionPct >= 80 ? 'success' : ($completionPct >= 40 ? 'warning' : 'danger')),

            Stat::make('Awaiting Review', $pendingUsers)
                ->description('Users with pending documents')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Revisi Documents', $revisiDocs)
                ->description($mostMissing ? 'Most missing: ' . $mostMissing : 'No missing documents')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
