@extends('layouts.dashboard_kontributor')

@section('title', 'Profil Saya')

@section('content')

<div class="page-header mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-gray-500">Kelola informasi akun & preferensi Anda.</p>
</div>

{{-- === CARD PROFIL UTAMA === --}}
<div class="w-full flex justify-center mb-8">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-3xl text-center border border-gray-100">

        {{-- Foto Profil --}}
        <img 
            src="{{ $user->avatar 
                ? asset('storage/profile/'.$user->avatar) 
                : asset('images/default-avatar.png') }}"
            alt="Avatar"
            class="w-32 h-32 rounded-full object-cover mx-auto mb-4"
        />

        {{-- Nama --}}
        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>

        {{-- Email --}}
        <p class="text-gray-500">{{ $user->email }}</p>

        {{-- Role --}}
        <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
            {{ ucfirst($user->role) }}
        </span>

    </div>
</div>

{{-- === CARD UPDATE PROFIL === --}}
<div class="w-full flex justify-center">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-3xl border border-gray-100">

        <h3 class="text-lg font-semibold text-gray-900 mb-6">Perbarui Profil</h3>

        <form action="{{ route('kontributor.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama --}}
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ $user->name }}"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-yellow-400"
                >
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ $user->email }}"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-yellow-400"
                >
            </div>

            {{-- Ganti Foto --}}
            <div class="mb-6">
                <label class="block mb-2 font-medium text-gray-700">Foto Profil Baru</label>
                <input 
                    type="file" 
                    name="avatar"
                    class="block w-full p-2 border rounded-lg bg-gray-50 cursor-pointer"
                >
                <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB.</p>
            </div>

            {{-- Tombol --}}
            <button 
                class="px-5 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg w-full"
            >
                Update Profil
            </button>

        </form>

    </div>
</div>

@endsection
