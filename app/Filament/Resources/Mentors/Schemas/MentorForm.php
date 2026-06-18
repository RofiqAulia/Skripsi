<?php

namespace App\Filament\Resources\Mentors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use App\Models\User;
use Filament\Schemas\Components\Utilities\Set;

class MentorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ✅ Select Mentor (User)
                Select::make('user_id')
                    ->label('Mentor Name')
                    ->options(User::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive()

                    // 🔥 Saat user dipilih
                    ->afterStateUpdated(function ($state, Set $set) {
                        $user = User::find($state);

                        if ($user) {
                            $set('current_position', $user->position ?? '');
                            $set('company', $user->company ?? '');
                        }
                    })

                    // 🔥 Saat edit (load data awal)
                    ->afterStateHydrated(function ($state, Set $set) {
                        $user = User::find($state);

                        if ($user) {
                            $set('current_position', $user->position ?? '');
                            $set('company', $user->company ?? '');
                        }
                    }),

                // ✅ Photo
                \Filament\Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->disk('public')
                    ->directory('mentors/photos')
                    ->required()
                    ->columnSpanFull(),

                // ✅ Position
                TextInput::make('current_position')
                    ->label('Current Position')
                    ->required(),

                // ✅ Company
                TextInput::make('company')
                    ->required(),

                // ✅ Quota
                TextInput::make('quota')
                    ->numeric()
                    ->default(3)
                    ->required(),

                // 🔥 Education
                // 🔥 Education
Repeater::make('education')
    ->label('Education')
    ->simple(
        TextInput::make('value')
            ->label('Education')
            ->required()
    )
    ->columnSpanFull(),

// 🔥 Career Journey
Repeater::make('career_journey')
    ->label('Career Journey')
    ->simple(
        TextInput::make('value')
            ->label('Career')
            ->required()
    )
    ->columnSpanFull(),

// 🔥 Achievements
Repeater::make('achievements')
    ->label('Achievements')
    ->simple(
        TextInput::make('value')
            ->label('Achievement')
            ->required()
    )
    ->columnSpanFull(),
            ]);
    }
}