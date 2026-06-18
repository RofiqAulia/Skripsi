<?php

namespace App\Filament\Resources\MentoringSessions\Pages;

use App\Filament\Resources\MentoringSessions\MentoringSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMentoringSessions extends ListRecords
{
    protected static string $resource = MentoringSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
