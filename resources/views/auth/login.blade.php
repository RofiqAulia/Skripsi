<x-guest-layout>
    <style>
        .form-title {
            font-size: 40px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 30px;
            color: #111;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group input {
            width: 100%;
            padding: 15px 20px;
            background: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 15px;
            color: #333;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        .input-group input:focus {
            background: #ffffff;
            border-color: #8b0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        .forgot-password {
            text-align: center;
            margin: 25px 0 30px;
        }
        .forgot-password a {
            color: #6b7280;
            text-decoration: none;
            font-size: 15px;
        }
        .forgot-password a:hover {
            color: #111;
            text-decoration: underline;
        }
        .btn-submit {
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            display: block;
            padding: 14px;
            background: #00b894;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-submit:hover {
            background: #6a0000;
            transform: translateY(-2px);
        }
        .text-error {
            color: #e3342f;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        .captcha-label {
            display: block;
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 8px;
            font-weight: 600;
        }
    </style>

    <div class="logos-container" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;">
        <img src="{{ asset('images/logo-sovia.png') }}" alt="SOVIA Logo" style="height: 60px; object-fit: contain;">
    </div>

    <div class="form-title">Sign In</div>

    <x-auth-session-status class="mb-4 text-center" style="color: #8b0000; margin-bottom: 15px;" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" autocomplete="username">
            @error('email')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group" style="position: relative;">
            <input type="password" id="login-password" name="password" required placeholder="Password" autocomplete="current-password" style="padding-right: 40px;">
            <button type="button" onclick="togglePassword('login-password', this)" style="position: absolute; right: 15px; top: 15px; background: none; border: none; cursor: pointer; color: #6b7280; font-size: 16px; padding: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
            @error('password')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Anti Robot Captcha -->
        <div class="input-group">
            <label class="captcha-label">Anti-robot: What is the result of {{ $num1 ?? rand(1,10) }} + {{ $num2 ?? rand(1,10) }}?</label>
            <input type="number" name="captcha" required placeholder="Answer" autocomplete="off">
            @error('captcha')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="forgot-password">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-submit" style="background: #8b0000;">
            SIGN IN
        </button>
    </form>

    <script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>`;
        }
    }
    </script>
</x-guest-layout>
