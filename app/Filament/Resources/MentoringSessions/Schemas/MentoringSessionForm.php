<?php

namespace App\Filament\Resources\MentoringSessions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Mentor;
use App\Models\MentorSchedule;

class MentoringSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ✅ User (nama)
                Select::make('user_id')
                    ->label('Mentee')
                    ->options(function () {
                        if (auth()->user()->hasRole('mentor')) {
                            $mentor = auth()->user()->mentor;
                            if ($mentor) {
                                $studentIds = $mentor->sessions()->pluck('user_id');
                                return User::whereIn('id', $studentIds)->orderBy('name')->pluck('name', 'id');
                            }
                            return [];
                        }
                        return User::role('mentee')->orderBy('name')->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),

                // ✅ Mentor (nama dari relasi user)
                Select::make('mentor_id')
                    ->label('Mentor')
                    ->options(
                        Mentor::with('user')
                            ->get()
                            ->pluck('user.name', 'id')
                    )
                    ->searchable()
                    ->required(),

                // ✅ Schedule (date + time)
                Select::make('schedule_id')
                    ->label('Schedule')
                    ->options(
                        MentorSchedule::all()->mapWithKeys(function ($schedule) {
                            return [
                                $schedule->id => 
                                    $schedule->date . ' | ' .
                                    $schedule->start_time . ' - ' .
                                    $schedule->end_time
                            ];
                        })
                    )
                    ->searchable()
                    ->required(),

                // ✅ Status
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'done' => 'Done',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                    
                // ✅ Link Meet
                \Filament\Forms\Components\TextInput::make('link_meet')
                    ->label('Meeting Link')
                    ->url()
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if ($value && !preg_match('/(meet\.google\.com|zoom\.us|teams\.microsoft\.com)/i', $value)) {
                                    $fail('The meeting link must be from Google Meet, Zoom, or MS Teams.');
                                }
                            };
                        },
                    ])
                    ->maxLength(255),
            ]);
    }
}