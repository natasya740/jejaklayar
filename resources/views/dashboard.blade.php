@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Kontributor</h1>
    <p class="text-gray-700 mb-4">Selamat datang, {{ Auth::user()->name }} 👋</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-2">Profil Saya</h2>
            <a href="#" class="text-blue-600 hover:underline">Lihat Profil</a>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-2">Data Budaya</h2>
            <a href="{{ route('budaya') }}" class="text-blue-600 hover:underline">Kelola Budaya</a>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-2">Data Pustaka</h2>
            <a href="{{ route('pustaka') }}" class="text-blue-600 hover:underline">Kelola Pustaka</a>
        </div>
    </div>
</div>
@endsection
