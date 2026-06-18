<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name', 'SOVIA') }}</title>

    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet">

    {{-- Filament's own styles/scripts --}}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- SPLIT CARD ---- */
        .split-card {
            display: flex;
            width: 1000px;
            max-width: 95vw;
            min-height: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        /* ---- LEFT: FORM PANEL ---- */
        .left-panel {
            flex: 1;
            padding: 60px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .logos-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .logos-wrap img {
            height: 56px;
            object-fit: contain;
        }

        .form-title {
            font-size: 36px;
            font-weight: 800;
            text-align: center;
            color: #111;
            margin-bottom: 6px;
        }

        .form-subtitle {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 32px;
        }

        /* ---- FIELDS ---- */
        .field-wrap {
            margin-bottom: 18px;
        }

        .field-wrap label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-inner {
            position: relative;
        }

        .field-wrap input {
            width: 100%;
            padding: 14px 18px;
            background: #f3f4f6;
            border: 1.5px solid transparent;
            border-radius: 10px;
            font-size: 14px;
            color: #111;
            outline: none;
            transition: all 0.25s ease;
        }

        .field-wrap input:focus {
            background: #fff;
            border-color: #8b0000;
            box-shadow: 0 0 0 3px rgba(139,0,0,0.1);
        }

        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            padding: 0;
        }

        .toggle-pass:hover { color: #6b7280; }

        .text-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* ---- REMEMBER + FORGOT ---- */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            font-size: 13px;
        }

        .remember-row label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            cursor: pointer;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #8b0000;
            width: 15px;
            height: 15px;
        }

        .forgot-link {
            color: #8b0000;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .forgot-link:hover { text-decoration: underline; }

        /* ---- SUBMIT BUTTON ---- */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #8b0000;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-submit:hover {
            background: #6a0000;
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* ---- ERROR BANNER ---- */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #b91c1c;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 18px;
            text-align: center;
        }

        /* ---- RIGHT HERO PANEL ---- */
        .right-panel {
            flex: 1;
            background: #8b0000;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.08);
        }

        .rp-inner {
            position: relative;
            z-index: 2;
        }

        .rp-logo {
            width: 130px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1);
            opacity: 0.9;
        }

        .rp-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 30px;
            padding: 5px 16px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .rp-inner h2 {
            font-size: 34px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .rp-inner p {
            font-size: 15px;
            line-height: 1.7;
            opacity: 0.85;
            max-width: 300px;
        }

        .rp-divider {
            width: 50px;
            height: 3px;
            background: rgba(255,255,255,0.4);
            border-radius: 2px;
            margin: 24px auto;
        }

        .rp-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .rp-feature span { opacity: 1; }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 860px) {
            .split-card { flex-direction: column; border-radius: 0; min-height: 100vh; max-width: 100%; }
            .left-panel { padding: 40px 30px; }
            .right-panel { display: none; }
        }
    </style>
</head>
<body>

<div class="split-card">

    {{-- LEFT PANEL: FORM --}}
    <div class="left-panel">

        <div class="logos-wrap">
            @if(file_exists(public_path('images/logo/sig-latar-putih.png')))
                <img src="{{ asset('images/logo/sig-latar-putih.png') }}" alt="SIG" style="filter: none;">
            @elseif(file_exists(public_path('images/logo-sovia.png')))
                <img src="{{ asset('images/logo-sovia.png') }}" alt="SOVIA">
            @else
                <div style="font-size:22px; font-weight:800; color:#8b0000;">SOVIA</div>
            @endif
        </div>

        <div class="form-title">Admin Panel</div>
        <div class="form-subtitle">Log in to the system administrator panel</div>

        {{-- Error messages --}}
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <x-filament::form wire:submit="authenticate">
            {{ $this->form }}

            <x-filament::button
                type="submit"
                class="btn-submit"
                style="margin-top: 24px;"
            >
                SIGN IN
            </x-filament::button>
        </x-filament::form>

    </div>

    {{-- RIGHT PANEL: HERO --}}
    <div class="right-panel">
        <div class="rp-inner">

            @if(file_exists(public_path('images/logo/sig-latar-putih.png')))
                <img src="{{ asset('images/logo/sig-latar-putih.png') }}" class="rp-logo" alt="SIG Logo">
            @endif

            <div class="rp-badge">Admin Access</div>

            <h2>Insan SIG<br>Management<br>System</h2>

            <div class="rp-divider"></div>

            <p>Integrated management portal for scholarship management, mentoring, and HR development programs of Semen Indonesia Group.</p>

            <div style="margin-top: 30px;">
                <div class="rp-feature">
                    <span>✦</span> Scholarship Management
                </div>
                <div class="rp-feature">
                    <span>✦</span> Mentee Monitoring
                </div>
                <div class="rp-feature">
                    <span>✦</span> Reports & Analytics
                </div>
            </div>
        </div>
    </div>

</div>

@filamentScripts

<script>
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeOpen = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>`;
    const eyeClosed = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>`;
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = eyeClosed;
    } else {
        input.type = 'password';
        btn.innerHTML = eyeOpen;
    }
}
</script>

</body>
</html>
