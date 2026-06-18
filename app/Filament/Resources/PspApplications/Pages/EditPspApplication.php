<?php

namespace App\Filament\Resources\PspApplications\Pages;

use App\Filament\Resources\PspApplications\PspApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPspApplication extends EditRecord
{
    protected static string $resource = PspApplicationResource::class;

    public ?string $oldStatus = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldStatus = $this->record->status;
        return $data;
    }

    protected function afterSave(): void
    {
        $application = $this->record;

        if (in_array($application->status, ['approved', 'review', 'rejected']) && $this->oldStatus !== $application->status) {
            $application->load([
                'user',
                'scholarship.programStudy',
                'studyPlan.programStudy',
                'approver',
            ]);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.psp-letter', compact('application'))
                ->setPaper('a4', 'portrait');

            $pdfContent = $pdf->output();
            $filename = 'PSP-Letter-' . $application->user->name . '-' . now()->format('Ymd') . '.pdf';

            \Illuminate\Support\Facades\Mail::to($application->user->email)
                ->send(new \App\Mail\PspLetterMail($application, $pdfContent, $filename));
        }
    }

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
        return 'PSP application saved successfully';
    }
}
