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
        
        $user = auth()->user();
        if ($user->hasRole('pimpinan') || $user->hasRole('super_admin')) {
            $applicant = $this->record->user;
            
            $applicantDept = $applicant->department;
            $applicantGroup = $applicant->group ?? $applicantDept?->group;
            $applicantDir = $applicant->direktorat ?? $applicantGroup?->direktorat;
            
            $isDeptHead = $user->department_id || \App\Models\Department::where('head_id', $user->id)->exists();
            $isGroupHead = $user->group_id || \App\Models\Group::where('head_id', $user->id)->exists();
            $isDirHead = $user->direktorat_id || \App\Models\Direktorat::where('head_id', $user->id)->exists();

            if ($isDeptHead) {
                $data['department_approver_id'] = $user->id;
                $data['department_approved_at'] = $data['department_approved_at'] ?? now();
            }
            if ($isGroupHead) {
                $data['group_approver_id'] = $user->id;
                $data['group_approved_at'] = $data['group_approved_at'] ?? now();
            }
            if ($isDirHead) {
                $data['direktorat_approver_id'] = $user->id;
                $data['direktorat_approved_at'] = $data['direktorat_approved_at'] ?? now();
            }
            
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
