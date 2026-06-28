<?php

namespace App\Filament\Resources\PspApplications;

use App\Filament\Resources\PspApplications\Pages\CreatePspApplication;
use App\Filament\Resources\PspApplications\Pages\EditPspApplication;
use App\Filament\Resources\PspApplications\Pages\ListPspApplications;
use App\Filament\Resources\PspApplications\Schemas\PspApplicationForm;
use App\Filament\Resources\PspApplications\Tables\PspApplicationsTable;
use App\Models\PspApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PspApplicationResource extends Resource
{
    protected static ?string $model = PspApplication::class;

    protected static string | UnitEnum | null $navigationGroup = 'Study & Scholarship';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
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
        return PspApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PspApplicationsTable::configure($table);
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
            'index' => ListPspApplications::route('/'),
            'create' => CreatePspApplication::route('/create'),
            'edit' => EditPspApplication::route('/{record}/edit'),
        ];
    }
}
