<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Event Details')
                    ->components([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull(),
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->required(),
                        \Filament\Forms\Components\TimePicker::make('time'),
                        \Filament\Forms\Components\TextInput::make('location')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('link')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Registration link or further info'),
                        \Filament\Forms\Components\TextInput::make('organizer')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('speaker')
                            ->maxLength(255),
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'not_started'  => 'Not Started',
                                'in_progress'  => 'In Progress',
                                'done'         => 'Done',
                            ])
                            ->default('not_started')
                            ->required(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Poster')
                    ->components([
                        \Filament\Forms\Components\FileUpload::make('poster')
                            ->image()
                            ->imageEditor()
                            ->directory('events/posters')
                            ->disk('public')
                            ->maxSize(5120) // 5MB
                            ->helperText('Upload event poster (max. 5MB). Format: JPG, PNG, WebP.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
