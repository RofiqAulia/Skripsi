<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MentorDashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Mentor Dashboard';
    protected static ?string $title = 'Mentor Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected string $view = 'filament.pages.mentor-dashboard';

    public int $selectedYear;
    public string $selectedMonth = '';

    public function mount(): void
    {
        $this->selectedYear = (int) date('Y');
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('mentor') ?? false;
    }
}
