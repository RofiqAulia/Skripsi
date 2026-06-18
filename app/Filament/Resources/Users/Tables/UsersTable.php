<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([                
                // \Filament\Tables\Columns\ImageColumn::make('photo')
                //     ->circular()
                //     ->defaultImageUrl(url('/images/default-avatar.png')),
                TextColumn::make('name')
                    ->searchable(),                
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('toefl_score')
                    ->label('TOEFL')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ielts_score')
                    ->label('IELTS')
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('position')
                //     ->searchable(),
                // TextColumn::make('company')
                //     ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                viewAction::make(),
                EditAction::make(),
                deleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
