<?php

namespace App\Filament\Resources\MentoringReports\Pages;

use App\Filament\Resources\MentoringReports\MentoringReportResource;
use App\Mail\MentoringReportMail;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditMentoringReport extends EditRecord
{
    protected static string $resource = MentoringReportResource::class;

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
        return 'Mentoring report saved successfully';
    }

    protected function afterSave(): void
    {
        $report = $this->getRecord();
        $report->load('session.user', 'session.mentor.user');

        if ($report->session->user && $report->session->user->email) {
            $mail = Mail::to($report->session->user->email);
            if ($report->session->mentor && $report->session->mentor->user && $report->session->mentor->user->email) {
                $mail->cc($report->session->mentor->user->email);
            }
            $mail->send(new MentoringReportMail($report));
        }
    }
}
