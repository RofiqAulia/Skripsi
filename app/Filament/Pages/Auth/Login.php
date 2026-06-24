<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Validation\ValidationException;

use App\Traits\GeneratesMathCaptchaImage;

class Login extends BaseLogin
{
    use GeneratesMathCaptchaImage;

    // Use instance property for view path
    protected string $view = 'filament.pages.auth.login_custom';

    // Override layout to base layout to prevent standard SimplePage layout wrapper
    protected static string $layout = 'filament-panels::components.layout.base';

    public int $num1;
    public int $num2;
    public string $captchaImage;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->data = [
            'email' => '',
            'password' => '',
            'remember' => false,
            'captcha' => '',
        ];

        $this->generateCaptcha();
    }

    public function generateCaptcha(): void
    {
        $this->num1 = rand(1, 10);
        $this->num2 = rand(1, 10);
        $this->captchaImage = $this->generateCaptchaImage($this->num1, $this->num2);
        session(['admin_captcha_result' => $this->num1 + $this->num2]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        // Validate form input
        $this->validate([
            'data.email' => ['required', 'string', 'email'],
            'data.password' => ['required', 'string'],
            'data.captcha' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (intval($value) !== session('admin_captcha_result')) {
                    $fail('Anti-robot answer is incorrect.');
                }
            }],
        ], [
            'data.email.required' => 'Email is required.',
            'data.email.email' => 'Invalid email format.',
            'data.password.required' => 'Password is required.',
            'data.captcha.required' => 'Anti-robot field is required.',
            'data.captcha.numeric' => 'Anti-robot answer must be a number.',
        ]);

        $credentials = [
            'email' => $this->data['email'],
            'password' => $this->data['password'],
        ];

        /** @var \Illuminate\Auth\SessionGuard $authGuard */
        $authGuard = Filament::auth();

        $authProvider = $authGuard->getProvider();
        $user = $authProvider->retrieveByCredentials($credentials);

        if ((! $user) || (! $authProvider->validateCredentials($user, $credentials))) {
            $this->generateCaptcha();
            $this->fireFailedEvent($authGuard, $user, $credentials);
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::auth/pages/login.messages.failed'),
            ]);
        }

        if (! $authGuard->attemptWhen($credentials, function (\Illuminate\Contracts\Auth\Authenticatable $user): bool {
            if (! ($user instanceof \Filament\Models\Contracts\FilamentUser)) {
                return true;
            }

            return $user->canAccessPanel(Filament::getCurrentOrDefaultPanel());
        }, $this->data['remember'] ?? false)) {
            $this->generateCaptcha();
            $this->fireFailedEvent($authGuard, $user, $credentials);
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::auth/pages/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function getTitle(): string|Htmlable
    {
        return 'Admin Login';
    }
}
