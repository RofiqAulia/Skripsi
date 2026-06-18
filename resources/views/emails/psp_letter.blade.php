<!DOCTYPE html>
<html>
<head>
    <title>PSP Decision Letter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <p>Hello <strong>{{ $application->user->name }}</strong>,</p>

    <p>Thank you for applying to the Scholarship Preparation Program (PSP). Along with this email, we have attached the Decision Letter regarding your application.</p>

    <p>Your application status is currently: <strong>{{ $application->status === 'review' ? 'Revisi' : ucfirst($application->status) }}</strong>.</p>

    @if($application->notes)
    <div style="margin-top: 30px; padding: 20px; background-color: #fdf8f6; border-left: 4px solid #f43f5e; border-radius: 4px; text-align: center; color: #4c1d95; font-style: italic;">
        "{!! nl2br(e($application->notes)) !!}"
    </div>
    @endif

</body>
</html>
