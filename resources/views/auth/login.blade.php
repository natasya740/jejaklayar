@extends('layouts.guest')

@section('content')
<h2 class="text-2xl font-bold text-center mb-6">Login</h2>

@if(session('status'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label class="block font-medium mb-1">Email</label>
        <input type="email" name="email" class="w-full border rounded p-2" required autofocus>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
    </div>

    <div class="flex justify-between items-center mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="mr-2"> Ingat saya
        </label>
        <a href="#" class="text-sm text-blue-600 hover:underline">Lupa Password?</a>
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Login
    </button>

    <p class="text-center mt-4 text-sm">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
    </p>
</form>
@endsection
