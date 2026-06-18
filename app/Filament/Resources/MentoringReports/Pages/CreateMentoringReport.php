<?php

namespace App\Filament\Resources\MentoringReports\Pages;

use App\Filament\Resources\MentoringReports\MentoringReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMentoringReport extends CreateRecord
{
    protected static string $resource = MentoringReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mentoring report created successfully';
    }
}
