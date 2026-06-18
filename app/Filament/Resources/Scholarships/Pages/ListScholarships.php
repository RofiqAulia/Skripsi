<?php

namespace App\Filament\Resources\Scholarships\Pages;

use App\Exports\ScholarshipTemplateExport;
use App\Filament\Resources\Scholarships\ScholarshipResource;
use App\Imports\ScholarshipImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ListScholarships extends ListRecords
{
    protected static string $resource = ScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('importExcel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color('success')
                ->modalHeading('Import Scholarship from Excel')
                ->modalDescription('Upload an Excel file (.xlsx) containing Scholarship data. Download the template first for the correct format.')
                ->modalSubmitActionLabel('Import Data')
                ->modalWidth('lg')
                ->form([
                    FileUpload::make('file')
                        ->label('Excel File')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->required()
                        ->maxSize(5120) // 5MB
                        ->storeFiles(false)
                        ->helperText('Supported formats: .xlsx, .xls, .csv (Max. 5MB). Make sure the "program_study" column contains an existing Program Study name.'),
                ])
                ->action(function (array $data): void {
                    try {
                        $file = $data['file'];

                        // Get the file path from the TemporaryUploadedFile
                        if ($file instanceof TemporaryUploadedFile) {
                            $filePath = $file->getRealPath();
                        } else {
                            Notification::make()
                                ->title('Error')
                                ->body('Invalid file.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $import = new ScholarshipImport();
                        Excel::import($import, $filePath);

                        $successCount = $import->getRowsImported();
                        $skippedCount = $import->getRowsSkipped();
                        $importErrors = $import->getErrors();

                        $body = "✅ {$successCount} data imported/updated successfully.";
                        if ($skippedCount > 0) {
                            $body .= "\n⏭️ {$skippedCount} rows skipped (empty/invalid).";
                        }
                        if (!empty($importErrors)) {
                            $body .= "\n❌ " . count($importErrors) . " rows with errors:";
                            foreach (array_slice($importErrors, 0, 3) as $err) {
                                $body .= "\n• {$err}";
                            }
                        }

                        Notification::make()
                            ->title('Import Completed')
                            ->body($body)
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import Failed')
                            ->body('An error occurred: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('downloadTemplate')
                ->label('Download Template')
                ->icon(Heroicon::ArrowDownTray)
                ->color('gray')
                ->action(function () {
                    return Excel::download(
                        new ScholarshipTemplateExport(),
                        'template_scholarship.xlsx'
                    );
                }),
        ];
    }
}
