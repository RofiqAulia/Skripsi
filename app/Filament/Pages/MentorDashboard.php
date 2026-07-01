<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Livewire\MentorStatsWidget;
use App\Livewire\MentorActionRequiredWidget;
use App\Livewire\MentorMenteesProgressWidget;

class MentorDashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Mentor Dashboard';
    protected static string | \Illuminate\Contracts\Support\Htmlable | null $title = 'Mentor Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('mentor') ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MentorStatsWidget::class,
            MentorActionRequiredWidget::class,
            MentorMenteesProgressWidget::class,
        ];
    }
}
