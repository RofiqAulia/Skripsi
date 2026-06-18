<?php

namespace App\Filament\Resources\ScholarshipInsights\Pages;

use App\Filament\Resources\ScholarshipInsights\ScholarshipInsightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScholarshipInsights extends ListRecords
{
    protected static string $resource = ScholarshipInsightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
