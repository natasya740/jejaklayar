@extends('layouts.dashboard_kontributor')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi profil Anda')

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

    <!-- Info Message -->
    @if(session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa fa-info-circle"></i>
            <span>{{ session('info') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Profile Header Card -->
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-8 mb-6">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Profile Photo -->
            <div class="relative">
                <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                    @if($user->avatar)
                        <img src="{{ asset('storage/profile/' . $user->avatar) }}" 
                             alt="Profile Photo" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white text-5xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="absolute bottom-0 right-0 bg-white text-yellow-600 rounded-full p-3 shadow-lg">
                    <i class="fa fa-user"></i>
                </div>
            </div>

            <!-- User Info -->
            <div class="text-center md:text-left text-white flex-1">
                <h2 class="text-3xl font-bold mb-2">{{ $user->name }}</h2>
                <p class="text-yellow-100 mb-1">
                    <i class="fa fa-envelope mr-2"></i>{{ $user->email }}
                </p>
                <p class="text-yellow-100 mb-3">
                    <i class="fa fa-calendar mr-2"></i>Bergabung {{ $user->created_at->format('d M Y') }}
                </p>
                <div class="mt-4">
                    <span class="inline-block px-4 py-1 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                        <i class="fa fa-shield-alt mr-1"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa fa-id-card text-gray-600"></i>
                Informasi Profil
            </h3>
            <a href="{{ route('kontributor.profil.edit') }}" 
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all font-semibold flex items-center gap-2 text-sm">
                <i class="fa fa-edit"></i>
                Edit Profil
            </a>
        </div>

        <div class="p-6 space-y-4">
            <!-- Nama -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-user text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
            </div>

            <!-- Email -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-envelope text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="text-gray-900 font-semibold">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Role -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-shield-alt text-purple-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Role</p>
                    <p class="text-gray-900 font-semibold">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <!-- Tanggal Bergabung -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-calendar text-yellow-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Tanggal Bergabung</p>
                    <p class="text-gray-900 font-semibold">{{ $user->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('kontributor.profil.edit') }}" 
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-200 transition-all">
                    <i class="fa fa-edit text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Edit Profil</h4>
                    <p class="text-sm text-gray-500">Ubah informasi profil Anda</p>
                </div>
            </div>
        </a>

        <a href="{{ route('kontributor.dashboard') }}" 
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-all">
                    <i class="fa fa-tachometer-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Dashboard</h4>
                    <p class="text-sm text-gray-500">Kembali ke dashboard</p>
                </div>
            </div>
        </a>
    </div>
</div>

<script>
// Auto hide messages after 5 seconds
setTimeout(() => {
    const messages = document.querySelectorAll('.bg-green-100, .bg-blue-100, .bg-red-100');
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