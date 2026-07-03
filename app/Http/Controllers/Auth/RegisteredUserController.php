<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departments = \App\Models\Department::orderBy('name')->get();
        $groups = \App\Models\Group::orderBy('name')->get();
        $direktorats = \App\Models\Direktorat::orderBy('name')->get();
        
        return view('auth.register', compact('departments', 'groups', 'direktorats'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'position' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'placement' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $departmentId = null;
        $groupId = null;
        $direktoratId = null;

        if (str_starts_with($request->placement, 'dept_')) {
            $departmentId = str_replace('dept_', '', $request->placement);
        } elseif (str_starts_with($request->placement, 'group_')) {
            $groupId = str_replace('group_', '', $request->placement);
        } elseif (str_starts_with($request->placement, 'dir_')) {
            $direktoratId = str_replace('dir_', '', $request->placement);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'company' => $request->company,
            'age' => $request->age,
            'photo' => $photoPath,
            'department_id' => $departmentId,
            'group_id' => $groupId,
            'direktorat_id' => $direktoratId,
            'password' => Hash::make($request->password),
        ]);

        // Secara otomatis assign role 'mentee' ke user yang baru daftar
        $user->assignRole('mentee');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
