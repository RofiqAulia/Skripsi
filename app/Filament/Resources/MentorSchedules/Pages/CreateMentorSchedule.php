<?php

namespace App\Filament\Resources\MentorSchedules\Pages;

use App\Filament\Resources\MentorSchedules\MentorScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMentorSchedule extends CreateRecord
{
    protected static string $resource = MentorScheduleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mentor schedule created successfully';
    }
}
