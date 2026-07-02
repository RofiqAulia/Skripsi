<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CountryPolicy
{
    public function viewAny(User $user): bool { return false; }
    public function view(User $user, Country $country): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, Country $country): bool { return false; }
    public function delete(User $user, Country $country): bool { return false; }
    public function restore(User $user, Country $country): bool { return false; }
    public function forceDelete(User $user, Country $country): bool { return false; }
}
