<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya user terautentikasi dan (opsional) ber-role admin bisa mengakses
        $this->middleware('auth');
        // $this->middleware('can:manage-users'); // aktifkan jika Anda punya ability/gate
    }

    /**
     * Menampilkan daftar user + pencarian.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('name', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * Tampilkan form untuk membuat user baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // batasi role pada daftar yang Anda gunakan; sesuaikan bila perlu
            'role'     => ['nullable', 'string', Rule::in(['admin', 'kontributor', 'member'])],
            'is_active'=> ['nullable', 'in:0,1'],
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'] ?? null,
            // checkbox handling: gunakan Request::has untuk kasus checkbox
            'is_active' => $request->has('is_active') ? (bool) $data['is_active'] : true,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Redirect ke edit (karena halaman show tidak dipakai).
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data user (nama, email, role, is_active, password optional).
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['nullable', 'string', Rule::in(['admin', 'kontributor', 'member'])],
            'is_active' => ['nullable', 'in:0,1'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->role  = $data['role'] ?? $user->role;

        // checkbox: hanya ubah jika ada pada request
        if ($request->has('is_active')) {
            $user->is_active = (bool) $data['is_active'];
        }

        // update password bila disediakan
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Toggle aktif/nonaktif user.
     * - TOLAK jika current user mencoba menonaktifkan diri sendiri.
     * - IZINKAN jika current user sedang nonaktif (self-activation).
     */
    public function toggle(User $user)
    {
        $meId = auth()->id();

        // Jika mencoba menonaktifkan diri sendiri -> tolak
        if ($meId === $user->id && $user->is_active) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        // Izinkan toggle dalam semua kasus lain (termasuk self-activation)
        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', $user->is_active ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        // Cegah menghapus akun sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
