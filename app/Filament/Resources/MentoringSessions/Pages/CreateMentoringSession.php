<?php

namespace App\Filament\Resources\MentoringSessions\Pages;

use App\Filament\Resources\MentoringSessions\MentoringSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMentoringSession extends CreateRecord
{
    protected static string $resource = MentoringSessionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mentoring session created successfully';
    }
}
