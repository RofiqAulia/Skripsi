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
        $user = auth()->user();
        
        $updates = [];
        
        if ($user->hasRole('pimpinan') || $user->hasRole('super_admin')) {
            $applicant = $application->user;
            
            $applicantDept = $applicant->department;
            $applicantGroup = $applicant->group ?? $applicantDept?->group;
            $applicantDir = $applicant->direktorat ?? $applicantGroup?->direktorat;
            
            if ($user->department_id && $applicantDept && $user->department_id == $applicantDept->id) {
                $updates['department_approver_id'] = $user->id;
            }
            if ($user->group_id && $applicantGroup && $user->group_id == $applicantGroup->id) {
                $updates['group_approver_id'] = $user->id;
            }
            if ($user->direktorat_id && $applicantDir && $user->direktorat_id == $applicantDir->id) {
                $updates['direktorat_approver_id'] = $user->id;
            }
            
            $updates['approver_id'] = $user->id;
        }

        if (!empty($updates)) {
            $application->updateQuietly($updates);
        }

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
