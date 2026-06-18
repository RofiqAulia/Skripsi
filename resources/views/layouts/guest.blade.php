<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google" content="notranslate">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>

<link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
/* BASE */
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* CONTAINER */
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

/* LEFT PANEL (FORM) */
.left-panel {
    flex: 1;
    padding: 60px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #ffffff;
}

/* RIGHT PANEL (HERO) */
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

/* Add subtle pattern or gradient to the background */
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

/* RESPONSIVE */
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
        display: none; /* Hide hero on small screens */
    }
}
</style>
</head>
<body>

<div class="split-card">
    <!-- LEFT PANEL (FORM) -->
    <div class="left-panel">
        {{ $slot }}
    </div>

    <!-- RIGHT PANEL (HERO) -->
    <div class="right-panel">
        <div class="right-panel-content">
            <h2>Insan SIG</h2>
            <p>Welcome to our service portal. Please sign in with your registered account to access all the features and conveniences we provide.</p>
        </div>
    </div>
</div>

</body>
</html>