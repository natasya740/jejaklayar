<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jejak Layar | Auth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen flex items-center justify-center text-gray-800">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        @yield('content')
    </div>

</body>
</html>
