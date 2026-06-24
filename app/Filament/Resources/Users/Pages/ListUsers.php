<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('exportExcel')
                ->label('Export Excel')
                ->icon(\Filament\Support\Icons\Heroicon::ArrowDownTray)
                ->color('success')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\UserExport(),
                        'users_export.xlsx'
                    );
                }),

            \Filament\Actions\Action::make('importExcel')
                ->label('Import Excel')
                ->icon(\Filament\Support\Icons\Heroicon::ArrowUpTray)
                ->color('warning')
                ->modalHeading('Import Users from Excel')
                ->modalDescription('Upload an Excel file (.xlsx) containing User data. Download the template first for the correct format.')
                ->modalSubmitActionLabel('Import Data')
                ->modalWidth('lg')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Excel File')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->required()
                        ->maxSize(5120) // 5MB
                        ->storeFiles(false)
                        ->helperText('Supported formats: .xlsx, .xls, .csv (Max. 5MB)'),
                ])
                ->action(function (array $data): void {
                    try {
                        $file = $data['file'];

                        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            $filePath = $file->getRealPath();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('Invalid file.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $import = new \App\Imports\UserImport();
                        \Maatwebsite\Excel\Facades\Excel::import($import, $filePath);

                        $successCount = $import->getRowsImported();
                        $skippedCount = $import->getRowsSkipped();
                        $importErrors = $import->getErrors();

                        $body = "✅ {$successCount} users imported successfully.";
                        if ($skippedCount > 0) {
                            $body .= "\n⏭️ {$skippedCount} rows skipped.";
                        }
                        if (!empty($importErrors)) {
                            $body .= "\n❌ " . count($importErrors) . " rows with errors:";
                            foreach (array_slice($importErrors, 0, 3) as $err) {
                                $body .= "\n• {$err}";
                            }
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Import Completed')
                            ->body($body)
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('Import Failed')
                            ->body('An error occurred: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            \Filament\Actions\Action::make('downloadTemplate')
                ->label('Download Template')
                ->icon(\Filament\Support\Icons\Heroicon::DocumentText)
                ->color('gray')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\UserTemplateExport(),
                        'template_users.xlsx'
                    );
                }),

            CreateAction::make(),
        ];
    }
}
