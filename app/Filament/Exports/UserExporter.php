<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('position')
                ->label('Position'),
            ExportColumn::make('company')
                ->label('Company'),
            ExportColumn::make('age')
                ->label('Age'),
            ExportColumn::make('toefl_score')
                ->label('TOEFL Score'),
            ExportColumn::make('ielts_score')
                ->label('IELTS Score'),
            ExportColumn::make('roles.name')
                ->label('Role')
                ->formatStateUsing(fn ($state) => $state),
            ExportColumn::make('created_at')
                ->label('Created At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data user selesai. ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil di-export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal di-export.';
        }

        return $body;
    }
}
