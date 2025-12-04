@extends('layouts.dashboard_kontributor')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi profil Anda')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between animate-fade-in">
        <div class="flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-center gap-2 mb-2">
            <i class="fa fa-exclamation-circle"></i>
            <span class="font-semibold">Terjadi kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kontributor.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Card: Foto Profil -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-yellow-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa fa-camera text-yellow-600"></i>
                    Foto Profil
                </h3>
            </div>

            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Preview Photo -->
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-yellow-400 shadow-lg bg-gradient-to-br from-yellow-400 to-yellow-500">
                            @if($user->avatar)
                                <img src="{{ asset('storage/profile/' . $user->avatar) }}" 
                                     alt="Avatar Preview" 
                                     id="avatarPreview"
                                     class="w-full h-full object-cover">
                            @else
                                <div id="avatarPreview" class="w-full h-full flex items-center justify-center text-white text-4xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Overlay Icon -->
                        <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('avatar').click()">
                            <i class="fa fa-camera text-white text-2xl"></i>
                        </div>
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1 w-full">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Foto Baru
                        </label>
                        <input type="file" 
                               name="avatar" 
                               id="avatar"
                               accept="image/*"
                               onchange="previewAvatar(this)"
                               class="block w-full text-sm text-gray-500 
                                      file:mr-4 file:py-3 file:px-4 
                                      file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold 
                                      file:bg-yellow-500 file:text-white 
                                      hover:file:bg-yellow-600 
                                      file:cursor-pointer cursor-pointer
                                      file:transition-colors">
                        
                        @error('avatar')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="fa fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror

                        <div class="mt-3 space-y-1">
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fa fa-info-circle text-blue-500"></i>
                                Semua format gambar didukung
                            </p>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fa fa-info-circle text-blue-500"></i>
                                Tidak ada batasan ukuran file
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Informasi Pribadi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa fa-user-edit text-blue-600"></i>
                    Informasi Pribadi
                </h3>
            </div>

            <div class="p-6 space-y-5">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all @error('name') border-red-500 @enderror"
                               required
                               maxlength="100"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all @error('email') border-red-500 @enderror"
                               required
                               placeholder="email@example.com">
                    </div>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fa fa-lightbulb text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-blue-900 mb-2">Tips:</p>
                            <ul class="space-y-1 text-blue-800">
                                <li class="flex items-start gap-2">
                                    <i class="fa fa-check text-blue-600 mt-1"></i>
                                    <span>Pastikan email yang Anda gunakan masih aktif</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa fa-check text-blue-600 mt-1"></i>
                                    <span>Foto profil akan ditampilkan pada setiap artikel yang Anda buat</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa fa-check text-blue-600 mt-1"></i>
                                    <span>Gunakan foto yang jelas dan profesional</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa fa-check text-blue-600 mt-1"></i>
                                    <span>Tidak ada batasan ukuran file</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 mb-8">
            <button type="submit" 
                    class="flex-1 px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all font-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fa fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
            
            <a href="{{ route('kontributor.profil') }}" 
               class="px-6 py-4 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all font-bold flex items-center justify-center gap-2">
                <i class="fa fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>

<script>
// Preview avatar before upload (TANPA VALIDASI UKURAN DAN FORMAT)
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Preview image langsung tanpa validasi
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            
            if (preview) {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    // Replace div with img
                    const img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    preview.parentNode.replaceChild(img, preview);
                }
            }
        }
        reader.readAsDataURL(file);
    }
}

// Auto hide messages after 5 seconds
setTimeout(() => {
    const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
    messages.forEach(msg => {
        msg.style.transition = 'opacity 0.5s, transform 0.5s';
        msg.style.opacity = '0';
        msg.style.transform = 'translateY(-10px)';
        setTimeout(() => msg.remove(), 500);
    });
}, 5000);

// Add fade-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>
@endsection