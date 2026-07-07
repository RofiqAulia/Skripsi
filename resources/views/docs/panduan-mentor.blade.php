@extends('docs.layout')

@section('title', 'Buku Panduan Mentor')

@section('content')
<h2>1. Pendahuluan</h2>
<p>Buku panduan ini ditujukan bagi para <strong>Mentor</strong> di dalam ekosistem SOVIA. Sebagai Mentor, tugas utama Anda adalah membimbing mentee, mengevaluasi dokumen persyaratan mereka (seperti Essay/PSP), memberikan jadwal sesi, serta menyetujui pengajuan beasiswa mereka berdasarkan kompetensi.</p>

<h2>2. Dasbor Mentor (Mentor Dashboard)</h2>
<p>Halaman utama Anda adalah <strong>Mentor Dashboard</strong> yang berfokus pada statistik harian dan kegiatan operasional mentoring Anda.</p>
<ul>
    <li><strong>Jadwal Mendatang:</strong> Menampilkan sesi mentoring (online/offline) yang akan segera berlangsung dalam waktu dekat.</li>
    <li><strong>Review Dokumen:</strong> Antrean dokumen atau essay dari mentee Anda yang membutuhkan umpan balik (feedback).</li>
    <li><strong>Mentee Aktif:</strong> Statistik jumlah mentee yang berada di bawah bimbingan Anda.</li>
</ul>

<h2>3. Sesi Mentoring (Mentoring Sessions)</h2>
<p>Anda bertanggung jawab untuk merencanakan dan mendokumentasikan sesi dengan mentee.</p>
<h3>3.1 Membuat/Menyetujui Jadwal</h3>
<ol>
    <li>Mentee dapat meminta sesi bimbingan kepada Anda, atau Anda yang membuat jadwal dari menu <strong>Mentoring Sessions</strong>.</li>
    <li>Pilih nama mentee, tetapkan tanggal dan jam.</li>
    <li>Pilih jenis sesi (Online via Zoom/Gmeet, atau Offline).</li>
    <li>Masukkan tautan/lokasi pertemuan.</li>
</ol>

<h3>3.2 Mengisi Laporan (Mentoring Reports)</h3>
<div class="alert">
    <strong>Wajib:</strong> Setelah sesi selesai, Anda harus mengisi Laporan Mentoring agar sesi tersebut terhitung selesai (Done).
</div>
<ol>
    <li>Pilih sesi yang baru saja diselesaikan.</li>
    <li>Isi evaluasi singkat, topik yang dibahas, dan saran tindak lanjut untuk mentee.</li>
    <li>Setelah dilaporkan, mentee dapat melihat <em>feedback</em> tersebut dari panel mereka.</li>
</ol>

<div class="page-break"></div>

<h2>4. Review & Evaluasi Personal Statement (PSP)</h2>
<p>Salah satu tahap krusial sebelum mentee mengajukan beasiswa adalah penulisan PSP/Essay.</p>
<ul>
    <li>Buka menu <strong>PSP Applications</strong>.</li>
    <li>Pilih dokumen mentee yang berstatus "Submission" atau "In Review".</li>
    <li>Baca dokumen tersebut, berikan nilai/skor (jika ada rubrik) dan ketikkan <em>feedback</em> koreksi Anda.</li>
    <li>Jika essay dirasa sudah sempurna, Anda dapat mengubah statusnya menjadi <strong>Approved</strong> yang akan meneruskannya ke tahap selanjutnya (misalnya persetujuan Pimpinan/Admin). Jika perlu perbaikan, berikan status <strong>Revision Needed</strong>.</li>
</ul>

<h2>5. Komunikasi dengan Mentee</h2>
<p>Anda diharapkan membangun komunikasi proaktif. Anda dapat menggunakan informasi kontak mentee di menu <strong>My Mentees</strong> untuk mengirimkan email langsung atau menghubungi mereka melalui platform komunikasi yang disepakati.</p>
@endsection
