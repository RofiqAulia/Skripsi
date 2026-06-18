<?php

namespace App\Filament\Resources\ScholarshipInsights\Pages;

use App\Filament\Resources\ScholarshipInsights\ScholarshipInsightResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScholarshipInsight extends EditRecord
{
    protected static string $resource = ScholarshipInsightResource::class;

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
        return 'Scholarship insight saved successfully';
    }

    /**
     * Auto-set published_at when first toggled to published.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
