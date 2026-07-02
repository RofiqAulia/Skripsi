<?php

namespace App\Policies;

use App\Models\FinancialPlan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FinancialPlanPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('pimpinan'); }
    public function view(User $user, FinancialPlan $financialPlan): bool { return $user->hasRole('pimpinan'); }
    public function create(User $user): bool { return $user->hasRole('pimpinan'); }
    public function update(User $user, FinancialPlan $financialPlan): bool { return $user->hasRole('pimpinan'); }
    public function delete(User $user, FinancialPlan $financialPlan): bool { return $user->hasRole('pimpinan'); }
    public function restore(User $user, FinancialPlan $financialPlan): bool { return $user->hasRole('pimpinan'); }
    public function forceDelete(User $user, FinancialPlan $financialPlan): bool { return $user->hasRole('pimpinan'); }
}
