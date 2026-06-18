<?php

namespace App\Filament\Resources\MentoringReports;

use App\Filament\Resources\MentoringReports\Pages\CreateMentoringReport;
use App\Filament\Resources\MentoringReports\Pages\EditMentoringReport;
use App\Filament\Resources\MentoringReports\Pages\ListMentoringReports;
use App\Filament\Resources\MentoringReports\Schemas\MentoringReportForm;
use App\Filament\Resources\MentoringReports\Tables\MentoringReportsTable;
use App\Models\MentoringReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MentoringReportResource extends Resource
{
    protected static ?string $model = MentoringReport::class;

    protected static ?int $navigationSort = 4;
    protected static string | UnitEnum | null $navigationGroup = 'Mentoring System';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MentoringReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MentoringReportsTable::configure($table);
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
            'index' => ListMentoringReports::route('/'),
            'create' => CreateMentoringReport::route('/create'),
            'edit' => EditMentoringReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('mentor')) {
            $query->whereHas('session', function ($q) {
                $q->where('mentor_id', auth()->user()->mentor->id);
            });
        }

        return $query;
    }
}
