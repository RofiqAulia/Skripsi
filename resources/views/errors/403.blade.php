@extends('errors.layout')

@section('title', 'Akses Ditolak (Forbidden)')
@section('code', '403')

@section('icon')
<div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-2 animate-bounce shadow-inner">
    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
</div>
@endsection

@section('message')
Mohon maaf, Anda tidak memiliki izin untuk mengakses halaman ini atau melakukan tindakan tersebut. Sistem secara otomatis menolak akses untuk menjaga keamanan data.
@endsection

@section('best_practices')
    <li><strong>Periksa Hak Akses (Role):</strong> Pastikan akun Anda memiliki peran/role yang sesuai untuk mengakses modul penilaian ini.</li>
    <li><strong>Sesi Kedaluwarsa:</strong> Sesi login Anda mungkin sudah habis. Silakan coba <a href="{{ route('login') ?? url('/login') }}" class="underline font-semibold">login kembali</a>.</li>
    <li><strong>Hubungi Administrator:</strong> Jika Anda seharusnya memiliki akses, silakan hubungi tim IT atau Administrator sistem untuk penyesuaian hak akses.</li>
    <li><strong>Hindari Akses Paksa:</strong> Upaya berulang untuk masuk ke sistem tanpa izin dapat menyebabkan akun Anda diblokir sementara.</li>
@endsection
