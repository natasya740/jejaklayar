<?php

namespace App\Http\Controllers\Kontributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user();
        return view('kontributor.profil.profil', compact('user'));
    }

    /**
     * Tampilkan halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('kontributor.profil.edit', compact('user'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input dengan batasan yang wajar
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // Max 10MB
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan pengguna lain',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Format gambar harus: JPEG, JPG, PNG, GIF, atau WEBP',
            'avatar.max' => 'Ukuran gambar maksimal 10MB',
        ]);

        try {
            // Update nama & email
            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            // Proses upload avatar jika ada
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                // Validasi tambahan untuk keamanan
                if (!$file->isValid()) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', '❌ File upload gagal. Silakan coba lagi.');
                }

                // Hapus foto lama jika ada
                if ($user->avatar && $user->avatar !== 'default-avatar.png') {
                    // ✅ PERBAIKAN: Gunakan disk 'public' dengan benar
                    if (Storage::disk('public')->exists('profile/' . $user->avatar)) {
                        Storage::disk('public')->delete('profile/' . $user->avatar);
                    }
                }

                // Generate nama file yang unik dan aman
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // ✅ PERBAIKAN: Simpan dengan cara yang benar
                // File akan disimpan ke: storage/app/public/profile/
                $file->storeAs('profile', $filename, 'public');

                // Update nama file di database (hanya simpan nama file)
                $user->avatar = $filename;
            }

            // Simpan perubahan
            $user->save();

            return redirect()
                ->route('kontributor.profil')
                ->with('success', '✅ Profil berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error - akan otomatis redirect dengan error messages
            throw $e;
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error updating profile: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'file_size' => $request->hasFile('avatar') ? $request->file('avatar')->getSize() : 'no file',
                'trace' => $e->getTraceAsString()
            ]);

            // Tampilkan error lebih detail (untuk debugging)
            $errorMessage = config('app.debug') 
                ? '❌ Error: ' . $e->getMessage()
                : '❌ Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.';

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    /**
     * Hapus foto profil
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        try {
            if ($user->avatar && $user->avatar !== 'default-avatar.png') {
                // ✅ PERBAIKAN: Gunakan disk 'public' dengan benar
                if (Storage::disk('public')->exists('profile/' . $user->avatar)) {
                    Storage::disk('public')->delete('profile/' . $user->avatar);
                }

                $user->avatar = null;
                $user->save();

                return redirect()
                    ->back()
                    ->with('success', '✅ Foto profil berhasil dihapus!');
            }

            return redirect()
                ->back()
                ->with('info', 'Tidak ada foto profil untuk dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting avatar: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', '❌ Gagal menghapus foto profil.');
        }
    }
}