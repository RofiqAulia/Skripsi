<?php

namespace App\Filament\Resources\ScholarshipApplications\Pages;

use App\Filament\Resources\ScholarshipApplications\ScholarshipApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScholarshipApplication extends CreateRecord
{
    protected static string $resource = ScholarshipApplicationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Scholarship application created successfully';
    }
}
