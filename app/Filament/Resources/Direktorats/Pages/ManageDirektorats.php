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
            CreateAction::make(),
        ];
    }
}
