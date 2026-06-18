<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset request directly.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        return redirect()->route('login')->with('status', 'Password Anda telah berhasil direset! Silakan login dengan password baru.');
    }
}
