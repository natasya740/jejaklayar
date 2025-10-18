@extends('layouts.app')

@section('title', 'Budaya | Jejak Layar')

{{-- memanggil budaya.css tambahan --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/budaya.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')

<section class="budaya-section">
  <h1>Budaya Melayu Bengkalis</h1>
  <div class="budaya-grid">
    <div class="budaya-card">
      <img src="{{ asset('images/tari-zapin.jpg') }}" alt="Tari Zapin">
      <h3>Tari Zapin</h3>
      <p>Tarian tradisional Melayu dengan gerakan elegan dan musik gambus.</p>
    </div>

    <div class="budaya-card">
      <img src="{{ asset('images/baju-adat.jpg') }}" alt="Baju Adat Melayu">
      <h3>Baju Adat Melayu</h3>
      <p>Busana khas Melayu dengan warna dan corak yang mencerminkan keanggunan.</p>
    </div>

    <div class="budaya-card">
      <img src="{{ asset('images/alat-musik.jpg') }}" alt="Alat Musik Tradisional">
      <h3>Alat Musik Tradisional</h3>
      <p>Gambus, kompang, dan gendang menjadi identitas seni musik Melayu.</p>
    </div>
  </div>
</section>

@endsection
