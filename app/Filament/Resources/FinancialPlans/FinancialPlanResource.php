<?php

namespace App\Filament\Resources\FinancialPlans;

use App\Filament\Resources\FinancialPlans\Pages\CreateFinancialPlan;
use App\Filament\Resources\FinancialPlans\Pages\EditFinancialPlan;
use App\Filament\Resources\FinancialPlans\Pages\ListFinancialPlans;
use App\Filament\Resources\FinancialPlans\Pages\ViewFinancialPlan;
use App\Filament\Resources\FinancialPlans\Schemas\FinancialPlanForm;
use App\Filament\Resources\FinancialPlans\Schemas\FinancialPlanInfolist;
use App\Filament\Resources\FinancialPlans\Tables\FinancialPlansTable;
use App\Models\FinancialPlan;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinancialPlanResource extends Resource
{
    protected static ?string $model = FinancialPlan::class;

    protected static ?int $navigationSort = 4;
    protected static string | UnitEnum | null $navigationGroup = 'Study & Scholarship';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function canCreate(): bool
    {
        return ! auth()->user()->hasRole('pimpinan');
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return ! auth()->user()->hasRole('pimpinan');
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return ! auth()->user()->hasRole('pimpinan');
    }

    protected static ?string $recordTitleAttribute = 'id';
    public static function canViewAny(): bool
    {
        return !auth()->user()->hasRole('mentor');
    }


    public static function form(Schema $schema): Schema
    {
        return FinancialPlanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FinancialPlanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialPlansTable::configure($table);
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
            'index' => ListFinancialPlans::route('/'),
            'create' => CreateFinancialPlan::route('/create'),
            'view' => ViewFinancialPlan::route('/{record}'),
            'edit' => EditFinancialPlan::route('/{record}/edit'),
        ];
    }
}
