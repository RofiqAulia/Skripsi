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

    <div class="form-title">Lupa Password</div>

    <div class="mb-4 text-sm text-gray-600 text-center" style="margin-bottom: 25px;">
        Silakan masukkan email yang terdaftar. Kami akan mengirimkan kode OTP ke email Anda untuk melakukan reset password.
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

        <button type="submit" class="btn-submit">
            KIRIM OTP
        </button>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #6b7280; text-decoration: none; font-size: 14px;">Kembali ke Login</a>
        </div>
    </form>
</x-guest-layout>
