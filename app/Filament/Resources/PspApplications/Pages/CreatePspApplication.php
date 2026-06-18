<?php

namespace App\Filament\Resources\PspApplications\Pages;

use App\Filament\Resources\PspApplications\PspApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePspApplication extends CreateRecord
{
    protected static string $resource = PspApplicationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'PSP application created successfully';
    }
}
