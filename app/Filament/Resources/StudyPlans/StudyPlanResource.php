<?php

namespace App\Filament\Resources\StudyPlans;

use App\Filament\Resources\StudyPlans\Pages\CreateStudyPlan;
use App\Filament\Resources\StudyPlans\Pages\EditStudyPlan;
use App\Filament\Resources\StudyPlans\Pages\ListStudyPlans;
use App\Filament\Resources\StudyPlans\Schemas\StudyPlanForm;
use App\Filament\Resources\StudyPlans\Tables\StudyPlansTable;
use App\Models\StudyPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;  
use UnitEnum;

class StudyPlanResource extends Resource
{
    protected static ?string $model = StudyPlan::class;

    protected static string | UnitEnum | null $navigationGroup = 'Study & Scholarship';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static bool $shouldRegisterNavigation = false;
    public static function canViewAny(): bool
    {
        return true;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->check() && auth()->user()->hasRole('mentor')) {
            $mentor = auth()->user()->mentor;
            if ($mentor) {
                $studentIds = $mentor->sessions()->pluck('user_id');
                $query->whereIn('user_id', $studentIds);
            } else {
                $query->where('id', 0);
            }
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return StudyPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudyPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudyPlans::route('/'),
            'create' => CreateStudyPlan::route('/create'),
            'edit' => EditStudyPlan::route('/{record}/edit'),
        ];
    }
}
