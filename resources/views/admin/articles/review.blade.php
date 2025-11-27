@extends('layouts.dashboard_admin')

@section('title','Review Artikel')
@section('page-title','Review Artikel')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.artikel.pending') }}" class="text-sm text-indigo-600">&larr; Kembali ke Antrian</a>
</div>

<div class="bg-white rounded-lg p-6 shadow-sm">
  <h2 class="text-xl font-bold mb-2">{{ $artikel->title }}</h2>
  <div class="text-sm text-gray-500 mb-4">oleh {{ $artikel->user->name ?? '—' }} • {{ $artikel->created_at->diffForHumans() }}</div>

  <div class="prose max-w-none">
    {!! $artikel->body !!}
  </div>

  <div class="mt-6 flex gap-3">
    <form action="{{ route('admin.artikel.approve', $artikel->id) }}" method="POST">
      @csrf @method('PATCH')
      <button class="px-4 py-2 rounded bg-green-600 text-white">Approve & Publish</button>
    </form>

    <form action="{{ route('admin.artikel.reject', $artikel->id) }}" method="POST">
      @csrf @method('PATCH')
      <button class="px-4 py-2 rounded bg-rose-600 text-white">Reject</button>
    </form>

    <a href="{{ route('admin.articles.edit', $artikel->id) }}" class="px-4 py-2 rounded bg-yellow-500 text-white">Edit</a>
  </div>
</div>
@endsection
