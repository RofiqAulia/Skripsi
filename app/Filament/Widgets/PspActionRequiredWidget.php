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
                    ->whereNotIn('status', ['rejected', 'approved'])
                    ->where(function (Builder $query) {
                        $user = auth()->user();
                        
                        // Super admin bisa melihat semua yang masih pending
                        if ($user->hasRole('super_admin')) {
                            $query->whereIn('approval_stage', [0, 1, 2]);
                            return;
                        }

                        $dept = \App\Models\Department::where('head_id', $user->id)->first();
                        $group = \App\Models\Group::where('head_id', $user->id)->first();
                        $dir = \App\Models\Direktorat::where('head_id', $user->id)->first();

                        $query->where(function ($q) use ($dept, $group, $dir) {
                            if ($dept) {
                                $q->orWhere(function ($sub) use ($dept) {
                                    $sub->where('approval_stage', 0)
                                      ->whereHas('user', fn($u) => $u->where('department_id', $dept->id));
                                });
                            }
                            if ($group) {
                                $q->orWhere(function ($sub) use ($group) {
                                    $sub->where('approval_stage', 1)
                                      ->whereHas('user', fn($u) => $u->where('group_id', $group->id));
                                });
                            }
                            if ($dir) {
                                $q->orWhere(function ($sub) use ($dir) {
                                    $sub->where('approval_stage', 2)
                                      ->whereHas('user', fn($u) => $u->where('direktorat_id', $dir->id));
                                });
                            }
                            
                            // Jika bukan head sama sekali, tidak ada yang ditampilkan
                            if (!$dept && !$group && !$dir) {
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
                        0 => 'Dept Head',
                        1 => 'Group Head',
                        2 => 'Direktur',
                        default => 'Unknown',
                    })
                    ->badge()
                    ->color(fn ($state) => match ((int)$state) {
                        0 => 'warning',
                        1 => 'info',
                        2 => 'primary',
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
