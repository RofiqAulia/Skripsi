<?php

namespace App\Policies;

use App\Models\StudyPlan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudyPlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StudyPlan $studyPlan): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudyPlan $studyPlan): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudyPlan $studyPlan): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudyPlan $studyPlan): bool
    {
        return $user->hasRole('pimpinan');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudyPlan $studyPlan): bool
    {
        return $user->hasRole('pimpinan');
    }
}
