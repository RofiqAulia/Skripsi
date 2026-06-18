<?php

namespace App\Filament\Resources\MentorSchedules;

use App\Filament\Resources\MentorSchedules\Pages\CreateMentorSchedule;
use App\Filament\Resources\MentorSchedules\Pages\EditMentorSchedule;
use App\Filament\Resources\MentorSchedules\Pages\ListMentorSchedules;
use App\Filament\Resources\MentorSchedules\Schemas\MentorScheduleForm;
use App\Filament\Resources\MentorSchedules\Tables\MentorSchedulesTable;
use App\Models\MentorSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MentorScheduleResource extends Resource
{
    protected static ?string $model = MentorSchedule::class;

    protected static ?int $navigationSort = 2;
    protected static string | UnitEnum | null $navigationGroup = 'Mentoring System';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MentorScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MentorSchedulesTable::configure($table);
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
            'index' => ListMentorSchedules::route('/'),
            'create' => CreateMentorSchedule::route('/create'),
            'edit' => EditMentorSchedule::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('mentor')) {
            $query->where('mentor_id', auth()->user()->mentor->id);
        }

        return $query;
    }
}
