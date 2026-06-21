<?php

namespace App\Filament\Resources\ProgramStudies;

use App\Filament\Resources\ProgramStudies\Pages\CreateProgramStudy;
use App\Filament\Resources\ProgramStudies\Pages\EditProgramStudy;
use App\Filament\Resources\ProgramStudies\Pages\ListProgramStudies;
use App\Filament\Resources\ProgramStudies\Schemas\ProgramStudyForm;
use App\Filament\Resources\ProgramStudies\Tables\ProgramStudiesTable;
use App\Models\ProgramStudy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProgramStudyResource extends Resource
{
    protected static ?string $model = ProgramStudy::class;

    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    public static function canViewAny(): bool
    {
        return !auth()->user()->hasRole('mentor');
    }


    public static function form(Schema $schema): Schema
    {
        return ProgramStudyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramStudiesTable::configure($table);
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
            'index' => ListProgramStudies::route('/'),
            'create' => CreateProgramStudy::route('/create'),
            'edit' => EditProgramStudy::route('/{record}/edit'),
        ];
    }
}
