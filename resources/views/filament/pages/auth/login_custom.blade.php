<div class="login-wrapper">
    <div class="split-card">
        <!-- LEFT PANEL (FORM) -->
        <div class="left-panel">
            <div class="logos-container">
                <img src="{{ asset('images/logo-sovia.png') }}" alt="SOVIA Logo">
            </div>

            <div class="form-title">Admin Sign In</div>

            <!-- Error Notifications / Messages -->
            @if (session()->has('error') || $errors->has('data.email') || $errors->has('data.password') || $errors->has('data.captcha'))
                <div class="error-alert">
                    @if (session()->has('error'))
                        <div>{{ session('error') }}</div>
                    @endif
                    @error('data.email')
                        <div>{{ $message }}</div>
                    @enderror
                    @error('data.password')
                        <div>{{ $message }}</div>
                    @enderror
                    @error('data.captcha')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <form wire:submit="authenticate">
                @csrf

                <!-- Email Address -->
                <div class="input-group">
                    <input type="email" wire:model="data.email" required autofocus placeholder="Email" autocomplete="username">
                </div>

                <!-- Password -->
                <div class="input-group" style="position: relative;">
                    <input type="password" id="login-password" wire:model="data.password" required placeholder="Password" autocomplete="current-password" style="padding-right: 40px;">
                    <button type="button" onclick="togglePassword('login-password', this)" class="toggle-password-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>

                <!-- Anti Robot Captcha -->
                <div class="input-group">
                    <label class="captcha-label">Anti-robot: Solve the math problem</label>
                    <div style="margin-bottom: 10px;">
                        <img src="{{ $captchaImage }}" alt="Math Captcha" style="border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <input type="number" wire:model="data.captcha" required placeholder="Answer" autocomplete="off">
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-forgot-row">
                    <label class="remember-label">
                        <input type="checkbox" wire:model="data.remember">
                        Remember me
                    </label>
                    
                    @if (filament()->hasPasswordReset())
                        <div class="forgot-password">
                            <a href="{{ filament()->getRequestPasswordResetUrl() }}">
                                Forgot password?
                            </a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    SIGN IN
                </button>
            </form>
        </div>

        <!-- RIGHT PANEL (HERO) -->
        <div class="right-panel">
            <div class="right-panel-content">
                <h2>Insan SIG</h2>
                <p>Internal management portal to manage scholarships, mentoring, and study programs. Welcome, administrator.</p>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS STYLES SPECIFIC TO ADMIN LOGIN (matching guest login design) */
.login-wrapper {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    width: 100%;
}

.split-card {
    display: flex;
    width: 1000px;
    max-width: 95%;
    min-height: 600px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    overflow: hidden;
}

.left-panel {
    flex: 1;
    padding: 60px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #ffffff;
}

.right-panel {
    flex: 1;
    background: #8b0000; /* Deep red theme */
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.right-panel::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
    z-index: 1;
}

.right-panel-content {
    position: relative;
    z-index: 2;
}

.right-panel h2 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.right-panel p {
    font-size: 16px;
    line-height: 1.6;
    opacity: 0.9;
}

.logos-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.logos-container img {
    height: 60px;
    object-fit: contain;
}

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

.toggle-password-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    font-size: 16px;
    padding: 0;
}

.captcha-label {
    display: block;
    font-size: 14px;
    color: #4b5563;
    margin-bottom: 8px;
    font-weight: 600;
}

.remember-forgot-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px 0 25px;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #4b5563;
    cursor: pointer;
}

.remember-label input {
    width: auto;
    margin: 0;
}

.forgot-password a {
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
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
    background: #8b0000; /* Red color matching user preferences */
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

.error-alert {
    background-color: #fee2e2;
    border-left: 4px solid #ef4444;
    color: #991b1b;
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

@media (max-width: 900px) {
    .split-card {
        flex-direction: column;
        width: 100%;
        min-height: 100vh;
        border-radius: 0;
    }
    .left-panel {
        padding: 40px;
    }
    .right-panel {
        display: none;
    }
}
</style>

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
