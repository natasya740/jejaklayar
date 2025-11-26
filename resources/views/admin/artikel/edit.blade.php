@extends('layouts.dashboard_admin')

@section('title','Edit Artikel')
@section('page-title','Edit Artikel')

@section('content')
<form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST">
  @csrf @method('PUT')
  <div class="mb-4">
    <label class="block text-sm font-medium">Judul</label>
    <input name="title" value="{{ old('title',$artikel->title) }}" class="mt-1 block w-full rounded border px-3 py-2" />
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium">Isi</label>
    <textarea name="body" rows="12" class="mt-1 block w-full rounded border px-3 py-2">{{ old('body',$artikel->body) }}</textarea>
  </div>

  <div class="flex gap-3">
    <button class="px-4 py-2 rounded bg-indigo-600 text-white">Simpan</button>
    <a href="{{ route('admin.artikel.index') }}" class="px-4 py-2 rounded bg-gray-200">Batal</a>
  </div>
</form>
@endsection
