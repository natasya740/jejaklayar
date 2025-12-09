@extends('layouts.app')
@section('title', 'Beranda | Jejak Layar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* ===== ANIMATION KEYFRAMES ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===== HERO SECTION ===== */
        /* Hero Enhancement */
        .hero {
            position: relative;
            color: white;
            text-align: center;
            padding: 8rem 1rem;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.281);
            z-index: 0;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .hero-sub {
            font-size: 1.25rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .hero-ctas {
            animation: fadeInUp 0.8s ease-out 0.6s both;
            margin-top: 2rem;
        }

        .hero-quick {
            animation: fadeInUp 0.8s ease-out 0.8s both;
            margin-top: 2rem;
        }

        .accent {
            background: linear-gradient(135deg, #ffd000 0%, #d5ab00 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 3s ease infinite;
            font-weight: 800;
            filter: drop-shadow(2px 2px 4px rgba(213, 171, 0, 0.5)) drop-shadow(0 0 10px rgba(255, 208, 0, 0.3));
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .hero-title .accent {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }


        /* ===== BUTTON STYLES ===== */
        .btn {
            position: relative;
            overflow: hidden;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .btn.primary {
            background: linear-gradient(135deg, #8B5E3C 0%, #6d4428 100%);
            color: #fff;
        }

        .btn.secondary {
            background: linear-gradient(135deg, #ffd000 0%, #d5ab00 100%);
            color: #222;
        }

        .hero-quick a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-quick a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* ===== ABOUT SECTION ===== */
        .about-section {
            padding: 6rem 2rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 247, 230, 0.95));
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, #ffd000, transparent);
        }

        .about-content {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text {
            animation: slideInLeft 1s ease-out;
        }

        .about-text h2 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            color: #8B5E3C;
            margin-bottom: 1.5rem;
            font-weight: 800;
            position: relative;
            display: inline-block;
        }

        .about-text h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ffd000, #d5ab00);
            border-radius: 2px;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 1.5rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .about-feature-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .about-feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .about-feature-icon {
            font-size: 2rem;
            min-width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff7e6, #ffe8b3);
            border-radius: 10px;
        }

        .about-feature-text h4 {
            color: #8B5E3C;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .about-feature-text p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        .about-visual {
            position: relative;
            animation: slideInRight 1s ease-out;
        }

        .about-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .about-image-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 208, 0, 0.2), rgba(139, 94, 60, 0.2));
            z-index: 1;
        }

        .about-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .about-image-wrapper:hover .about-image {
            transform: scale(1.05);
        }

        .about-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 208, 0, 0.15), transparent);
            border-radius: 50%;
            z-index: -1;
        }

        .about-decoration:nth-child(1) {
            top: -50px;
            right: -50px;
            animation: float 6s ease-in-out infinite;
        }

        .about-decoration:nth-child(2) {
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        /* ===== FEATURES SECTION ===== */
        .features {
            padding: 5rem 2rem;
            background: linear-gradient(180deg, rgba(255, 247, 230, 0.95), rgba(255, 255, 255, 0.98));
            animation: fadeIn 1s ease-out;
        }

        .section-title-wrapper {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.5rem);
            color: #8B5E3C;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffd000, #d5ab00);
            transition: width 0.8s ease;
        }

        .section-title.revealed::after {
            width: 120px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            perspective: 1000px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
            cursor: pointer;
        }

        .card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .card:hover::before {
            left: 100%;
        }

        .card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            transition: all 0.4s ease;
        }

        .card:hover .card-icon {
            transform: scale(1.2) rotate(10deg);
            animation: pulse 1s ease-in-out infinite;
        }

        .card h3 {
            color: #222;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .card p {
            color: #555;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .card-cta {
            color: #8B5E3C;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .card-cta::after {
            content: '→';
            transition: transform 0.3s ease;
        }

        .card:hover .card-cta {
            gap: 1rem;
        }

        .card:hover .card-cta::after {
            transform: translateX(5px);
        }

        /* ===== CONTRIBUTOR CTA SECTION ===== */
        .contributor-cta {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #8B5E3C 0%, #6d4428 100%);
            position: relative;
            overflow: hidden;
        }

        .contributor-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .contributor-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .contributor-icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        .contributor-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            color: #fff;
            margin-bottom: 1.5rem;
            font-weight: 800;
        }

        .contributor-content h2 .highlight {
            background: linear-gradient(135deg, #ffd000, #ffe066);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .contributor-content p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            line-height: 1.8;
        }

        .contributor-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-contributor {
            padding: 16px 36px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-contributor.primary {
            background: linear-gradient(135deg, #ffd000, #d5ab00);
            color: #222;
        }

        .btn-contributor.secondary {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-contributor:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-contributor.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero {
                padding: 6rem 1.5rem 4rem;
                min-height: 60vh;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .about-visual {
                order: -1;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .about-image {
                height: 350px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .contributor-buttons {
                flex-direction: column;
            }

            .btn-contributor {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .hero {
                padding: 5rem 1rem 3rem;
            }

            .about-section {
                padding: 4rem 1rem;
            }

            .features {
                padding: 3rem 1rem;
            }

            .contributor-cta {
                padding: 3rem 1rem;
            }
        }

        /* ===== SCROLL REVEAL ===== */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">
                Jelajahi <span class="accent">Budaya & Sejarah</span> Melayu Bengkalis
            </h1>
            <p class="hero-sub" id="typing-text" aria-live="polite"></p>

            <div class="hero-ctas">
                <a href="{{ route('category.show', 'budaya') }}" class="btn primary">
                    <span>🎭 Jelajahi Budaya</span>
                </a>
                <a href="{{ route('category.show', 'pustaka') }}" class="btn secondary">
                    <span>📚 Masuk Pustaka</span>
                </a>
            </div>

            <div class="hero-quick">
                <a href="{{ route('category.show', 'pustaka') }}">
                    📚 Sejarah
                </a>
                <a href="{{ route('category.show', 'pustaka') }}">
                    📖 Cerita Rakyat
                </a>
                <a href="{{ route('category.show', 'pustaka') }}">
                    📷 Foto Arsip
                </a>
            </div>
        </div>
    </section>

    <!-- About Jejak Layar Section -->
    <section class="about-section scroll-reveal">
        <div class="about-content">
            <div class="about-text">
                <h2>Apa itu Jejak Layar?</h2>
                <p>
                    <strong>Jejak Layar</strong> adalah perpustakaan digital yang didedikasikan untuk melestarikan,
                    mendokumentasikan, dan membagikan kekayaan budaya serta sejarah Melayu Bengkalis kepada generasi
                    masa kini dan mendatang.
                </p>
                <p>
                    Kami mengumpulkan berbagai sumber lokal, arsip visual, cerita lisan, dan dokumen berharga dalam
                    satu platform yang mudah diakses oleh siapa saja, di mana saja. Misi kami adalah menjaga agar
                    warisan budaya tidak hilang termakan zaman.
                </p>

                <div class="about-features">
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🗂️</div>
                        <div class="about-feature-text">
                            <h4>Koleksi Lengkap</h4>
                            <p>Naskah, foto, video, dan audio dari berbagai sumber</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🔍</div>
                        <div class="about-feature-text">
                            <h4>Mudah Diakses</h4>
                            <p>Cari dan temukan konten dengan cepat dan mudah</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🤝</div>
                        <div class="about-feature-text">
                            <h4>Kolaboratif</h4>
                            <p>Kontribusi dari komunitas untuk komunitas</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🌐</div>
                        <div class="about-feature-text">
                            <h4>Gratis & Terbuka</h4>
                            <p>Akses penuh tanpa biaya untuk semua orang</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-visual">
                <div class="about-decoration"></div>
                <div class="about-decoration"></div>
                <div class="about-image-wrapper">
                    <img src="{{ asset('images/Background.png') }}" alt="Budaya Melayu" class="about-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features scroll-reveal">
        <div class="section-title-wrapper">
            <h2 class="section-title" data-scroll-reveal>Jelajahi Koleksi</h2>
            <p class="section-subtitle">
                Temukan berbagai konten menarik yang kami kurasi khusus untuk Anda
            </p>
        </div>

        <div class="features-grid">
            <a href="{{ route('category.show', 'budaya') }}" class="card card-link">
                <div class="card-icon">🎭</div>
                <h3>Budaya</h3>
                <p>
                    Musik, tarian, pakaian adat, dan tradisi hidup yang memperkaya identitas
                    Melayu Bengkalis.
                </p>
                <span class="card-cta">Lihat Budaya</span>
            </a>

            <a href="{{ route('category.show', 'pustaka') }}" class="card card-link">
                <div class="card-icon">📚</div>
                <h3>Pustaka Digital</h3>
                <p>
                    Koleksi naskah, artikel, dan dokumen yang bisa dibaca dan diunduh untuk
                    belajar mendalam.
                </p>
                <span class="card-cta">Masuk Pustaka</span>
            </a>

            <a href="{{ route('category.show', 'pustaka') }}" class="card card-link">
                <div class="card-icon">📖</div>
                <h3>Cerita Interaktif</h3>
                <p>
                    Cerita rakyat, kuis singkat, dan media ringan yang bikin belajar jadi
                    menyenangkan.
                </p>
                <span class="card-cta">Baca Cerita</span>
            </a>
        </div>
    </section>


    <!-- Contributor CTA Section -->
    <section class="contributor-cta scroll-reveal">
        <div class="contributor-content">
            <div class="contributor-icon">🤝</div>
            <h2>
                Bergabunglah Menjadi <span class="highlight">Kontributor</span>
            </h2>
            <p>
                Punya cerita, foto, atau dokumen tentang budaya Melayu Bengkalis?
                Mari bersama-sama melestarikan warisan budaya kita! Setiap kontribusi Anda
                sangat berarti untuk generasi mendatang.
            </p>

            <div class="contributor-buttons">
                <a href="{{ route('register') }}" class="btn-contributor primary">
                    <span>✨</span>
                    <span>Daftar Sebagai Kontributor</span>
                </a>
                <a href="#" class="btn-contributor secondary">
                    <span>💬</span>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                console.log('🚀 Jejak Layar Initialized');

                // ===== TYPING EFFECT =====
                const typingEl = document.getElementById('typing-text');
                if (typingEl) {
                    const text = "Temukan kisah, tradisi, dan arsip — belajar sejarah jadi asyik.";
                    let i = 0;

                    function type() {
                        if (i < text.length) {
                            typingEl.textContent += text.charAt(i++);
                            setTimeout(type, 40);
                        }
                    }
                    setTimeout(type, 500);
                }

                // ===== MOBILE MENU =====
                const menuToggle = document.getElementById('menu-toggle');
                const mobileMenu = document.getElementById('mobile-menu');

                if (menuToggle && mobileMenu) {
                    menuToggle.addEventListener('click', (e) => {
                        e.stopPropagation();
                        mobileMenu.classList.toggle('open');
                        menuToggle.classList.toggle('open');
                    });

                    document.addEventListener('click', (e) => {
                        if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                            mobileMenu.classList.remove('open');
                            menuToggle.classList.remove('open');
                        }
                    });
                }

                // ===== HEADER SCROLL =====
                const header = document.querySelector('.site-header');
                if (header) {
                    window.addEventListener('scroll', () => {
                        header.classList.toggle('scrolled', window.scrollY > 60);
                    }, {
                        passive: true
                    });
                }

                // ===== SCROLL REVEAL ANIMATION =====
                const revealElements = document.querySelectorAll('.scroll-reveal, [data-scroll-reveal]');

                const revealOnScroll = () => {
                    revealElements.forEach(el => {
                        const rect = el.getBoundingClientRect();
                        const isVisible = rect.top < window.innerHeight * 0.8;

                        if (isVisible && !el.classList.contains('revealed')) {
                            el.classList.add('revealed');
                        }
                    });
                };

                // Initial check
                setTimeout(revealOnScroll, 100);

                // Check on scroll
                window.addEventListener('scroll', revealOnScroll, {
                    passive: true
                });

                // ===== SMOOTH SCROLL =====
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if (href !== '#' && href !== '#!') {
                            e.preventDefault();
                            const target = document.querySelector(href);
                            if (target) {
                                target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }
                    });
                });

                // ===== COUNTER ANIMATION =====
                const counters = document.querySelectorAll('.stat-number');
                const animateCounter = (counter) => {
                    const target = parseInt(counter.getAttribute('data-count'));
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            counter.textContent = Math.floor(current) + '+';
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target + '+';
                        }
                    };

                    updateCounter();
                };

                const counterObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && entry.target.textContent === '0') {
                            animateCounter(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                counters.forEach(counter => counterObserver.observe(counter));

                // ===== CARD HOVER SOUND EFFECT (Optional) =====
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        console.log('Card hovered:', card.querySelector('h3').textContent);
                    });
                });

                // ===== INTERSECTION OBSERVER FOR CARDS =====
                if ('IntersectionObserver' in window) {
                    const cardObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });

                    cards.forEach(card => cardObserver.observe(card));
                }

                console.log('✅ All animations initialized');
            });

            // ===== PAGE TRANSITION =====
            window.addEventListener('beforeunload', () => {
                document.body.style.opacity = '0.8';
            });
        </script>
    @endpush
