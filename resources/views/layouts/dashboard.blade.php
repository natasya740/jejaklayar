<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Jejak Layar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR (Satu untuk Semua) -->
    <aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col shadow-xl z-20">
        <div class="h-16 flex items-center justify-center border-b border-slate-800">
            <h1 class="text-xl font-bold tracking-wider text-amber-500">
                <i class="fas fa-ship mr-2"></i>Jejak Layar
            </h1>
        </div>

        <nav class="flex-1 overflow-y-auto py-6">
            <ul class="space-y-1 px-3">
                
                <!-- LOGIKA 1: JIKA ADMIN -->
                @if(Auth::user()->role == 'admin')
                    <li class="px-3 py-2 text-xs font-bold text-slate-500 uppercase">Admin Panel</li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">
                            <i class="fas fa-chart-pie w-5"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.artikel.pending') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.artikel.*') ? 'bg-indigo-600' : '' }}">
                            <i class="fas fa-clipboard-check w-5"></i> Validasi
                        </a>
                    </li>
                @endif

                <!-- LOGIKA 2: JIKA KONTRIBUTOR -->
                @if(Auth::user()->role == 'kontributor')
                    <li class="px-3 py-2 text-xs font-bold text-slate-500 uppercase">Kontributor</li>
                    <li>
                        <a href="{{ route('kontributor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('kontributor.dashboard') ? 'bg-indigo-600' : '' }}">
                            <i class="fas fa-home w-5"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kontributor.artikel.form') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('kontributor.artikel.form') ? 'bg-indigo-600' : '' }}">
                            <i class="fas fa-pen-nib w-5"></i> Tulis Artikel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kontributor.artikel.saya') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('kontributor.artikel.saya') ? 'bg-indigo-600' : '' }}">
                            <i class="fas fa-file-alt w-5"></i> Artikel Saya
                        </a>
                    </li>
                @endif

                <!-- LOGOUT (Sama untuk keduanya) -->
                <li class="mt-6 pt-6 border-t border-slate-800">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-400 hover:text-white hover:bg-red-900/20 rounded-lg transition">
                            <i class="fas fa-sign-out-alt w-5"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- AREA KONTEN DINAMIS -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar Mobile -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 md:hidden">
            <span class="font-bold text-gray-700">Jejak Layar</span>
            <button class="text-gray-500"><i class="fas fa-bars"></i></button>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <!-- DISINI ISI DASHBOARD MASING-MASING AKAN MUNCUL -->
            @yield('content') 
        </main>
    </div>

</body>
</html>