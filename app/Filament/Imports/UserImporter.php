<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Number;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->label('Name'),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255', 'unique:users,email'])
                ->label('Email'),
            ImportColumn::make('password')
                ->label('Password')
                ->rules(['max:255']),
            ImportColumn::make('position')
                ->rules(['max:255'])
                ->label('Position'),
            ImportColumn::make('company')
                ->rules(['max:255'])
                ->label('Company'),
            ImportColumn::make('age')
                ->numeric()
                ->rules(['integer', 'min:0'])
                ->label('Age'),
            ImportColumn::make('toefl_score')
                ->numeric()
                ->rules(['integer', 'min:0'])
                ->label('TOEFL Score'),
            ImportColumn::make('ielts_score')
                ->numeric()
                ->rules(['integer', 'min:0'])
                ->label('IELTS Score'),
        ];
    }

    public function resolveRecord(): User
    {
        return new User();
    }

    protected function beforeCreate(): void
    {
        // Set default password jika tidak disediakan di file CSV
        if (empty($this->data['password'])) {
            $this->data['password'] = 'password123';
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data user selesai. ' . Number::format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil di-import.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal di-import.';
        }

        return $body;
    }
}
