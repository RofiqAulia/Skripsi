<?php

namespace App\Filament\Resources\ProgramStudies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class ProgramStudiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('competency')
                    ->label('Kompetensi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                \Filament\Tables\Columns\TextColumn::make('scholarship')
                    ->label('Scholarship')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                \Filament\Tables\Columns\TextColumn::make('degree')
                    ->label('Gelar')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('university')
                    ->label('Universitas')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('qs_rank')
                    ->label('QS Rank')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('country')
                    ->label('Negara')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('study_type')
                    ->label('Jenis Study'),
                \Filament\Tables\Columns\TextColumn::make('study_duration')
                    ->label('Lama Studi'),
                \Filament\Tables\Columns\TextColumn::make('intake')
                    ->label('Intake'),
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
