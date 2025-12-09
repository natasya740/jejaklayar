<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Sandi - Jejak Layar</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Tambahkan reCAPTCHA -->
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-amber-500 p-6 text-center">
            <h2 class="text-white text-2xl font-bold">Reset Kata Sandi</h2>
            <p class="text-amber-100 text-sm mt-1">Buat kata sandi baru yang aman.</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-50 text-green-600 p-3 rounded-lg mb-4 text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500"
                        value="{{ request()->email }}" required readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required
                        class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required
                        class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none">
                </div>

                <!-- reCAPTCHA Checkbox -->
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 rounded-lg transition-all shadow-lg mt-2">
                    Simpan Sandi Baru
                </button>
            </form>
        </div>
    </div>

</body>

</html>
