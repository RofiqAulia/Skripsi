<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'email' => session('email', $request->email)
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $otpRecord = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->first();

        if (!$otpRecord || $otpRecord->otp !== $request->otp) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP tidak valid atau salah.'],
            ]);
        }

        if (\Carbon\Carbon::parse($otpRecord->created_at)->addMinutes(15)->isPast()) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP telah kedaluwarsa. Silakan minta kode baru.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();
        
        $user->forceFill([
            'password' => $request->password, // Mutator akan melakukan hashing, atau biarkan plain jika aplikasi ini sebelumnya tidak menggunakan Hash, tapi default laravel menggunakan Hash::make, wait - wait. PasswordResetLinkController sebelumnya langsung $user->password = $request->password;
        ])->save();

        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password Anda telah berhasil direset! Silakan login dengan password baru.');
    }
}

