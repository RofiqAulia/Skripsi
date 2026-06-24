<?php

namespace App\Filament\Resources\Mentors\Pages;

use App\Filament\Resources\Mentors\MentorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMentors extends ListRecords
{
    protected static string $resource = MentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),

            \Filament\Actions\Action::make('exportExcel')
                ->label('Export Excel')
                ->icon(\Filament\Support\Icons\Heroicon::ArrowDownTray)
                ->color('success')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\MentorExport(),
                        'mentors_export.xlsx'
                    );
                }),

            \Filament\Actions\Action::make('importExcel')
                ->label('Import Excel')
                ->icon(\Filament\Support\Icons\Heroicon::ArrowUpTray)
                ->color('warning')
                ->modalHeading('Import Mentors from Excel')
                ->modalDescription('Upload an Excel file (.xlsx) containing Mentor data. The system will match the mentor to an existing User by their Name. Ensure the users are already registered before importing.')
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

                        $import = new \App\Imports\MentorImport();
                        \Maatwebsite\Excel\Facades\Excel::import($import, $filePath);

                        $successCount = $import->getRowsImported();
                        $skippedCount = $import->getRowsSkipped();
                        $importErrors = $import->getErrors();

                        $body = "✅ {$successCount} mentors imported successfully.";
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
                ->icon(\Filament\Support\Icons\Heroicon::ArrowDownTray)
                ->color('gray')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\MentorTemplateExport(),
                        'template_mentors.xlsx'
                    );
                }),
        ];
    }
}
