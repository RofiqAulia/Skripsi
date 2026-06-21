@extends('errors.layout')

@section('title', 'Sesi Kedaluwarsa')
@section('code', '419')

@section('icon')
<div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-2 animate-pulse shadow-inner">
    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
</div>
@endsection

@section('message')
Sesi Anda telah kedaluwarsa karena tidak ada aktivitas selama beberapa waktu. Demi keamanan data Anda, sistem secara otomatis menutup sesi yang tidak aktif.
@endsection

@section('best_practices')
    <li><strong>Segarkan (Refresh) Halaman:</strong> Coba muat ulang halaman untuk mendapatkan token keamanan baru.</li>
    <li><strong>Simpan Draf Berkala:</strong> Untuk ke depannya, sangat disarankan agar Anda sering menyimpan pekerjaan (save as draft) agar terhindar dari kehilangan data jika sesi habis.</li>
    <li><strong>Login Kembali:</strong> Silakan kembali ke halaman awal dan <a href="{{ route('login') ?? url('/login') }}" class="underline font-semibold">login kembali</a> untuk melanjutkan pekerjaan penilaian Anda.</li>
@endsection
