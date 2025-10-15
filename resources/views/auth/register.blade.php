<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Jejak Layar</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-yellow-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-yellow-600">Daftar Akun Baru</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="/register" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="text" 
                       name="nama" 
                       placeholder="Nama lengkap" 
                       required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <div>
                <input type="email" 
                       name="email" 
                       placeholder="Email" 
                       required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <div>
                <input type="password" 
                       name="password" 
                       placeholder="Password" 
                       required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <button type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition">
                Daftar
            </button>

            <p class="text-center text-sm mt-4 text-gray-700">
                Sudah punya akun? 
                <a href="/login" class="text-yellow-600 font-medium hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
