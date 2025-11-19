@extends('layouts.kontributor')

@section('title', 'Profil Saya')

@section('content')

    <div class="page-header">
        <h1>Profil Saya</h1>
        <p>Kelola informasi akun dan preferensi Anda.</p>
    </div>

    <div class="dashboard-grid" style="grid-template-columns: 1fr 2fr;">
        
        <!-- KARTU FOTO PROFIL -->
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="margin-bottom: 20px;">
                    <img src="{{ asset('FOTO/avatar.png') }}" 
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random'"
                         alt="Avatar" 
                         style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--color-bg);">
                </div>
                <h3 style="margin-bottom: 5px; color: var(--color-text-header);">{{ Auth::user()->name }}</h3>
                <p style="color: var(--color-text-muted); margin-bottom: 20px;">{{ Auth::user()->email }}</p>
                <span class="badge approved">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>

        <!-- FORM EDIT PROFIL -->
        <div class="card">
            <div class="card-header">
                <h2>Edit Informasi</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('kontributor.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Group: Nama --}}
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-text-header);">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" 
                               style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 8px;" required>
                    </div>

                    {{-- Group: Email --}}
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-text-header);">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" 
                               style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 8px;" required>
                    </div>

                    {{-- Group: Ganti Foto --}}
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-text-header);">Ganti Foto Profil</label>
                        <input type="file" name="avatar" accept="image/*"
                               style="width: 100%; padding: 8px; background: var(--color-bg); border-radius: 8px;">
                        <small style="color: var(--color-text-muted);">Format: JPG, PNG. Maksimal 2MB.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection