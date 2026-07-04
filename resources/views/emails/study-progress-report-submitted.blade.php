<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Study Progress Report Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #b71c1c; text-align: center;">Study Progress Report Submitted</h2>
        
        <p>Dear Sir/Madam,</p>
        
        <p>A new Study Progress Report has been successfully submitted and is now available for your review.</p>
        
        <p><strong>Submission Details:</strong></p>
        <ul>
            <li><strong>Name:</strong> {{ $user->name }}</li>
            <li><strong>Employee ID:</strong> {{ $user->nik ?? '-' }}</li>
            <li><strong>Reporting Semester:</strong> Semester {{ $report->semester }}</li>
            <li><strong>Current GPA:</strong> {{ $report->gpa }} / {{ $report->max_gpa }}</li>
        </ul>
        
        <p>This report has been submitted for your information and will serve as part of the evaluation and monitoring of the participant's academic progress throughout the scholarship program.</p>

        <p>A complete copy of the submitted report is attached to this email in PDF format for your reference and record.</p>
        
        <br>
        <p>Thank you for your attention.</p>
        <br>
        <p>Kind regards,</p>
        <p><strong>Department of CLD</strong></p>
    </div>
</body>
</html>
