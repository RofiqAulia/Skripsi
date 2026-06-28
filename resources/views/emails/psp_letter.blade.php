<!DOCTYPE html>
<html>
<head>
    <title>PSP Application Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <p>Dear <strong>{{ $application->user->name }}</strong>,</p>

    @if($application->status === 'approved')
        <p>Congratulations! We are pleased to inform you that your <strong>Scholarship Preparation Program (PSP)</strong> application has been <strong style="color: #16a34a;">Approved</strong>.</p>
    @elseif($application->status === 'review')
        <p>We have reviewed your <strong>Scholarship Preparation Program (PSP)</strong> application and it requires <strong style="color: #d97706;">Revision</strong>. Please review the notes below and resubmit your application.</p>
    @elseif($application->status === 'rejected')
        <p>We regret to inform you that your <strong>Scholarship Preparation Program (PSP)</strong> application has been <strong style="color: #dc2626;">Rejected</strong>. Please review the notes below for further details.</p>
    @else
        <p>Here is the latest update regarding your <strong>Scholarship Preparation Program (PSP)</strong> application.</p>
    @endif

    <p>Here are the details of your application:</p>

    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 180px;"><strong>Applicant Name</strong></td>
            <td>: {{ $application->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Application Status</strong></td>
            <td>:
                @if($application->status === 'approved')
                    <span style="color: #16a34a; font-weight: bold;">Approved ✅</span>
                @elseif($application->status === 'review')
                    <span style="color: #d97706; font-weight: bold;">Revision Required ⚠️</span>
                @elseif($application->status === 'rejected')
                    <span style="color: #dc2626; font-weight: bold;">Rejected ❌</span>
                @else
                    <span>{{ ucfirst($application->status) }}</span>
                @endif
            </td>
        </tr>
        @if($application->approver)
        <tr>
            <td><strong>Reviewed By</strong></td>
            <td>: {{ $application->approver->name }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Decision Date</strong></td>
            <td>: {{ now()->format('d F Y') }}</td>
        </tr>
    </table>

    @if($application->notes)
    <p><strong>Notes from Reviewer:</strong></p>
    <div style="margin-bottom: 20px; padding: 15px 20px; background-color: #fefce8; border-left: 4px solid #f59e0b; border-radius: 4px; color: #78350f;">
        {!! nl2br(e($application->notes)) !!}
    </div>
    @endif

    <p>Please find attached the official PSP Decision Letter as well as all related documents for your reference.</p>

    @if($application->status === 'review')
    <p>Kindly make the necessary revisions and resubmit your application at your earliest convenience.</p>
    @elseif($application->status === 'approved')
    <p>Please proceed with the next steps as instructed by your mentor.</p>
    @endif

    <p>If you have any questions or concerns, please do not hesitate to contact our team.</p>

    <p>Thank you for your attention and cooperation.</p>

    <p>Best Regards,<br>
    <strong>CLD Team</strong></p>

</body>
</html>
