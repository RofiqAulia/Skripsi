<?php

namespace App\Livewire;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;

class MentorMenteesProgressWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'My Mentees Progress';

    public function table(Table $table): Table
    {
        $mentorId = auth()->user()?->mentor?->id;

        return $table
            ->query(
                User::query()
                    ->whereHas('sessions', function($q) use ($mentorId) {
                        $q->where('mentor_id', $mentorId);
                    })
                    ->withCount(['sessions as completed_sessions_count' => function ($query) use ($mentorId) {
                        $query->where('mentor_id', $mentorId)->where('status', 'done');
                    }])
                    ->withCount(['sessions as total_sessions_count' => function ($query) use ($mentorId) {
                        $query->where('mentor_id', $mentorId);
                    }])
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Mentee Name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (User $record): string => $record->email),
                
                TextColumn::make('completed_sessions_count')
                    ->label('Sessions Done')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('total_sessions_count')
                    ->label('Total Sessions')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Mentee Since')
                    ->date()
                    ->sortable(),
            ]);
    }
}
