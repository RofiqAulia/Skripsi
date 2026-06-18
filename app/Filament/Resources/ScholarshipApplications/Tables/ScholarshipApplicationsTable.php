<?php

namespace App\Filament\Resources\ScholarshipApplications\Tables;

use App\Models\ScholarshipApplication;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class ScholarshipApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Mentee')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('scholarship.title')
                    ->label('Beasiswa')
                    ->searchable()
                    ->limit(30),

                \Filament\Tables\Columns\TextColumn::make('scholarship.country')
                    ->label('Negara')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('programStudy.name')
                    ->label('Program Studi')
                    ->limit(25),

                \Filament\Tables\Columns\TextColumn::make('current_stage')
                    ->label('Tahapan')
                    ->formatStateUsing(fn ($state) => ScholarshipApplication::STAGES[$state] ?? $state),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'lolos'       => 'success',
                        'tidak_lolos' => 'danger',
                        default       => 'warning',
                    })
                    ->formatStateUsing(fn ($state) => ScholarshipApplication::STATUSES[$state] ?? $state),

                \Filament\Tables\Columns\TextColumn::make('psp_application_id')
                    ->label('PSP Link')
                    ->formatStateUsing(fn ($state) => $state ? '✅ Linked' : '—'),

                \Filament\Tables\Columns\TextColumn::make('updated_date')
                    ->label('Tgl Update')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options(ScholarshipApplication::STATUSES)
                    ->label('Status'),

                \Filament\Tables\Filters\SelectFilter::make('current_stage')
                    ->options(ScholarshipApplication::STAGES)
                    ->label('Tahapan'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_date', 'desc');
    }
}
