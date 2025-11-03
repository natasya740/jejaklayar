<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Halo, {{ $user->nama }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Isi Halaman -->
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h3 class="mb-3">Selamat Datang, {{ $user->nama }}!</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

            <hr>

            <div class="mt-4">
                @if($user->role === 'superadmin')
                    <div class="alert alert-primary">
                        Anda adalah <strong>Superadmin</strong> — memiliki akses penuh ke seluruh sistem.
                    </div>
                @elseif($user->role === 'admin')
                    <div class="alert alert-success">
                        Anda adalah <strong>Admin</strong> — dapat mengelola data pengguna dan konten.
                    </div>
                @else
                    <div class="alert alert-warning">
                        Anda adalah <strong>Kontributor</strong> — dapat menambahkan data baru.
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <a href="#" class="btn btn-primary">📁 Kelola Data</a>
                <a href="#" class="btn btn-outline-secondary">👤 Profil</a>
            </div>
        </div>
    </div>

</body>
</html>
