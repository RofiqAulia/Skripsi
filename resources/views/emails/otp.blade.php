<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #8b0000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #8b0000;
            margin: 0;
        }
        .content {
            font-size: 16px;
        }
        .otp-box {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            display: inline-block;
            font-size: 32px;
            font-weight: bold;
            color: #8b0000;
            background: #f3f4f6;
            padding: 15px 30px;
            border-radius: 8px;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Permintaan Reset Password</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mereset password akun Anda. Silakan gunakan kode OTP di bawah ini untuk melanjutkan proses reset password. Kode ini hanya berlaku selama 15 menit.</p>
            
            <div class="otp-box">
                <span class="otp-code">{{ $otp }}</span>
            </div>
            
            <p>Jika Anda tidak meminta reset password, abaikan email ini. Pastikan untuk tidak membagikan kode OTP ini kepada siapa pun.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Corporate Learning & Dev. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
