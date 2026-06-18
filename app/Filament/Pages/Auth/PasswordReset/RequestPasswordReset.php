<?php

namespace App\Filament\Pages\Auth\PasswordReset;

use Filament\Auth\Pages\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    protected string $view = 'filament.pages.auth.password-reset.request_custom';

    // Override layout to base layout to prevent standard SimplePage layout wrapper
    protected static string $layout = 'filament-panels::components.layout.base';

    public int $num1;
    public int $num2;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->data = [
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'captcha' => '',
        ];

        $this->generateCaptcha();
    }

    public function generateCaptcha(): void
    {
        $this->num1 = rand(1, 10);
        $this->num2 = rand(1, 10);
        session(['admin_reset_captcha_result' => $this->num1 + $this->num2]);
    }

    public function request(): void
    {
        // Validate form input
        $this->validate([
            'data.email' => ['required', 'string', 'email', 'exists:users,email'],
            'data.password' => ['required', 'string', 'min:8', 'confirmed'],
            'data.captcha' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (intval($value) !== session('admin_reset_captcha_result')) {
                    $fail('Perhitungan anti-robot salah.');
                }
            }],
        ], [
            'data.email.required' => 'Email wajib diisi.',
            'data.email.email' => 'Format email tidak valid.',
            'data.email.exists' => 'Email tidak terdaftar di sistem.',
            'data.password.required' => 'Password baru wajib diisi.',
            'data.password.min' => 'Password minimal 8 karakter.',
            'data.password.confirmed' => 'Konfirmasi password tidak cocok.',
            'data.captcha.required' => 'Anti-robot wajib diisi.',
            'data.captcha.numeric' => 'Anti-robot harus berupa angka.',
        ]);

        $user = User::where('email', $this->data['email'])->first();

        if ($user) {
            $user->password = $this->data['password'];
            $user->save();

            Notification::make()
                ->title('Password Berhasil Diubah')
                ->body('Password akun Anda telah sukses diperbarui. Silakan login kembali.')
                ->success()
                ->send();

            // Redirect back to login page
            redirect()->to(filament()->getLoginUrl());
            return;
        }

        $this->generateCaptcha();
        throw ValidationException::withMessages([
            'data.email' => 'Terjadi kesalahan. Silakan coba lagi.',
        ]);
    }

    public function getTitle(): string|Htmlable
    {
        return 'Reset Password';
    }
}
