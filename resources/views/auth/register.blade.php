@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Daftar Akun</h2>

   
   <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-4">
        <label class="block font-medium mb-1">Nama Lengkap</label>
        <input type="text" name="nama" class="w-full border rounded p-2" required autofocus>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Email</label>
        <input type="email" name="email" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-6">
        <label class="block font-medium mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Daftar
    </button>
</form>
