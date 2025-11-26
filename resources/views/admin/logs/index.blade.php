@extends('layouts.dashboard_admin')

@section('title','Log Aktivitas')
@section('page-title','Log Aktivitas')

@section('content')
<div class="bg-white rounded-lg shadow p-4">
  <h3 class="font-semibold mb-3">Isi laravel.log (baris terakhir)</h3>
  <pre class="text-xs whitespace-pre-wrap">{{ implode("\n", $lines ?? []) }}</pre>
</div>
@endsection
