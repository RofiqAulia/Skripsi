<?php

namespace App\Filament\Widgets;

use App\Models\PspApplication;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PspActionRequiredWidget extends TableWidget
{
    protected static ?string $heading = 'Tindak Lanjut PSP (Menunggu Persetujuan Anda)';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PspApplication::query()
                    ->where('status', '!=', 'rejected')
                    ->where(function ($q) {
                        $q->where('status', '!=', 'approved')
                          ->orWhere('approval_stage', '<', 3);
                    })
                    ->where(function (Builder $query) {
                        $user = auth()->user();
                        
                        if ($user->hasRole('super_admin')) {
                            $query->whereIn('approval_stage', [0, 1, 2]);
                            return;
                        }

                        $isDeptHead = $user->hasRole('pimpinan') && $user->department_id;
                        $isGroupHead = $user->hasRole('pimpinan') && !$user->department_id && $user->group_id;
                        $isDirHead = $user->hasRole('pimpinan') && !$user->department_id && !$user->group_id && $user->direktorat_id;

                        $query->where(function ($q) use ($user, $isDeptHead, $isGroupHead, $isDirHead) {
                            if ($isDeptHead) {
                                $q->orWhere(function ($sub) use ($user) {
                                    $sub->where('approval_stage', 0)
                                      ->whereHas('user', fn($u) => $u->where('department_id', $user->department_id)->orWhereNull('department_id'));
                                });
                            }
                            if ($isGroupHead) {
                                $q->orWhere(function ($sub) use ($user) {
                                    $sub->where('approval_stage', 1)
                                      ->whereHas('user', fn($u) => $u->where('group_id', $user->group_id)->orWhereNull('group_id'));
                                });
                            }
                            if ($isDirHead) {
                                $q->orWhere(function ($sub) use ($user) {
                                    $sub->where('approval_stage', 2)
                                      ->whereHas('user', fn($u) => $u->where('direktorat_id', $user->direktorat_id)->orWhereNull('direktorat_id'));
                                });
                            }
                            
                            // Jika bukan head sama sekali, tidak ada yang ditampilkan
                            if (!$isDeptHead && !$isGroupHead && !$isDirHead) {
                                $q->whereRaw('1 = 0');
                            }
                        });
                    })
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemohon')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('study_plan_text')
                    ->label('Topik Riset')
                    ->limit(50),
                \Filament\Tables\Columns\TextColumn::make('approval_stage')
                    ->label('Menunggu')
                    ->formatStateUsing(fn ($state) => match ((int)$state) {
                        1 => 'Dept Head',
                        2 => 'Group Head',
                        3 => 'Direktur',
                        default => 'Unknown',
                    })
                    ->badge()
                    ->color(fn ($state) => match ((int)$state) {
                        1 => 'warning',
                        2 => 'info',
                        3 => 'primary',
                        default => 'secondary',
                    }),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan Pada')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->recordUrl(fn (PspApplication $record): string => \App\Filament\Resources\PspApplications\PspApplicationResource::getUrl('edit', ['record' => $record]))
            ->defaultSort('created_at', 'asc')
            ->emptyStateHeading('Tidak ada antrean')
            ->emptyStateDescription('Semua aplikasi PSP yang menjadi tanggung jawab Anda sudah diproses.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}
