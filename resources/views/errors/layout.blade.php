<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SOVIA</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');
        
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(139, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        .error-code {
            font-size: 100px;
            font-weight: 800;
            background: linear-gradient(45deg, #8b0000, #ff4e50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            line-height: 1;
        }

        .error-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 20px 0 10px;
        }

        .error-message {
            font-size: 15px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .btn-home {
            display: inline-block;
            background: #8b0000;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-home:hover {
            background: #6a0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.3);
        }

        .logo-img {
            height: 40px;
            margin-bottom: 20px;
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            color: #8b0000;
        }

        .error-icon svg {
            width: 100%;
            height: 100%;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- Logo -->
        <img src="{{ asset('images/logo-sovia.png') }}" alt="SOVIA Logo" class="logo-img" onerror="this.style.display='none'">
        
        <div class="error-icon">
            @yield('icon')
        </div>

        <h1 class="error-code">@yield('code')</h1>
        <div class="error-title">@yield('title')</div>
        <p class="error-message">@yield('message')</p>
        
        <a href="{{ url('/') }}" class="btn-home">Back to Home</a>
    </div>
</body>
</html>
