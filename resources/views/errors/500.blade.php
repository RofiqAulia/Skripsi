@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')

@section('icon')
<div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-2 animate-pulse shadow-inner">
    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
</div>
@endsection

@section('message')
Whoops! Terjadi kesalahan pada server kami. Sistem sedang mengalami kendala yang tidak terduga saat memproses permintaan penilaian Anda.
@endsection

@section('best_practices')
    <li><strong>Tunggu dan Coba Lagi:</strong> Biasanya kendala server bersifat sementara. Silakan tunggu beberapa menit dan coba muat ulang halaman.</li>
    <li><strong>Hindari Submit Berulang:</strong> Jika Anda sedang mensubmit form (misalnya data penilaian atau pendaftaran), <strong>jangan mensubmit berulang kali</strong> untuk menghindari duplikasi data.</li>
    <li><strong>Cek Status Sistem:</strong> Pastikan tidak ada pengumuman pemeliharaan sistem (maintenance) dari pihak IT.</li>
    <li><strong>Laporkan Kendala:</strong> Jika masalah terus berlanjut, ambil tangkapan layar (screenshot) atau catat waktu kejadian, lalu laporkan kepada tim support teknis.</li>
@endsection
