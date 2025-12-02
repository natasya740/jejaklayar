<?php

namespace App\Http\Controllers\Kontributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('kontributor.profil');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Update nama & email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika upload foto baru
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time().'-'.$file->getClientOriginalName();
            $file->storeAs('public/profile', $filename);

            // Simpan ke database
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
