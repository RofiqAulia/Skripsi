<?php

namespace App\Observers;

use App\Models\ProgramStudy;

class ProgramStudyObserver
{
    /**
     * Handle the ProgramStudy "created" event.
     */
    public function created(ProgramStudy $programStudy): void
    {
        //
    }

    /**
     * Handle the ProgramStudy "updated" event.
     */
    public function updated(ProgramStudy $programStudy): void
    {
        if ($programStudy->isDirty('status') && $programStudy->submitted_by) {
            $user = $programStudy->submitter;
            if ($user && $user->email) {
                \Illuminate\Support\Facades\Mail::to($user->email)
                    ->cc('mrofiqaulia@gmail.com')
                    ->send(new \App\Mail\ProgramStudyStatusUpdated($programStudy));
            }
        }
    }

    /**
     * Handle the ProgramStudy "deleted" event.
     */
    public function deleted(ProgramStudy $programStudy): void
    {
        //
    }

    /**
     * Handle the ProgramStudy "restored" event.
     */
    public function restored(ProgramStudy $programStudy): void
    {
        //
    }

    /**
     * Handle the ProgramStudy "force deleted" event.
     */
    public function forceDeleted(ProgramStudy $programStudy): void
    {
        //
    }
}
