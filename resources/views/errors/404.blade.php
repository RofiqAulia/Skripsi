@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')

@section('icon')
<div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-2 shadow-inner transition-transform hover:rotate-180 duration-500">
    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
</div>
@endsection

@section('message')
Halaman atau dokumen yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
@endsection

@section('best_practices')
    <li><strong>Periksa URL:</strong> Pastikan kembali alamat web (URL) yang Anda masukkan sudah benar, tanpa ada salah ketik.</li>
    <li><strong>Gunakan Navigasi Utama:</strong> Kembali ke Dashboard dan gunakan menu navigasi utama untuk mencari halaman penilaian atau modul yang Anda butuhkan.</li>
    <li><strong>Bersihkan Cache:</strong> Terkadang browser menyimpan tautan lama yang sudah tidak aktif. Cobalah untuk membersihkan cache browser Anda.</li>
    <li><strong>Perbarui Bookmark:</strong> Jika Anda menggunakan bookmark lama, perbarui bookmark tersebut setelah menemukan halaman yang benar dari Dashboard.</li>
@endsection
