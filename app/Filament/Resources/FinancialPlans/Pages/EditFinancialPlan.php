<?php

namespace App\Filament\Resources\FinancialPlans\Pages;

use App\Filament\Resources\FinancialPlans\FinancialPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Capture old status BEFORE update
        $oldStatus = $record->getOriginal('status') ?? $record->status;

        $record->update($data);
        $record->refresh();

        $newStatus = $record->status;

        Log::info('[FinancialPlan] Status change', [
            'plan_id'    => $record->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'user_email' => $record->user->email ?? 'n/a',
        ]);

        // Send email jika status berubah ke revision_needed atau approved
        if ($oldStatus !== $newStatus && in_array($newStatus, ['approved', 'revision_needed'])) {
            try {
                $record->loadMissing(['user', 'scholarshipApplication.programStudy']);

                if ($record->user && $record->user->email) {
                    \Illuminate\Support\Facades\Mail::to($record->user->email)->send(
                        new \App\Mail\FinancialPlanStatusMail($record, $newStatus, $record->admin_notes)
                    );

                    Log::info('[FinancialPlan] Email sent', [
                        'to'     => $record->user->email,
                        'status' => $newStatus,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('[FinancialPlan] Email FAILED: ' . $e->getMessage(), [
                    'plan_id' => $record->id,
                    'trace'   => $e->getTraceAsString(),
                ]);
            }
        }

        return $record;
    }
}
