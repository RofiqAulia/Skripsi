<?php

namespace App\Filament\Resources\ScholarshipInsights\Pages;

use App\Filament\Resources\ScholarshipInsights\ScholarshipInsightResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateScholarshipInsight extends CreateRecord
{
    protected static string $resource = ScholarshipInsightResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Scholarship insight created successfully';
    }

    /**
     * Auto-set the created_by field and published_at when toggling publish.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        if (! empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
