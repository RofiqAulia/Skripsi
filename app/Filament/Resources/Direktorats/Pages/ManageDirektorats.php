<?php

namespace App\Filament\Resources\Direktorats\Pages;

use App\Filament\Resources\Direktorats\DirektoratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDirektorats extends ManageRecords
{
    protected static string $resource = DirektoratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('import')
                ->label('Import Structure')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Excel File')
                        ->disk('local')
                        ->directory('imports')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                            'application/vnd.ms-excel',
                            'text/csv'
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $filePath = storage_path('app/private/' . $data['file']);
                    
                    \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\OrganizationImport, $filePath);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Organization structure imported successfully')
                        ->success()
                        ->send();
                }),
                
            \Filament\Actions\Action::make('export')
                ->label('Export Structure')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\OrganizationExport, 'organization_structure.xlsx');
                }),
                
            CreateAction::make(),
        ];
    }
}
