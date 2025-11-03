<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  {{-- 💡 Ganti admin.css dengan asset Laravel --}}
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="admin-container">

  {{-- 💡 INCLUDE SIDEBAR BLADE --}}
  @include('admin.sidebar')

  <main class="main-content">
    <h1>Dashboard</h1>

    <div class="dashboard-cards">
      {{-- 💡 MENGGUNAKAN DATA DARI CONTROLLER --}}
      <div class="card">📄 <h3 id="total-artikel">{{ $stats['total_artikel'] }}</h3><p>Total Artikel</p></div>
      <div class="card">⏳ <h3 id="total-pending">{{ $stats['total_pending'] }}</h3><p>Pending</p></div>
      <div class="card">✅ <h3 id="total-published">{{ $stats['total_published'] }}</h3><p>Published</p></div>
      <div class="card">👥 <h3 id="total-user">{{ $stats['total_user'] }}</h3><p>Pengguna</p></div>
    </div>

    <h2>📥 Antrian Kontributor</h2>
    <table>
      <thead>
        <tr><th>Judul</th><th>Kategori</th><th>Pengirim</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody id="queue-list">
        {{-- 💡 LOGIKA PHP/FETCH DIGANTI DENGAN LOOP BLADE --}}
        @forelse ($pendingArticles as $artikel)
            <tr>
                <td><a href="{{ route('artikel.show', $artikel->id) }}">{{ $artikel->judul }}</a></td>
                {{-- Asumsi Anda punya relasi Kategori dan Penulis (User) --}}
                <td>{{ $artikel->kategori->nama_kategori ?? 'N/A' }}</td> 
                <td>{{ $artikel->user->nama ?? 'N/A' }}</td>
                <td><span class="badge pending">{{ $artikel->status }}</span></td>
                <td>
                    {{-- 💡 Ganti onclick JS dengan Form Laravel yang Aman --}}
                    <form action="{{ route('admin.update_status', $artikel->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit" class="approve">✔</button>
                    </form>
                    <form action="{{ route('admin.update_status', $artikel->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="reject">✖</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan='5'>Tidak ada artikel pending</td></tr>
        @endforelse
      </tbody>
    </table>
  </main>
</div>

{{-- Logika JS untuk update status harus dipindahkan ke Laravel (AJAX atau Form Request) --}}

</body>
</html>
