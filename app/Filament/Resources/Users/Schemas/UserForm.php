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
                    ->relationship('roles', 'name', fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('name', '!=', 'approver'))
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('position'),
                TextInput::make('company'),
                \Filament\Schemas\Components\Section::make('Placement')
                    ->description('Pilih HANYA SALAH SATU penempatan (Department, Group, ATAU Direktorat).')
                    ->schema([
                        \Filament\Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('group_id', null);
                                    $set('direktorat_id', null);
                                }
                            }),
                        \Filament\Forms\Components\Select::make('group_id')
                            ->label('Group')
                            ->relationship('group', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('department_id', null);
                                    $set('direktorat_id', null);
                                }
                            }),
                        \Filament\Forms\Components\Select::make('direktorat_id')
                            ->label('Direktorat')
                            ->relationship('direktorat', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('department_id', null);
                                    $set('group_id', null);
                                }
                            }),
                    ])->columns(3),
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
