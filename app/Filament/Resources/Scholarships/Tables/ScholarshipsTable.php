<?php

namespace App\Filament\Resources\Scholarships\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class ScholarshipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Nama Beasiswa')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                \Filament\Tables\Columns\TextColumn::make('competency')
                    ->label('Kompetensi')
                    ->searchable()
                    ->wrap(),
                \Filament\Tables\Columns\TextColumn::make('programStudy.name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('country')
                    ->label('Negara')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('funding_type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Full'    => 'success',
                        'Partial' => 'warning',
                        default   => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('intake')
                    ->label('Intake'),
                \Filament\Tables\Columns\TextColumn::make('open_date')
                    ->label('Buka')
                    ->date('d M Y')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('d M Y')
                    ->sortable(),
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
