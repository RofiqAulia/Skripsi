<?php

namespace App\Filament\Resources\MentoringSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;


class MentoringSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // ✅ Nama User
                TextColumn::make('user.name')
                    ->label('Mentee')
                    ->searchable()
                    ->sortable(),

                // ✅ Nama Mentor (dari mentor → user)
                TextColumn::make('mentor.user.name')
                    ->label('Mentor')
                    ->searchable()
                    ->sortable(),

                // ✅ Tanggal
                TextColumn::make('schedule.date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                // ✅ Jam mulai
                TextColumn::make('schedule.start_time')
                    ->label('Start Time')
                    ->time()
                    ->sortable(),

                // ✅ Jam selesai
                TextColumn::make('schedule.end_time')
                    ->label('End Time')
                    ->time()
                    ->sortable(),

                // ✅ Status
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'done' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                // ✅ Link Meet
                TextColumn::make('link_meet')
                    ->label('Meeting Link')
                    ->copyable()
                    ->tooltip('Click to copy link')
                    ->toggleable(isToggledHiddenByDefault: true),

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