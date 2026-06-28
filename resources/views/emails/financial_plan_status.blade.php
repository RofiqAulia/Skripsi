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
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .notes-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #c0392b;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Status Update for Your Financial Plan</h2>
    </div>

    <p>Hello <strong>{{ $plan->user->name ?? 'User' }}</strong>,</p>

    <p>The status of your Financial Plan for <strong>{{ $plan->scholarshipApplication->programStudy->scholarship ?? 'Scholarship' }}</strong> at <strong>{{ $plan->scholarshipApplication->programStudy->university ?? 'University' }}</strong> has been updated by the Admin.</p>

    <p><strong>Current Status:</strong> <span class="status-badge">{{ str_replace('_', ' ', $plan->status) }}</span></p>

    @if($plan->status === 'revision_needed')
        <div class="notes-box">
            <h4 style="margin-top: 0; margin-bottom: 10px; color: #991b1b;">Admin Notes for Revision:</h4>
            <p style="margin: 0;">{{ $plan->admin_notes ?? 'No additional notes provided.' }}</p>
        </div>
        <p>Please update your Financial Plan based on the feedback above and resubmit it for review.</p>
    @elseif($plan->status === 'approved')
        <p>Congratulations! Your Financial Plan has been <strong>Approved</strong>.</p>
        <p>We have attached the officially approved Financial Plan document (PDF) to this email for your records.</p>
        
        @if($plan->admin_notes)
            <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; margin: 15px 0; border-radius: 4px;">
                <h4 style="margin-top: 0; margin-bottom: 10px; color: #166534;">Admin Notes:</h4>
                <p style="margin: 0;">{{ $plan->admin_notes }}</p>
            </div>
        @endif
    @endif

    <div style="text-align: center;">
        <a href="{{ url('/financial-plan') }}" class="btn">View My Financial Plan</a>
    </div>

    <div class="footer">
        <p>Thanks,<br><strong>Department of CLD</strong></p>
    </div>
</body>
</html>
