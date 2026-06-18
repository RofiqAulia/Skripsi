<?php

namespace App\Filament\Resources\MentoringReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MentoringReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // ✅ Nama User
                TextColumn::make('session.user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                // ✅ Nama Mentor
                TextColumn::make('session.mentor.user.name')
                    ->label('Mentor')
                    ->searchable()
                    ->sortable(),

                // ✅ Pertemuan ke
                TextColumn::make('meeting_number')
                    ->label('Meeting')
                    ->sortable(),

                // ✅ Summary
                TextColumn::make('summary')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->summary),

                // ✅ File
                TextColumn::make('file')
                    ->label('File')
                    ->url(fn ($record) => asset('storage/' . $record->file))
                    ->openUrlInNewTab(),

                // ✅ Status (badge biar keren 🔥)
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'revision' => 'info',
                        'rejected' => 'danger',
                        'approved' => 'success',
                    }),

                // ✅ Catatan mentor
                TextColumn::make('mentor_notes')
                    ->label('Mentor Notes')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->mentor_notes),

                TextColumn::make('created_at')
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