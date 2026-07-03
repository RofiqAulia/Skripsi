<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->disk('public')
                    ->directory('users/photos')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('position'),
                TextInput::make('company'),
                \Filament\Forms\Components\Select::make('department_id')
                    ->label('Department / Placement')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('name'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
