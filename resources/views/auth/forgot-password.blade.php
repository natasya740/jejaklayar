<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi - Jejak Layar</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fffaf2; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-cover bg-center" style="background-image: url('{{ asset('images/Background.png') }}');">
    
    <!-- Overlay Gelap -->
    <div class="absolute inset-0 bg-black bg-opacity-40 z-0"></div>

    <div class="w-full max-w-md z-10">
        <div class="glass-card rounded-2xl shadow-2xl p-8 text-center transform transition-all hover:scale-[1.01]">
            
            <div class="mb-6">
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-key"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Lupa Kata Sandi?</h2>
                <p class="text-gray-500 text-sm mt-2">Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link reset.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm text-left">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div class="relative group text-left">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 ml-1">Email Terdaftar</label>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pt-6 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" placeholder="nama@email.com" required 
                        class="w-full py-3 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-amber-500/30 transition-all">
                    Kirim Link Reset
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-amber-600 transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>