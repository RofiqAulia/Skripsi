@extends('errors.layout')

@section('title', 'Akses Tidak Sah (Unauthorized)')
@section('code', '401')

@section('icon')
<div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-2 shadow-inner">
    <svg class="w-12 h-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
</div>
@endsection

@section('message')
Anda belum terautentikasi oleh sistem. Anda perlu masuk (login) dengan akun yang valid untuk dapat mengakses fitur dan halaman penilaian ini.
@endsection

@section('best_practices')
    <li><strong>Pastikan Anda Telah Login:</strong> Pastikan Anda menggunakan akun yang benar dan sudah terdaftar di sistem.</li>
    <li><strong>Periksa Kredensial Anda:</strong> Periksa kembali username atau email serta kata sandi yang Anda masukkan. Pastikan tombol Caps Lock tidak aktif secara tidak sengaja.</li>
    <li><strong>Akses dari Perangkat Lain:</strong> Jika Anda sebelumnya login di perangkat lain, sistem mungkin meminta Anda untuk masuk kembali di perangkat ini demi keamanan.</li>
@endsection
