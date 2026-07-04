<?php

namespace App\Filament\Resources\StudyProgressReports\Pages;

use App\Filament\Resources\StudyProgressReports\StudyProgressReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudyProgressReports extends ListRecords
{
    protected static string $resource = StudyProgressReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
