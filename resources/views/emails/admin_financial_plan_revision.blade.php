<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .details {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .details ul {
            margin: 0;
            padding-left: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Revised Financial Plan Submitted</h2>
    </div>

    <p>Hello Admin,</p>

    <p>The user <strong>{{ $plan->user->name ?? 'User' }}</strong> has just resubmitted their Financial Plan after completing the requested revisions.</p>

    <div class="details">
        <strong>Details:</strong>
        <ul>
            <li><strong>Scholarship:</strong> {{ $plan->scholarshipApplication->programStudy->scholarship ?? 'N/A' }}</li>
            <li><strong>University:</strong> {{ $plan->scholarshipApplication->programStudy->university ?? 'N/A' }}</li>
            <li><strong>Country:</strong> {{ $plan->scholarshipApplication->programStudy->country ?? 'N/A' }}</li>
            <li><strong>Submitted At:</strong> {{ now()->format('d M Y, H:i') }}</li>
        </ul>
    </div>

    <p>Please review the updated Financial Plan in the admin dashboard.</p>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ url('/admin/financial-plans/' . $plan->id . '/edit') }}" class="btn">Review Financial Plan</a>
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; font-size: 14px; color: #666;">
        <p>Thanks,<br><strong>System</strong></p>
    </div>
</body>
</html>
