<?php

namespace App\Filament\Resources\MentoringReports\Pages;

use App\Filament\Resources\MentoringReports\MentoringReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMentoringReport extends EditRecord
{
    protected static string $resource = MentoringReportResource::class;

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
        return 'Mentoring report saved successfully';
    }
}
