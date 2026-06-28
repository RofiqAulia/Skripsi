<!DOCTYPE html>
<html>
<head>
    <title>Mentoring Report Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <p>Dear <strong>{{ $report->session->user->name ?? 'Mentee' }}</strong> and <strong>{{ $report->session->mentor->user->name ?? 'Mentor' }}</strong>,</p>

    <p>A mentoring report for meeting number <strong>{{ $report->meeting_number }}</strong> has been submitted.</p>

    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 150px;"><strong>Mentee Name</strong></td>
            <td>: {{ $report->session->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Mentor Name</strong></td>
            <td>: {{ $report->session->mentor->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Summary</strong></td>
            <td>: {{ $report->summary }}</td>
        </tr>
        <tr>
            <td><strong>Output</strong></td>
            <td>: {{ $report->output ?? '-' }}</td>
        </tr>
    </table>

    @if($report->file)
    <p>Please find the attached mentoring report document.</p>
    @endif

    <p>Thank you for your attention and cooperation.</p>

    <p>Best Regards,<br>
    <strong>CLD Team</strong></p>

</body>
</html>
