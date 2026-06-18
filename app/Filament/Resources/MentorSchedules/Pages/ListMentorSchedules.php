<?php

namespace App\Filament\Resources\MentorSchedules\Pages;

use App\Filament\Resources\MentorSchedules\MentorScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMentorSchedules extends ListRecords
{
    protected static string $resource = MentorScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
