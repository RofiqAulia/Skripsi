<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 14px; margin: 0; padding: 20px; }
        h1 { color: #1e3a8a; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; font-size: 24px; }
        h2 { color: #2563eb; margin-top: 30px; font-size: 18px; }
        h3 { color: #3b82f6; font-size: 16px; margin-top: 20px; }
        p { margin-bottom: 10px; text-align: justify; }
        ul, ol { margin-bottom: 15px; }
        li { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 12px; text-align: left; }
        th { background-color: #f1f5f9; color: #0f172a; }
        .page-break { page-break-after: always; }
        .cover { text-align: center; margin-top: 150px; margin-bottom: 150px; }
        .cover h1 { border: none; font-size: 36px; margin-bottom: 10px; color: #1e40af; }
        .cover h2 { color: #64748b; font-size: 20px; margin-top: 0; font-weight: 400; }
        .cover .logo { margin-bottom: 40px; font-weight: bold; font-size: 32px; color: #1e3a8a; }
        .cover .date { margin-top: 60px; font-size: 14px; color: #94a3b8; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; height: 30px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 5px; }
        .alert { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 10px 15px; margin: 15px 0; font-size: 13px; }
    </style>
</head>
<body>
    <div class="footer">
        SOVIA - Scholarship & Mentoring Platform | Dicetak pada {{ now()->translatedFormat('d F Y') }}
    </div>
    
    <div class="cover page-break">
        <div class="logo">SOVIA</div>
        <h1>@yield('title')</h1>
        <h2>Platform Mentoring & Beasiswa</h2>
        <div class="date">Edisi: {{ now()->translatedFormat('F Y') }}</div>
    </div>

    @yield('content')
</body>
</html>
