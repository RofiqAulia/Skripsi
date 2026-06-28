<x-mail::message>
# Halo {{ $role == 'mentee' ? $session->user->name : $session->mentor->user->name }},

Mohon maaf, sesi mentoring Anda telah dibatalkan.

**Detail Sesi Mentoring:**
- **Tanggal:** {{ \Carbon\Carbon::parse($session->schedule->date)->translatedFormat('l, d F Y') }}
- **Waktu:** {{ \Carbon\Carbon::parse($session->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->schedule->end_time)->format('H:i') }}
- **Mentee:** {{ $session->user->name }}
- **Mentor:** {{ $session->mentor->user->name }}

Jika ada pertanyaan lebih lanjut, silakan hubungi admin atau jadwalkan ulang sesi mentoring Anda.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
