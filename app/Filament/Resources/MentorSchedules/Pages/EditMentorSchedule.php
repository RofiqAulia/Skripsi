<?php

namespace App\Filament\Resources\MentorSchedules\Pages;

use App\Filament\Resources\MentorSchedules\MentorScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMentorSchedule extends EditRecord
{
    protected static string $resource = MentorScheduleResource::class;

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
        return 'Mentor schedule saved successfully';
    }

    protected function afterSave(): void
    {
        $schedule = $this->record;

        $sessions = \App\Models\MentoringSession::with(['user', 'mentor.user', 'schedule'])
            ->where('schedule_id', $schedule->id)
            ->get();

        foreach ($sessions as $session) {
            \Illuminate\Support\Facades\Mail::to($session->user->email)
                ->cc($session->mentor->user->email)
                ->send(new \App\Mail\MentoringScheduleUpdatedMail($session));
        }
    }
}
