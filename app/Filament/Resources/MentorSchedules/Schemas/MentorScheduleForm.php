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
                    ->required()
                    ->default(fn () => auth()->user()->mentor?->id)
                    ->disabled(fn () => auth()->user()->hasRole('mentor'))
                    ->dehydrated(),

                DatePicker::make('date')
                    ->required()
                    ->minDate(now()->startOfDay()),

                TimePicker::make('start_time')
                    ->required(),

                TimePicker::make('end_time')
                    ->required()
                    ->after('start_time')
                    ->rule(function (\Filament\Schemas\Components\Utilities\Get $get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            $date = $get('date');
                            if ($date && $value) {
                                $dateTime = \Carbon\Carbon::parse($date . ' ' . $value, 'Asia/Jakarta');
                                if ($dateTime->isPast()) {
                                    $fail('Waktu berakhir (end time) tidak boleh di masa lampau.');
                                }
                            }
                        };
                    }),
            ]);
    }
}
