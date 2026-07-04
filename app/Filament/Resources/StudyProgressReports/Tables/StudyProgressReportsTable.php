<?php

namespace App\Filament\Resources\StudyProgressReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class StudyProgressReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('pspApplication.study_plan_text')
                    ->label('PSP')
                    ->limit(30),
                \Filament\Tables\Columns\TextColumn::make('semester')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('gpa')
                    ->label('IPK'),
                \Filament\Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'submission',
                        'warning' => 'review',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Tables\Actions\ViewAction::make(),
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
