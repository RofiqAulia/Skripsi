<?php

namespace App\Filament\Resources\MentoringSessions\Pages;

use App\Filament\Resources\MentoringSessions\MentoringSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMentoringSession extends EditRecord
{
    protected static string $resource = MentoringSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Mentoring session saved successfully';
    }
}
