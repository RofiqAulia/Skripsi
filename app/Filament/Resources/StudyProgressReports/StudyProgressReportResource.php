<?php

namespace App\Filament\Resources\StudyProgressReports;

use App\Filament\Resources\StudyProgressReports\Pages\CreateStudyProgressReport;
use App\Filament\Resources\StudyProgressReports\Pages\EditStudyProgressReport;
use App\Filament\Resources\StudyProgressReports\Pages\ListStudyProgressReports;
use App\Filament\Resources\StudyProgressReports\Schemas\StudyProgressReportForm;
use App\Filament\Resources\StudyProgressReports\Tables\StudyProgressReportsTable;
use App\Models\StudyProgressReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudyProgressReportResource extends Resource
{
    protected static ?string $model = StudyProgressReport::class;

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'Study Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Study Progress Reports';
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedRectangleStack;
    }

    public static function form(Schema $schema): Schema
    {
        return StudyProgressReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudyProgressReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('pimpinan')) {
            return $query;
        }

        if ($user->hasRole('mentor')) {
            // Mentor sees their mentees' reports
            return $query->whereHas('user', function ($q) use ($user) {
                $q->whereHas('mentoringSessions', function ($sq) use ($user) {
                    $sq->where('mentor_id', $user->mentor->id ?? null);
                });
            });
        }

        // Mentee sees only their own
        return $query->where('user_id', $user->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudyProgressReports::route('/'),
            'create' => CreateStudyProgressReport::route('/create'),
            'edit' => EditStudyProgressReport::route('/{record}/edit'),
        ];
    }
}
