<?php

namespace App\Policies;

use App\Models\ScholarshipApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScholarshipApplicationPolicy
{
    public function viewAny(User $user): bool { return $user->hasAnyRole(['pimpinan', 'mentor']); }
    public function view(User $user, ScholarshipApplication $application): bool { return $user->hasAnyRole(['pimpinan', 'mentor']); }
    public function create(User $user): bool { return $user->hasRole('pimpinan'); }
    public function update(User $user, ScholarshipApplication $application): bool { return $user->hasRole('pimpinan'); }
    public function delete(User $user, ScholarshipApplication $application): bool { return $user->hasRole('pimpinan'); }
    public function restore(User $user, ScholarshipApplication $application): bool { return $user->hasRole('pimpinan'); }
    public function forceDelete(User $user, ScholarshipApplication $application): bool { return $user->hasRole('pimpinan'); }
}
