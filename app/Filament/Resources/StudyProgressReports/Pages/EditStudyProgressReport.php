<?php

namespace App\Filament\Resources\StudyProgressReports\Pages;

use App\Filament\Resources\StudyProgressReports\StudyProgressReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudyProgressReport extends EditRecord
{
    protected static string $resource = StudyProgressReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
