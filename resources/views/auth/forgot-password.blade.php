<x-guest-layout>
    <style>
        .form-title {
            font-size: 32px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 20px;
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
        .btn-submit {
            width: 100%;
            max-width: 200px;
            margin: 30px auto 0;
            display: block;
            padding: 14px;
            background: #8b0000;
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
    </style>

    <div class="form-title">Reset Password</div>

    <div class="mb-4 text-sm text-gray-600 text-center" style="margin-bottom: 25px;">
        Silakan masukkan email yang terdaftar beserta password baru yang Anda inginkan. Password akan langsung diperbarui.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center" style="color: #8b0000; margin-bottom: 15px;" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Terdaftar">
            @error('email')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- New Password -->
        <div class="input-group" style="position: relative;">
            <input type="password" id="reset-password" name="password" required placeholder="Password Baru (Min: 8 karakter)" style="padding-right: 40px;">
            <button type="button" onclick="togglePassword('reset-password', this)" style="position: absolute; right: 15px; top: 15px; background: none; border: none; cursor: pointer; color: #6b7280; font-size: 16px; padding: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
            @error('password')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group" style="position: relative;">
            <input type="password" id="reset-password-confirm" name="password_confirmation" required placeholder="Konfirmasi Password Baru" style="padding-right: 40px;">
            <button type="button" onclick="togglePassword('reset-password-confirm', this)" style="position: absolute; right: 15px; top: 15px; background: none; border: none; cursor: pointer; color: #6b7280; font-size: 16px; padding: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
        </div>

        <button type="submit" class="btn-submit">
            RESET PASSWORD
        </button>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #6b7280; text-decoration: none; font-size: 14px;">Kembali ke Login</a>
        </div>
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
