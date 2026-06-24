<?php

namespace App\Filament\Resources\ProgramStudies\Pages;

use App\Exports\ProgramStudyTemplateExport;
use App\Filament\Resources\ProgramStudies\ProgramStudyResource;
use App\Imports\ProgramStudyImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ListProgramStudies extends ListRecords
{
    protected static string $resource = ProgramStudyResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'approved')),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'pending')),
            'revision' => Tab::make('Revision')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'revision')),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'rejected')),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('exportExcel')
                ->label('Export Excel')
                ->icon(Heroicon::ArrowDownTray)
                ->color('success')
                ->action(function () {
                    return Excel::download(
                        new \App\Exports\ProgramStudyExport(),
                        'program_study_export.xlsx'
                    );
                }),

            Action::make('importExcel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color('warning')
                ->modalHeading('Import Program Study from Excel')
                ->modalDescription('Upload an Excel file (.xlsx) containing Program Study data. Download the template first for the correct format.')
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
                        ->helperText('Supported formats: .xlsx, .xls, .csv (Max. 5MB)'),
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

                        $import = new ProgramStudyImport();
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
                        new ProgramStudyTemplateExport(),
                        'template_program_study.xlsx'
                    );
                }),
        ];
    }
}
