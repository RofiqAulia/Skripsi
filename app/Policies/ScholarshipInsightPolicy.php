<?php

namespace App\Policies;

use App\Models\ScholarshipInsight;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScholarshipInsightPolicy
{
    public function viewAny(User $user): bool { return false; }
    public function view(User $user, ScholarshipInsight $insight): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, ScholarshipInsight $insight): bool { return false; }
    public function delete(User $user, ScholarshipInsight $insight): bool { return false; }
    public function restore(User $user, ScholarshipInsight $insight): bool { return false; }
    public function forceDelete(User $user, ScholarshipInsight $insight): bool { return false; }
}
