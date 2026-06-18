<?php

namespace App\Filament\Resources\ScholarshipInsights;

use App\Filament\Resources\ScholarshipInsights\Pages\CreateScholarshipInsight;
use App\Filament\Resources\ScholarshipInsights\Pages\EditScholarshipInsight;
use App\Filament\Resources\ScholarshipInsights\Pages\ListScholarshipInsights;
use App\Filament\Resources\ScholarshipInsights\Schemas\ScholarshipInsightForm;
use App\Filament\Resources\ScholarshipInsights\Tables\ScholarshipInsightsTable;
use App\Models\ScholarshipInsight;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ScholarshipInsightResource extends Resource
{
    protected static ?string $model = ScholarshipInsight::class;

    protected static ?int $navigationSort = 1;
    protected static string|UnitEnum|null $navigationGroup = 'Content & Events';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static ?string $navigationLabel = 'Scholarship Insights';
    protected static ?string $modelLabel = 'Scholarship Insight';
    protected static ?string $pluralModelLabel = 'Scholarship Insights';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ScholarshipInsightForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScholarshipInsightsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListScholarshipInsights::route('/'),
            'create' => CreateScholarshipInsight::route('/create'),
            'edit'   => EditScholarshipInsight::route('/{record}/edit'),
        ];
    }

    /**
     * Restrict access to Super Admin only.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }
}
