<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

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
        return 'Document saved successfully';
    }

    /**
     * Auto-set reviewer info when saving.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (in_array($data['status'], ['approved', 'revisi'])) {
            $data['reviewed_by'] = $data['reviewed_by'] ?? Auth::id();
            $data['reviewed_at'] = $data['reviewed_at'] ?? now();
        }

        return $data;
    }
}
