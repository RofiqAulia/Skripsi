<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('poster')
                    ->circular(false)
                    ->height(50)
                    ->width(50),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                \Filament\Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('time')
                    ->time('H:i')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('organizer')
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('speaker')
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'not_started' => 'gray',
                        'in_progress' => 'warning',
                        'done'        => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'not_started' => 'Not Started',
                        'in_progress' => 'In Progress',
                        'done'        => 'Done',
                        default       => $state,
                    }),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'not_started' => 'Not Started',
                        'in_progress' => 'In Progress',
                        'done'        => 'Done',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
