<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased h-screen flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
        <div class="absolute top-1/4 -right-24 w-96 h-96 bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-24 left-1/3 w-96 h-96 bg-orange-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
    </div>

    <div class="z-10 bg-white/80 backdrop-blur-xl shadow-2xl rounded-[2rem] border border-white/50 p-8 sm:p-12 max-w-3xl w-[90%] text-center transform transition-all hover:scale-[1.01] duration-500">
        <div class="mb-6 flex justify-center">
            @yield('icon')
        </div>
        
        <h1 class="text-7xl sm:text-8xl font-extrabold text-red-700 tracking-tighter mb-2 drop-shadow-sm">@yield('code')</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 tracking-tight">@yield('title')</h2>
        
        <div class="text-base sm:text-lg text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">
            @yield('message')
        </div>

        <div class="bg-red-50/70 backdrop-blur-sm rounded-2xl p-6 border border-red-100/80 mb-8 text-left shadow-inner">
            <h3 class="text-red-800 font-bold mb-4 flex items-center text-lg">
                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Best Practices & Rekomendasi
            </h3>
            <ul class="text-sm text-red-900/80 space-y-3 list-disc list-inside">
                @yield('best_practices')
            </ul>
        </div>

        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
            <button onclick="window.history.back()" class="px-6 py-3 rounded-xl font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:shadow-md transition-all duration-300 focus:ring-4 focus:ring-gray-100 focus:outline-none">
                Kembali ke Halaman Sebelumnya
            </button>
            <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 shadow-lg shadow-red-500/30 hover:shadow-red-500/50 transition-all duration-300 focus:ring-4 focus:ring-red-200 focus:outline-none">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
