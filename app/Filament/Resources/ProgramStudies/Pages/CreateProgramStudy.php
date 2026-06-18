<?php

namespace App\Filament\Resources\ProgramStudies\Pages;

use App\Filament\Resources\ProgramStudies\ProgramStudyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramStudy extends CreateRecord
{
    protected static string $resource = ProgramStudyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Program study created successfully';
    }
}
