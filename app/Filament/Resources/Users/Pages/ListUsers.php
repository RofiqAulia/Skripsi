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
            ExportAction::make()
                ->exporter(UserExporter::class)
                ->label('Export')
                ->color('success'),
            ImportAction::make()
                ->importer(UserImporter::class)
                ->label('Import')
                ->color('warning'),
            CreateAction::make(),
        ];
    }
}
