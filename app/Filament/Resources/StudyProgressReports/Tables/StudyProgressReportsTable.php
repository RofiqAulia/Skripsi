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
                        'warning' => 'revisi',
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
                \Filament\Actions\Action::make('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('notes_pimpinan')->label('Notes (Optional)')
                    ])
                    ->action(function (\App\Models\StudyProgressReport $record, array $data) {
                        $record->update([
                            'status' => 'approved',
                            'notes_pimpinan' => $data['notes_pimpinan'] ?? null
                        ]);
                    })
                    ->visible(function () {
                        $user = auth()->user();
                        if ($user->hasRole('super_admin')) return true;
                        if ($user->hasRole('pimpinan')) {
                            $dirName = $user->direktorat ? strtolower($user->direktorat->name) : '';
                            return strpos($dirName, 'human capital') !== false;
                        }
                        return false;
                    }),

                \Filament\Actions\Action::make('Revisi')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('notes_pimpinan')->label('Notes (Wajib)')->required()
                    ])
                    ->action(function (\App\Models\StudyProgressReport $record, array $data) {
                        $record->update([
                            'status' => 'revisi',
                            'notes_pimpinan' => $data['notes_pimpinan']
                        ]);
                    })
                    ->visible(function () {
                        $user = auth()->user();
                        if ($user->hasRole('super_admin')) return true;
                        if ($user->hasRole('pimpinan')) {
                            $dirName = $user->direktorat ? strtolower($user->direktorat->name) : '';
                            return strpos($dirName, 'human capital') !== false;
                        }
                        return false;
                    }),

                \Filament\Actions\Action::make('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('notes_pimpinan')->label('Notes (Wajib)')->required()
                    ])
                    ->action(function (\App\Models\StudyProgressReport $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'notes_pimpinan' => $data['notes_pimpinan']
                        ]);
                    })
                    ->visible(function () {
                        $user = auth()->user();
                        if ($user->hasRole('super_admin')) return true;
                        if ($user->hasRole('pimpinan')) {
                            $dirName = $user->direktorat ? strtolower($user->direktorat->name) : '';
                            return strpos($dirName, 'human capital') !== false;
                        }
                        return false;
                    }),

                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
