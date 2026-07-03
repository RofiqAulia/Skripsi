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
                    ->rule(function ($get, $record) {
                        return function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            if (!is_array($value)) return;
                            
                            $pimpinanRole = \Spatie\Permission\Models\Role::where('name', 'pimpinan')->first();
                            if ($pimpinanRole && in_array($pimpinanRole->id, $value)) {
                                $deptId = $get('department_id');
                                $groupId = $get('group_id');
                                $dirId = $get('direktorat_id');
                                
                                if (!$deptId && !$groupId && !$dirId) return;
                                
                                $query = \App\Models\User::role('pimpinan');
                                if ($record) {
                                    $query->where('id', '!=', $record->id);
                                }
                                
                                if ($deptId) {
                                    $query->where('department_id', $deptId);
                                } elseif ($groupId) {
                                    $query->where('group_id', $groupId);
                                } elseif ($dirId) {
                                    $query->where('direktorat_id', $dirId);
                                }
                                
                                if ($query->exists()) {
                                    $fail("Penempatan ini sudah memiliki user dengan role pimpinan (Hanya boleh 1).");
                                }
                            }
                        };
                    })
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
