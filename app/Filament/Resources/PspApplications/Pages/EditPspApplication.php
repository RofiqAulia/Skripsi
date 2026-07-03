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
        
        // Auto-fill approver IDs based on who is saving the form
        $user = auth()->user();
        if ($user->hasRole('pimpinan') || $user->hasRole('super_admin')) {
            $applicant = $this->record->user;
            
            // If the approver is the applicant's Department Head
            if ($user->department_id && $applicant && $user->department_id == $applicant->department_id) {
                $data['department_approver_id'] = $user->id;
            }
            // If the approver is the applicant's Group Head
            if ($user->group_id && $applicant && $user->group_id == $applicant->group_id) {
                $data['group_approver_id'] = $user->id;
            }
            // If the approver is the applicant's Direktorat Head
            if ($user->direktorat_id && $applicant && $user->direktorat_id == $applicant->direktorat_id) {
                $data['direktorat_approver_id'] = $user->id;
            }
            
            // Always set as the final approver if they interacted with it
            $data['approver_id'] = $user->id;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $application = $this->record;

        if (in_array($application->status, ['approved', 'review', 'rejected']) && $this->oldStatus !== $application->status) {
            $application->load([
                'user',
                'scholarship.programStudy',
                'studyPlan',
                'approver',
            ]);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.psp-letter', compact('application'))
                ->setPaper('a4', 'portrait');

            $pdfContent = $pdf->output();
            $filename = 'PSP-Letter-' . $application->user->name . '-' . now()->format('Ymd') . '.pdf';

            \Illuminate\Support\Facades\Mail::to($application->user->email)
                ->cc(config('mail.from.address'))
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
