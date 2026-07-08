<?php

namespace App\Livewire;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Livewire\Attributes\Reactive;
use Carbon\Carbon;

class MentorMenteesProgressWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'My Mentees Progress';

    #[Reactive]
    public int $selectedYear;

    #[Reactive]
    public string $selectedMonth = '';

    protected function dateRange(): array
    {
        if ($this->selectedMonth !== '') {
            return [
                Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth(),
                Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth(),
            ];
        }
        return [
            Carbon::create($this->selectedYear, 1, 1)->startOfYear(),
            Carbon::create($this->selectedYear, 12, 31)->endOfYear(),
        ];
    }

    public function table(Table $table): Table
    {
        $mentorId = auth()->user()?->mentor?->id;
        [$from, $to] = $this->dateRange();

        return $table
            ->query(
                User::query()
                    ->whereHas('sessions', function($q) use ($mentorId, $from, $to) {
                        $q->where('mentor_id', $mentorId)
                          ->whereBetween('created_at', [$from, $to]);
                    })
                    ->withCount(['sessions as completed_sessions_count' => function ($query) use ($mentorId, $from, $to) {
                        $query->where('mentor_id', $mentorId)
                              ->where('status', 'done')
                              ->whereBetween('created_at', [$from, $to]);
                    }])
                    ->withCount(['sessions as total_sessions_count' => function ($query) use ($mentorId, $from, $to) {
                        $query->where('mentor_id', $mentorId)
                              ->whereBetween('created_at', [$from, $to]);
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
