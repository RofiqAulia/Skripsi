@extends('docs.layout')

@section('title', 'Buku Panduan Administrator')

@section('content')
<h2>1. Pendahuluan</h2>
<p>Buku panduan ini ditujukan bagi <strong>Administrator</strong> (Super Admin) sistem SOVIA. Sebagai Admin, Anda memiliki hak akses penuh terhadap seluruh fitur platform, mulai dari manajemen pengguna, verifikasi dokumen, hingga pengaturan master data beasiswa dan program studi.</p>

<h2>2. Dasbor Monitoring (Executive Dashboard)</h2>
<p>Saat Anda berhasil login, halaman pertama yang muncul adalah <strong>Dashboard Monitoring</strong>.</p>
<ul>
    <li><strong>Filter Periode:</strong> Anda dapat memfilter data statistik berdasarkan bulan dan tahun.</li>
    <li><strong>Notifikasi Tindak Lanjut:</strong> Jika ada antrean dokumen, PSP, atau sesi mentoring yang menunggu persetujuan, notifikasi peringatan akan muncul di atas dashboard.</li>
    <li><strong>Kartu Statistik (KPI):</strong> Menampilkan angka ringkasan seperti jumlah mentee terdaftar, progres dokumen, hingga jumlah mentee yang lolos beasiswa.</li>
    <li><strong>Grafik & Tabel:</strong> Menyajikan analisis mendalam terkait pendaftar beasiswa per periode, distribusi status PSP, sesi mentoring, dan beasiswa terpopuler.</li>
</ul>

<h2>3. Manajemen Master Data</h2>
<p>Modul Master Data adalah jantung dari sistem SOVIA. Data yang dikelola di sini akan digunakan di seluruh modul lain.</p>
<ul>
    <li><strong>Data Beasiswa (Scholarships):</strong> Anda dapat menambah, mengedit, atau menonaktifkan program beasiswa. Pastikan untuk mengisi deskripsi, negara tujuan, batas waktu pendaftaran (deadline), dan link pendaftaran asli beasiswa tersebut.</li>
    <li><strong>Program Studi & Universitas:</strong> Tambahkan program studi dan universitas yang didukung agar mentee dapat memilihnya saat mengajukan PSP.</li>
    <li><strong>Kompetensi (Competencies):</strong> Tentukan jenis-jenis kompetensi yang diperlukan untuk proses mentoring.</li>
</ul>

<h2>4. Manajemen Pengguna (User Management)</h2>
<p>Admin bertugas untuk mengelola akun Pimpinan, Mentor, dan Mentee.</p>
<ul>
    <li><strong>Membuat Akun Baru:</strong> Buka menu "Users" &gt; klik "New User". Isikan nama, email, kata sandi awal, dan tetapkan peran (role) yang sesuai.</li>
    <li><strong>Menentukan Atasan (Group Head/Department):</strong> Pastikan struktur organisasi sudah benar dengan mengatur departemen dan grup untuk pimpinan/mentor.</li>
</ul>

<h2>5. Verifikasi dan Tindak Lanjut (Action Required)</h2>
<div class="alert">
    <strong>Penting:</strong> Selalu periksa panel notifikasi Tindak Lanjut di Dashboard Anda setiap hari.
</div>
<h3>5.1 Verifikasi Dokumen Mentee</h3>
<p>Semua dokumen yang diunggah oleh mentee (KTP, Ijazah, sertifikat TOEFL/IELTS) harus diverifikasi keabsahannya.</p>
<ol>
    <li>Buka menu <strong>Documents</strong>.</li>
    <li>Filter dokumen dengan status "Pending" atau "Under Review".</li>
    <li>Klik pada tombol View/Edit, periksa pratinjau dokumen.</li>
    <li>Ubah status menjadi <strong>Approved</strong> (jika sesuai) atau <strong>Rejected</strong> (dengan memberikan catatan alasan penolakan).</li>
</ol>

<h3>5.2 Verifikasi Personal Statement (PSP) & Financial Plan</h3>
<p>Pengajuan PSP dan Perencanaan Keuangan (Financial Plan) akan masuk ke antrean Admin setelah melalui tahap review mentor atau pimpinan. Admin bertugas menyetujui tahap akhir pencairan dana (jika relevan) atau meneruskan ke sistem pendanaan internal.</p>

<div class="page-break"></div>

<h2>6. Mentoring System</h2>
<p>Sebagai Admin, Anda dapat memantau seluruh jadwal sesi mentoring yang dibuat oleh Mentor maupun Mentee. Jika terjadi konflik jadwal atau keluhan dari mentee, Anda dapat membukakan akses, membatalkan, atau mengubah status jadwal tersebut dari menu <strong>Mentoring Sessions</strong>.</p>

<h2>7. Panduan Trouble-shooting Dasar</h2>
<ul>
    <li><strong>Mentee tidak bisa login:</strong> Pastikan akunnya aktif dan role "mentee" telah terpasang. Anda dapat melakukan reset password melalui menu Users.</li>
    <li><strong>Dokumen tidak bisa diunggah:</strong> Periksa apakah ukuran file melebihi batas (biasanya 5MB) dan ekstensi file yang diizinkan (PDF/JPG/PNG).</li>
</ul>
@endsection
