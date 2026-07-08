<?php

namespace App\Livewire;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use App\Models\MentoringReport;
use App\Filament\Resources\MentoringReports\MentoringReportResource;
use Livewire\Attributes\Reactive;
use Carbon\Carbon;

class MentorActionRequiredWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Action Required: Reports to Review';

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
                MentoringReport::query()
                    ->whereHas('session', function($q) use ($mentorId, $from, $to) {
                        $q->where('mentor_id', $mentorId)
                          ->whereBetween('created_at', [$from, $to]);
                    })
                    ->where('status', MentoringReport::STATUS_UNDER_REVIEW)
            )
            ->columns([
                TextColumn::make('session.user.name')
                    ->label('Mentee Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('meeting_number')
                    ->label('Meeting')
                    ->sortable(),
                TextColumn::make('summary')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->summary),
                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('review')
                    ->label('Review Now')
                    ->button()
                    ->url(fn (MentoringReport $record): string => MentoringReportResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-pencil-square'),
            ]);
    }
}
