<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Models\Document;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('type')
                    ->label('Document Type')
                    ->formatStateUsing(fn (string $state) => Document::typeLabel($state))
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'required' => 'primary',
                        'other' => 'gray',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'uploaded' => 'warning',
                        'approved' => 'success',
                        'revisi' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->notes)
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewed By')
                    ->sortable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Reviewed At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded At')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'uploaded' => 'Awaiting Review',
                        'approved' => 'Approved',
                        'revisi' => 'Revisi',
                    ]),
                SelectFilter::make('type')
                    ->label('Document Type')
                    ->options(Document::REQUIRED_TYPES + ['other' => 'Other / Supporting']),
            ])
            ->recordActions([
                // Approve Action
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Document')
                    ->modalDescription('Are you sure you want to approve this document? You may optionally add a note.')
                    ->form([
                        Textarea::make('notes')
                            ->label('Notes (optional)')
                            ->placeholder('e.g. Document meets all requirements.')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status'      => 'approved',
                            'notes'       => $data['notes'] ?? null,
                            'reviewed_by' => Auth::id(),
                            'reviewed_at' => now(),
                        ]);
                    }),

                // Revisi Action
                Action::make('revisi')
                    ->label('Revisi')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'revisi')
                    ->requiresConfirmation()
                    ->modalHeading('Revisi Document')
                    ->modalDescription('Please provide a reason for revision so the user knows what to fix.')
                    ->form([
                        Textarea::make('notes')
                            ->label('Revision Reason')
                            ->placeholder('e.g. Document is blurry, please re-upload a clearer scan.')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status'      => 'revisi',
                            'notes'       => $data['notes'],
                            'reviewed_by' => Auth::id(),
                            'reviewed_at' => now(),
                        ]);
                    }),

                // View file
                Action::make('view_file')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn ($record) => !empty($record->file))
                    ->url(fn ($record) => asset('storage/' . $record->file))
                    ->openUrlInNewTab(),

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
