<!DOCTYPE html>
<html>
<head>
    <title>Mentoring Schedule Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <p>Dear <strong>{{ $session->mentor->user->name }}</strong> and <strong>{{ $session->user->name }}</strong>,</p>

    <p>Here is the confirmation regarding your mentoring schedule:</p>

    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 150px;"><strong>Mentee Name</strong></td>
            <td>: {{ $session->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Mentor Name</strong></td>
            <td>: {{ $session->mentor->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Mentoring Time</strong></td>
            <td>: {{ \Carbon\Carbon::parse($session->schedule->date)->format('d F Y') }}, {{ \Carbon\Carbon::parse($session->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->schedule->end_time)->format('H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Link Meet</strong></td>
            <td>: <a href="{{ $session->link_meet }}">{{ $session->link_meet }}</a></td>
        </tr>
    </table>

    <p>Please be present on time according to the designated schedule. If you have any issues or questions, please contact our team.</p>

    <p>Thank you for your attention and cooperation.</p>

    <p>Best Regards,<br>
    <strong>CLD Team</strong></p>

</body>
</html>
