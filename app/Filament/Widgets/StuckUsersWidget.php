<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class StuckUsersWidget extends TableWidget
{
    protected static ?string $heading = 'Stuck Users — Documents Pending Review > 7 Days';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Document::query()
                    ->where('status', 'uploaded')
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->with('user')
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('type')
                    ->label('Document Type')
                    ->formatStateUsing(fn (string $state) => Document::typeLabel($state)),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded At')
                    ->dateTime('M d, Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('days_waiting')
                    ->label('Days Waiting')
                    ->state(fn ($record) => Carbon::parse($record->created_at)->diffInDays(now()))
                    ->badge()
                    ->color(fn ($state) => $state > 14 ? 'danger' : 'warning')
                    ->suffix(' days'),
            ])
            ->defaultSort('created_at', 'asc')
            ->emptyStateHeading('No stuck documents')
            ->emptyStateDescription('All uploaded documents have been reviewed within 7 days. Great job!')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}
