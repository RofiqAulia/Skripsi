<?php

namespace App\Filament\Resources\FinancialPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FinancialPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Mentee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scholarshipApplication.programStudy.scholarship')
                    ->label('Scholarship')
                    ->searchable(),
                TextColumn::make('scholarshipApplication.programStudy.name')
                    ->label('Program Study')
                    ->searchable(),
                TextColumn::make('university_name')
                    ->label('University')
                    ->searchable(),
                TextColumn::make('country_destination')
                    ->label('Country')
                    ->searchable(),
                TextColumn::make('total_estimated_cost')
                    ->label('Total Cost')
                    ->money(fn ($record) => $record->currency ?? 'IDR')
                    ->sortable(),
                TextColumn::make('funding_gap')
                    ->label('Funding Gap')
                    ->money(fn ($record) => $record->currency ?? 'IDR')
                    ->sortable(),
                TextColumn::make('readiness_percentage')
                    ->label('Readiness')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->sortable(),
                TextColumn::make('risk_level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'info',
                        'under_review' => 'warning',
                        'revision_needed' => 'danger',
                        'approved' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('submitted_at')
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
