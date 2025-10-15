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
        <h2 class="text-2xl font-bold text-center mb-6 text-yellow-600">Daftar Akun</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}" required class="w-full px-4 py-3 border rounded-lg">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="w-full px-4 py-3 border rounded-lg">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 border rounded-lg">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="w-full px-4 py-3 border rounded-lg">
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg">Daftar</button>
            <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-600">Login</a></p>
        </form>
    </div>
</body>
</html>
