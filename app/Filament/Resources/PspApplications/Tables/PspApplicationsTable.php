<?php

namespace App\Filament\Resources\PspApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PspApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('approval_stage')
                    ->label('Stage')
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        0 => 'Dept',
                        1 => 'Group',
                        2 => 'Direktorat',
                        3 => 'Done',
                        default => 'Unknown',
                    })
                    ->color(fn (int $state): string => match ($state) {
                        0 => 'gray',
                        1 => 'info',
                        2 => 'primary',
                        3 => 'success',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('dept_status')
                    ->label('Dept Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        if ($record->approval_stage >= 1) return 'Approved';
                        if ($record->approval_stage == 0) {
                            return match ($record->status) {
                                'submission' => 'Waiting',
                                'review' => 'Revision',
                                'rejected' => 'Rejected',
                                default => 'Waiting',
                            };
                        }
                        return '-';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Waiting' => 'gray',
                        'Revision' => 'warning',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('group_status')
                    ->label('Group Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        if ($record->approval_stage >= 2) return 'Approved';
                        if ($record->approval_stage == 1) {
                            return match ($record->status) {
                                'review' => 'Revision',
                                'rejected' => 'Rejected',
                                default => 'Waiting',
                            };
                        }
                        return '-';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Waiting' => 'gray',
                        'Revision' => 'warning',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('dir_status')
                    ->label('Dir Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        if ($record->approval_stage >= 3) return 'Approved';
                        if ($record->approval_stage == 2) {
                            return match ($record->status) {
                                'review' => 'Revision',
                                'rejected' => 'Rejected',
                                default => 'Waiting',
                            };
                        }
                        return '-';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Waiting' => 'gray',
                        'Revision' => 'warning',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
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
