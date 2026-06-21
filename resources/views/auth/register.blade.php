<x-guest-layout>
    <style>
        .form-title {
            font-size: 32px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 25px;
            color: #111;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .input-row .input-group {
            flex: 1;
            margin-bottom: 0;
        }
        .input-group input {
            width: 100%;
            padding: 12px 18px;
            background: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 14px;
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
        .input-group input[type="file"] {
            padding: 9px 18px;
            background: #f3f4f6;
            cursor: pointer;
        }
        .input-group input[type="file"]::file-selector-button {
            border: none;
            background: #e5e7eb;
            padding: 6px 12px;
            border-radius: 6px;
            color: #374151;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-right: 10px;
        }
        .input-group input[type="file"]::file-selector-button:hover {
            background: #d1d5db;
        }
        .btn-submit {
            width: 100%;
            max-width: 200px;
            margin: 20px auto 0;
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
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #6b7280;
        }
        .login-link a {
            color: #8b0000;
            font-weight: 600;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .input-row {
                flex-direction: column;
                gap: 0;
            }
            .input-row .input-group {
                margin-bottom: 15px;
            }
        }
    </style>

    <div class="logos-container" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 15px;">
        <img src="{{ asset('images/logo-sovia.png') }}" alt="SOVIA Logo" style="height: 50px; object-fit: contain;">
    </div>

    <div class="form-title">Create Account</div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name & Age -->
        <div class="input-row">
            <div class="input-group" style="flex: 2;">
                <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Full Name" autocomplete="name">
                @error('name')<span class="text-error">{{ $message }}</span>@enderror
            </div>
            <div class="input-group" style="flex: 1;">
                <input type="number" name="age" value="{{ old('age') }}" min="0" placeholder="Age">
                @error('age')<span class="text-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email Address" autocomplete="username">
            @error('email')<span class="text-error">{{ $message }}</span>@enderror
        </div>

        <!-- Position & Company -->
        <div class="input-row">
            <div class="input-group">
                <input type="text" name="position" value="{{ old('position') }}" placeholder="Position (Optional)" autocomplete="organization-title">
                @error('position')<span class="text-error">{{ $message }}</span>@enderror
            </div>
            <div class="input-group">
                <input type="text" name="company" value="{{ old('company') }}" placeholder="Company (Optional)" autocomplete="organization">
                @error('company')<span class="text-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Photo -->
        <div class="input-group">
            <input type="file" name="photo" accept="image/*" title="Upload Photo (Optional)">
            @error('photo')<span class="text-error">{{ $message }}</span>@enderror
        </div>

        <!-- Password & Confirm Password -->
        <div class="input-row">
            <div class="input-group">
                <input type="password" name="password" required placeholder="Password" autocomplete="new-password">
                @error('password')<span class="text-error">{{ $message }}</span>@enderror
            </div>
            <div class="input-group">
                <input type="password" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password">
                @error('password_confirmation')<span class="text-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <button type="submit" class="btn-submit">
            REGISTER
        </button>

        <div class="login-link">
            Already registered? <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </form>
</x-guest-layout>
