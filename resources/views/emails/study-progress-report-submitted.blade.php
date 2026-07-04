<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Study Progress Report Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #b71c1c; text-align: center;">Study Progress Report Submitted</h2>
        
        <p>Halo,</p>
        
        <p>Laporan Perkembangan Studi (Study Progress Report) terbaru telah berhasil dikirimkan ke dalam sistem RPX Scholarship.</p>
        
        <p><strong>Rincian Pengirim:</strong></p>
        <ul>
            <li><strong>Nama:</strong> {{ $user->name }}</li>
            <li><strong>NIK:</strong> {{ $user->nik ?? '-' }}</li>
            <li><strong>Semester Laporan:</strong> Semester {{ $report->semester }}</li>
            <li><strong>IPK Saat Ini:</strong> {{ $report->gpa }} / {{ $report->max_gpa }}</li>
        </ul>
        
        <p>Laporan ini akan digunakan sebagai bahan evaluasi dan pemantauan perkembangan studi peserta program RPX Scholarship.</p>

        <p>Salinan lengkap dari laporan ini telah kami lampirkan dalam bentuk dokumen PDF (terlampir pada email ini) untuk dapat Anda simpan atau tinjau lebih lanjut.</p>
        
        <br>
        <p>Terima kasih,</p>
        <p><strong>Admin RPX Scholarship</strong></p>
    </div>
</body>
</html>
