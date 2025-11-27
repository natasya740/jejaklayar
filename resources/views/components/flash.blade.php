@if(session('success'))
    <div class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40" id="backdrop"></div>
    
    <div class="fixed inset-0 flex items-center justify-center z-50" id="flashMessage">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-popIn">
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
                    <div class="relative bg-green-500 rounded-full p-3">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-800 text-center mb-2">Berhasil!</h3>
            <p class="text-gray-600 text-center">{{ session('success') }}</p>
        </div>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('flashMessage').style.display = 'none';
            document.getElementById('backdrop').style.display = 'none';
        }, 3000);
    </script>
@endif