<?php

namespace App\Filament\Resources\ScholarshipApplications;

use App\Filament\Resources\ScholarshipApplications\Pages\CreateScholarshipApplication;
use App\Filament\Resources\ScholarshipApplications\Pages\EditScholarshipApplication;
use App\Filament\Resources\ScholarshipApplications\Pages\ListScholarshipApplications;
use App\Filament\Resources\ScholarshipApplications\Schemas\ScholarshipApplicationForm;
use App\Filament\Resources\ScholarshipApplications\Tables\ScholarshipApplicationsTable;
use App\Models\ScholarshipApplication;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScholarshipApplicationResource extends Resource
{
    protected static ?string $model = ScholarshipApplication::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Study & Scholarship';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $navigationLabel = 'Applications';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return ! auth()->user()->hasAnyRole(['pimpinan', 'mentor']);
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return ! auth()->user()->hasAnyRole(['pimpinan', 'mentor']);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return ! auth()->user()->hasAnyRole(['pimpinan', 'mentor']);
    }
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
        return ScholarshipApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScholarshipApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListScholarshipApplications::route('/'),
            'create' => CreateScholarshipApplication::route('/create'),
            'edit'   => EditScholarshipApplication::route('/{record}/edit'),
        ];
    }
}
