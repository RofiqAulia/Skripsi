<?php

namespace App\Filament\Resources\FinancialPlans\Pages;

use App\Filament\Resources\FinancialPlans\FinancialPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFinancialPlan extends EditRecord
{
    protected static string $resource = FinancialPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Financial plan saved successfully';
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $oldStatus = $record->status;
        $record->update($data);
        $newStatus = $record->status;

        if ($oldStatus !== $newStatus && in_array($newStatus, ['approved', 'revision_needed'])) {
            // Send email to mentee
            if ($record->user && $record->user->email) {
                \Illuminate\Support\Facades\Mail::to($record->user->email)->send(
                    new \App\Mail\FinancialPlanStatusMail($record, $newStatus, $record->admin_notes)
                );
            }
        }

        return $record;
    }
}
