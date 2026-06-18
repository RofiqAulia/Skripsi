<?php

namespace App\Filament\Resources\FinancialPlans\Pages;

use App\Filament\Resources\FinancialPlans\FinancialPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialPlan extends CreateRecord
{
    protected static string $resource = FinancialPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Financial plan created successfully';
    }
}
