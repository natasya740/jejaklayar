@extends('layouts.app')
@section('title', 'Beranda | Jejak Layar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Smooth Page Load Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
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
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
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

        /* Hero Enhancement */
        .hero-inner {
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-title {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .hero-sub {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .hero-ctas {
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .hero-quick {
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }

        .hero-quick a {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .hero-quick a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s ease;
        }

        .hero-quick a:hover::before {
            left: 100%;
        }

        .hero-quick a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Button Enhancement */
        .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        /* Features Enhancement */
        .features {
            animation: fadeIn 1s ease-out;
        }

        .card {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
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

        .card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .card:hover::after {
            right: -200%;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            display: inline-block;
            transition: all 0.4s ease;
            font-size: 3rem;
        }

        .card:hover .card-icon {
            transform: scale(1.2) rotate(5deg);
            animation: pulse 1s ease-in-out infinite;
        }

        .card-cta {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .card-cta::after {
            content: '→';
            position: absolute;
            right: -20px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .card:hover .card-cta::after {
            right: -25px;
            opacity: 1;
        }

        .card:hover .card-cta {
            padding-right: 25px;
        }

        /* Section Title Animation */
        .section-title-reveal {
            overflow: hidden;
        }

        .scroll-reveal-title {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-reveal-title.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title::after {
            content: '';
            display: block;
            width: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #00d4ff);
            margin: 15px auto 0;
            transition: width 0.8s ease;
        }

        .section-title.revealed::after {
            width: 100px;
        }

        /* Promo Enhancement */
        .promo {
            position: relative;
            overflow: hidden;
        }

        .promo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle,
                    rgba(255, 255, 255, 0.1) 0%,
                    transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .promo h2 {
            animation: fadeInUp 0.8s ease-out;
        }

        .promo p {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        /* Parallax Effect for Hero */
        .hero {
            position: relative;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
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

        /* Loading Indicator */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #00d4ff);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
            z-index: 9999;
        }

        .page-loader.loading {
            transform: scaleX(1);
        }

        /* Smooth Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Hover Effect for Quick Links */
        .hero-quick a {
            transition: all 0.3s ease;
            display: inline-block;
        }

        .hero-quick a:nth-child(1) {
            animation: slideInLeft 0.6s ease-out 1s both;
        }

        .hero-quick a:nth-child(2) {
            animation: fadeInUp 0.6s ease-out 1.1s both;
        }

        .hero-quick a:nth-child(3) {
            animation: slideInRight 0.6s ease-out 1.2s both;
        }

        /* Gradient Text Animation */
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

        .accent {
            background: linear-gradient(135deg, #ffd000 0%, #d5ab00 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 3s ease infinite;
            font-weight: 800;
            filter: drop-shadow(2px 2px 4px rgba(213, 171, 0, 0.5))
                    drop-shadow(0 0 10px rgba(255, 208, 0, 0.3));
            position: relative;
        }


        /* Features Grid Animation */
        .features-grid {
            perspective: 1000px;
        }

        /* Responsive Enhancements */
        @media (max-width: 768px) {
            .card:hover {
                transform: translateY(-5px) scale(1.01);
            }

            .hero-title {
                font-size: 2rem;
            }
        }

        /* Add Shine Effect on Hover */
        @keyframes shine {
            from {
                left: -100%;
            }

            to {
                left: 100%;
            }
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: left 0.5s;
            z-index: 1;
        }

        .card:hover::before {
            animation: shine 0.7s;
        }

        /* Ensure content stays above shine effect */
        .card>* {
            position: relative;
            z-index: 2;
        }
    </style>
@endpush

@section('content')
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader"></div>

    <section id="beranda" class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">Jelajahi <span class="accent">Budaya & Sejarah</span> Melayu Bengkalis</h1>
            <p class="hero-sub" id="typing-text" aria-live="polite"></p>
            <div class="hero-ctas">
                <a href="{{ route('budaya') }}" class="btn primary">Jelajahi Budaya</a>
                <a href="{{ route('pustaka') }}" class="btn secondary">Masuk Pustaka</a>
            </div>
            <div class="hero-quick">
                <a href="{{ route('pustaka') }}">📚 Sejarah</a>
                <a href="{{ route('pustaka') }}">📖 Cerita Rakyat</a>
                <a href="{{ route('pustaka') }}">📷 Foto Arsip</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-title-reveal">
            <h2 class="section-title scroll-reveal-title" data-scroll-reveal>Jelajahi Koleksi</h2>
        </div>
        <div class="features-grid">
            <article class="card">
                <div class="card-icon">🎭</div>
                <h3>Budaya</h3>
                <p>Musik, tarian, pakaian adat, dan tradisi hidup yang memperkaya identitas Melayu.</p>
                <a href="{{ route('budaya') }}" class="card-cta">Lihat Budaya</a>
            </article>
            <article class="card">
                <div class="card-icon">📚</div>
                <h3>Pustaka Digital</h3>
                <p>Koleksi naskah, artikel, dan dokumen yang bisa dibaca dan diunduh untuk belajar mendalam.</p>
                <a href="{{ route('pustaka') }}" class="card-cta">Masuk Pustaka</a>
            </article>
            <article class="card">
                <div class="card-icon">📖</div>
                <h3>Cerita Interaktif</h3>
                <p>Cerita rakyat, kuis singkat, dan media ringan yang bikin belajar jadi menyenangkan.</p>
                <a href="{{ route('pustaka') }}" class="card-cta">Baca Cerita</a>
            </article>
        </div>
    </section>

    <section id="promo" class="promo">
        <div class="section-title-reveal">
            <h2 class="scroll-reveal-title" data-scroll-reveal>Kenapa Jejak Layar?</h2>
        </div>
        <p>Kami mengumpulkan sumber Lokal, Arsip Visual, dan Cerita lisan untuk menjadi perpustakaan digital yang mudah
            diakses.</p>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('🚀 DOM Loaded');

            // Page Loader
            const pageLoader = document.getElementById('pageLoader');
            if (pageLoader) {
                pageLoader.classList.add('loading');
                setTimeout(() => {
                    pageLoader.style.transform = 'scaleX(1)';
                    setTimeout(() => {
                        pageLoader.style.opacity = '0';
                    }, 500);
                }, 100);
            }

            // --- 1. Typing effect ---
            const typingEl = document.getElementById('typing-text');
            if (typingEl) {
                const text = "Temukan kisah, tradisi, dan arsip — belajar sejarah jadi asyik.";
                let i = 0;

                function type() {
                    if (i < text.length) {
                        typingEl.textContent += text.charAt(i++);
                        setTimeout(type, 35);
                    }
                }
                setTimeout(type, 300);
            }

            // --- 2. Mobile menu & Header Scroll ---
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

            const header = document.querySelector('.site-header');
            if (header) {
                window.addEventListener('scroll', () => {
                    header.classList.toggle('scrolled', window.scrollY > 60);
                }, {
                    passive: true
                });
            }

            // --- 3. Scroll Reveal Animation ---
            const revealElements = document.querySelectorAll('[data-scroll-reveal]');

            const revealOnScroll = () => {
                revealElements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    const isVisible = rect.top < window.innerHeight * 0.85;

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

            // --- 4. Smooth Scroll for Quick Links ---
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

            // --- 5. Parallax Effect for Hero ---
            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        const scrolled = window.pageYOffset;
                        const hero = document.querySelector('.hero');
                        if (hero) {
                            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                        }
                        ticking = false;
                    });
                    ticking = true;
                }
            }, {
                passive: true
            });

            // --- 6. Add Hover Sound Effect (Optional) ---
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    // You can add sound effect here if needed
                    console.log('Card hovered');
                });
            });

            // --- 7. Intersection Observer for Cards ---
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

                cards.forEach(card => {
                    cardObserver.observe(card);
                });
            }

            console.log('✅ All animations initialized');
        });

        // Add loading indicator on page navigation
        window.addEventListener('beforeunload', () => {
            const pageLoader = document.getElementById('pageLoader');
            if (pageLoader) {
                pageLoader.style.opacity = '1';
                pageLoader.classList.add('loading');
            }
        });
    </script>
@endpush
