@extends('docs.layout')

@section('title', 'Buku Panduan Pimpinan')

@section('content')
<h2>1. Pendahuluan</h2>
<p>Buku panduan ini ditujukan bagi <strong>Pimpinan</strong> (Direktur, Department Head, atau Group Head). Sebagai pimpinan, peran utama Anda di dalam platform SOVIA adalah memantau (monitoring) progres keikutsertaan mentee, statistik keberhasilan program, dan memberikan persetujuan (approval) pada tahap tertentu untuk pengajuan beasiswa atau PSP.</p>

<h2>2. Executive Dashboard (Dashboard Monitoring Pimpinan)</h2>
<p>Saat Anda masuk (login) ke dalam sistem, Anda akan langsung diarahkan ke <strong>Executive Dashboard</strong>. Dashboard ini dirancang secara khusus untuk memberikan ringkasan data tingkat tinggi yang relevan bagi pimpinan.</p>

<h3>2.1 Filter Periode</h3>
<p>Di bagian atas dashboard, terdapat fitur filter <strong>Bulan</strong> dan <strong>Tahun</strong>. Mengubah nilai ini akan secara otomatis memperbarui seluruh data angka dan grafik pada halaman sesuai dengan periode yang Anda tentukan.</p>

<h3>2.2 Indikator Kinerja Utama (KPI Cards)</h3>
<p>Dashboard menampilkan metrik utama secara sekilas:</p>
<ul>
    <li><strong>Registered Mentees:</strong> Jumlah total peserta (mentee) yang tergabung dalam program.</li>
    <li><strong>Approved PSP:</strong> Jumlah aplikasi Personal Statement Program (PSP) yang telah berhasil disetujui penuh.</li>
    <li><strong>Scholarship Accepted:</strong> Jumlah mentee yang telah dinyatakan lulus/diterima di program beasiswa yang mereka lamar.</li>
    <li><strong>Financial Plan:</strong> Jumlah rencana keuangan (Financial Plan) yang telah disetujui untuk pencairan/dukungan dana.</li>
</ul>

<h3>2.3 Grafik dan Visualisasi Data</h3>
<p>Anda dapat menganalisis berbagai aspek melalui grafik:</p>
<ul>
    <li><strong>Scholarship Applications per Period:</strong> Grafik garis (line chart) yang membandingkan tren jumlah lamaran total dengan yang diterima dan ditolak dari waktu ke waktu.</li>
    <li><strong>Scholarship Status:</strong> Visualisasi persentase status lamaran beasiswa secara keseluruhan (Doughnut chart).</li>
    <li><strong>Accepted Scholarships by Country:</strong> Menunjukkan negara tujuan studi mana yang paling banyak menerima mentee kita.</li>
    <li><strong>PSP Status Distribution:</strong> Distribusi status dari seluruh pengajuan PSP (Submission, Review, Approved, Rejected).</li>
    <li><strong>Top Scholarships:</strong> Tabel daftar beasiswa yang paling diminati beserta tingkat kelulusan (success rate) dari mentee kita.</li>
</ul>

<div class="page-break"></div>

<h2>3. Tindak Lanjut & Persetujuan (Approval)</h2>
<div class="alert">
    <strong>Info:</strong> Fitur persetujuan bergantung pada hierarki dan alur kerja (workflow) organisasi Anda.
</div>
<p>Jika Anda merupakan atasan langsung atau pihak yang ditunjuk dalam alur persetujuan dokumen PSP atau rencana pendanaan tertentu, Anda akan melihat sebuah tabel notifikasi atau menu khusus untuk memberikan validasi (jika diaktifkan).</p>
<ol>
    <li>Buka modul terkait persetujuan.</li>
    <li>Klik untuk melihat detail dokumen, kelengkapan, dan rekomendasi dari mentor.</li>
    <li>Berikan catatan tambahan (jika ada), lalu klik tombol <strong>Approve</strong> atau <strong>Reject</strong>.</li>
</ol>

<h2>4. Mengakses Data Rinci</h2>
<p>Meskipun Anda memiliki akses Dashboard tingkat tinggi, Anda tetap dapat menavigasi menu di bilah kiri (Sidebar) untuk melihat daftar mentee secara rinci, membaca detail program beasiswa, atau memantau sesi mentoring yang sedang berjalan (jika diizinkan oleh kebijakan hak akses SOVIA).</p>
@endsection
