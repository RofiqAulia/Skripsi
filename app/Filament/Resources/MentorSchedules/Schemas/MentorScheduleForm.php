<?php

namespace App\Filament\Resources\MentorSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class MentorScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mentor_id')
                    ->label('Mentor')
                    ->relationship('mentor', 'id') // tetap pakai relasi dasar
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name)
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date')
                    ->required(),

                TimePicker::make('start_time')
                    ->required(),

                TimePicker::make('end_time')
                    ->required(),
            ]);
    }
}
