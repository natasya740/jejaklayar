@extends('layouts.app')

@section('title', 'Panduan Kontributor')

@push('styles')
<style>
    .panduan-container {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .panduan-header {
        text-align: center;
        margin-bottom: 3rem;
        background: linear-gradient(135deg, #fcd34d 0%, #f4b400 100%);
        padding: 3rem 2rem;
        border-radius: 16px;
        color: #1f2937;
    }

    .panduan-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .panduan-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .guideline-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .guideline-section:hover {
        box-shadow: 0 4px 15px rgba(244,180,0,0.12);
        border-color: #fcd34d;
    }

    .guideline-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #fcd34d;
    }

    .guideline-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #fcd34d, #f4b400);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .guideline-header h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .guideline-list {
        list-style: none;
        padding: 0;
    }

    .guideline-list li {
        padding: 0.75rem 0;
        padding-left: 2rem;
        position: relative;
        color: #4b5563;
        line-height: 1.7;
    }

    .guideline-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #f4b400;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .tips-box {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-left: 4px solid #f4b400;
        border-radius: 8px;
        padding: 2rem;
        margin-top: 2rem;
    }

    .tips-box h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tips-list {
        list-style: none;
        padding: 0;
    }

    .tips-list li {
        padding: 0.5rem 0;
        padding-left: 2rem;
        position: relative;
        color: #374151;
    }

    .tips-list li::before {
        content: '💡';
        position: absolute;
        left: 0;
        font-size: 1.2rem;
    }

    .action-box {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-top: 3rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .action-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .action-btn {
        background: linear-gradient(135deg, #fcd34d, #f4b400);
        color: #1f2937;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(244,180,0,0.3);
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(244,180,0,0.4);
    }

    .action-btn.secondary {
        background: white;
        border: 2px solid #f4b400;
        color: #1f2937;
    }

    @media (max-width: 768px) {
        .panduan-header h1 {
            font-size: 2rem;
        }
        
        .panduan-container {
            padding: 0 1rem;
            margin: 2rem auto;
        }
        
        .guideline-section {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="panduan-container">
    <div class="panduan-header">
        <h1><i class="fas fa-book-open"></i> Panduan Kontributor</h1>
        <p>Ikuti panduan ini untuk membuat konten berkualitas di Jejak Layar</p>
    </div>

    @foreach($guidelines as $guideline)
    <div class="guideline-section">
        <div class="guideline-header">
            <div class="guideline-icon">
                <i class="fas {{ $guideline['icon'] }}"></i>
            </div>
            <h3>{{ $guideline['title'] }}</h3>
        </div>
        <ul class="guideline-list">
            @foreach($guideline['items'] as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endforeach

    <div class="tips-box">
        <h3><i class="fas fa-lightbulb"></i> Tips Tambahan</h3>
        <ul class="tips-list">
            @foreach($tips as $tip)
            <li>{{ $tip }}</li>
            @endforeach
        </ul>
    </div>

    <div class="action-box">
        <h3>Siap Untuk Berkontribusi?</h3>
        <p style="color: #6b7280; margin-bottom: 1rem;">
            Mulai berbagi pengetahuan dan lestarikan budaya Melayu Bengkalis bersama kami
        </p>
        <div class="action-buttons">
            @auth
                @if(Auth::user()->role === 'kontributor')
                    <a href="{{ route('kontributor.artikel.create') }}" class="action-btn">
                        <i class="fas fa-plus-circle"></i> Buat Artikel Baru
                    </a>
                    <a href="{{ route('kontributor.dashboard') }}" class="action-btn secondary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('home') }}" class="action-btn">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="action-btn">
                    <i class="fas fa-user-plus"></i> Daftar Sebagai Kontributor
                </a>
                <a href="{{ route('login') }}" class="action-btn secondary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endauth
            
            <a href="{{ route('faq') }}" class="action-btn secondary">
                <i class="fas fa-question-circle"></i> Lihat FAQ
            </a>
        </div>
    </div>
</div>
@endsection