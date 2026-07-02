<?php

namespace App\Policies;

use App\Models\Competency;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompetencyPolicy
{
    public function viewAny(User $user): bool { return false; }
    public function view(User $user, Competency $competency): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, Competency $competency): bool { return false; }
    public function delete(User $user, Competency $competency): bool { return false; }
    public function restore(User $user, Competency $competency): bool { return false; }
    public function forceDelete(User $user, Competency $competency): bool { return false; }
}
