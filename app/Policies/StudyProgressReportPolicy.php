<?php

namespace App\Policies;

use App\Models\StudyProgressReport;
use App\Models\User;

class StudyProgressReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['mentee', 'pimpinan', 'super_admin', 'mentor']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StudyProgressReport $studyProgressReport): bool
    {
        return $user->hasAnyRole(['mentee', 'pimpinan', 'super_admin', 'mentor']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Khusus peserta (mentee)
        return $user->hasRole('mentee');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudyProgressReport $studyProgressReport): bool
    {
        // Pimpinan dan admin
        return $user->hasAnyRole(['pimpinan', 'super_admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudyProgressReport $studyProgressReport): bool
    {
        // Pimpinan dan admin
        return $user->hasAnyRole(['pimpinan', 'super_admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudyProgressReport $studyProgressReport): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudyProgressReport $studyProgressReport): bool
    {
        return $user->hasRole('super_admin');
    }
}
