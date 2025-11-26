<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Layar')</title>

    <!-- Tailwind CSS (Vite) -->
    @vite('resources/css/app.css')

    <!-- Custom CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- BASE / LAYOUT --- */
        html, body {
            height: 100%;
            margin: 0;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf2;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        main { 
            flex: 1; 
            width: 100%;
            position: relative;
            z-index: 1;
            padding-top: 80px; /* offset header */
        }

        /* --- SPLASH --- */
        #logo-splash {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #ffd000 0%, #fef3c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.8s ease-in-out;
        }
        #logo-splash.fade-out { opacity: 0; pointer-events: none; }

        .splash-logo-container { animation: logoEntrance 1.8s cubic-bezier(0.25,0.46,0.45,0.94); position: relative; }
        .splash-logo { max-width: 280px; height: auto; filter: drop-shadow(0 8px 20px rgba(0,0,0,0.08)); }

        @keyframes logoEntrance {
            0% { transform: scale(0.85) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        /* subtle glow */
        .splash-logo-container::before {
            content: ''; position: absolute; top: -10%; left: -10%; width: 120%; height: 120%;
            background: radial-gradient(circle, rgba(252,211,77,0.15) 0%, transparent 70%);
            animation: subtleGlow 3s ease-in-out infinite;
        }
        @keyframes subtleGlow {
            0%,100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        /* --- HEADER --- */
        .site-header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            inset-inline: 0;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .logo-link { position: relative; display: inline-block; }
        .logo { height: 45px; width: auto; transition: transform 0.25s ease; }
        .logo-link:hover .logo { transform: scale(1.05); }

        .logo-spark-container { position: relative; display: inline-block; }
        #logo-spark-canvas { position: absolute; inset: 0; pointer-events: none; z-index: 10; }

        /* search */
        .search-bar { display: flex; align-items: center; }
        .search-bar input {
            background: #f3f4f6; border: none; padding: 10px 20px; border-radius: 50px; width: 300px; outline: none;
            transition: box-shadow .3s;
        }
        .search-bar input:focus { box-shadow: 0 0 0 3px rgba(244,180,0,0.15); background: #fff; }

        /* nav */
        .main-nav { display:flex; align-items:center; gap: 20px; }
        .nav-link { text-decoration:none; color:#374151; font-weight:500; font-size:0.95rem; position:relative; padding:5px 0; }
        .nav-link:hover, .nav-link.active { color:#d97706; }

        /* user menu */
        .user-menu { position: relative; display:flex; align-items:center; }
        .user-toggle { display:flex; align-items:center; gap:10px; cursor:pointer; color:#333; font-weight:600; padding:6px 12px; border-radius:30px; transition:background .2s; }
        .user-toggle:hover { background: #f3f4f6; }
        .profile-img { width:35px; height:35px; border-radius:50%; object-fit:cover; border:2px solid #f4b400; }

        .user-menu-dropdown {
            position: absolute; top: 55px; right: 0; background: #fff; min-width: 220px; border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08); padding: 8px 0; display: none; z-index: 1000; border: 1px solid #eee;
        }
        .user-menu-dropdown a, .user-menu-dropdown button {
            display:flex; align-items:center; gap:12px; padding:12px 20px; text-decoration:none; color:#4b5563; width:100%; text-align:left;
            background:none; border:none; cursor:pointer; font-size:0.9rem; font-weight:500;
        }
        .user-menu-dropdown a:hover, .user-menu-dropdown button:hover { background: #fffaf2; color:#d97706; padding-left:25px; }

        .logout-btn { color:#ef4444; border-top:1px solid #f3f4f6; margin-top:5px; padding-top:12px; width:100%; text-align:left; background:none; border:none; cursor:pointer; }

        /* --- FOOTER --- */
        footer.site-footer {
            background-color: #fcd34d; color: #1f2937; padding-top: 4rem; margin-top: auto; font-size: 0.95rem; position: relative; z-index: 2;
        }
        .footer-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; max-width:1200px; margin:0 auto; padding:0 2rem 2rem; }
        .footer-col h3 { font-weight:800; font-size:1.1rem; margin-bottom:1.5rem; color:#111827; text-transform:uppercase; letter-spacing:1px; }
        .footer-col a { text-decoration:none; color:#374151; transition: all .3s; display:inline-flex; align-items:center; gap:8px; font-weight:500; }
        .footer-col a:hover { color:#000; transform: translateX(5px); }

        .socials { display:flex; gap:12px; margin-top:20px; }
        .socials a { width:38px; height:38px; background:#fff; display:flex; align-items:center; justify-content:center; border-radius:50%; transition:all .3s; color:#1f2937; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .socials a:hover { background:#1f2937; color:#fcd34d; transform: translateY(-3px); }

        .footer-bottom { text-align:center; padding:2rem 0; background:transparent; font-size:0.85rem; color:#4b5563; border-top:1px solid rgba(0,0,0,0.05); margin-top:1rem; }

        /* buttons */
        .btn-primary {
            background-color:#f4b400; color:white; padding:0.6rem 1.5rem; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; border:2px solid transparent;
            transition: all .3s;
        }
        .btn-primary:hover { background-color:#d97706; transform: translateY(-2px); box-shadow:0 4px 12px rgba(244,180,0,0.2); }

        /* floating help */
        .floating-help-container { position: fixed; bottom:30px; right:30px; z-index:99; display:flex; flex-direction:column; align-items:flex-end; }
        .help-trigger-btn { background:#1e293b; color:#fcd34d; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; box-shadow:0 4px 15px rgba(0,0,0,0.2); cursor:pointer; transition:all .3s; border:2px solid #fcd34d; }
        .help-trigger-btn.active { transform: rotate(45deg); background:#fcd34d; color:#1e293b; border-color:#1e293b; }
        .help-options { position:absolute; bottom:75px; right:0; display:flex; flex-direction:column; gap:12px; opacity:0; visibility:hidden; transform: translateY(20px); transition:all .3s ease; }
        .help-trigger-btn.active ~ .help-options { opacity:1; visibility:visible; transform: translateY(0); }
        .help-item { display:flex; align-items:center; gap:12px; background:white; padding:10px 20px; border-radius:50px; box-shadow:0 4px 15px rgba(0,0,0,0.08); text-decoration:none; color:#333; font-weight:600; font-size:0.9rem; white-space:nowrap; transition:all .2s; }
        .help-item:hover { transform: translateX(-5px); color:#d97706; box-shadow:0 6px 20px rgba(0,0,0,0.12); }
        .help-item i { width:25px; height:25px; display:flex; align-items:center; justify-content:center; background:#f3f4f6; border-radius:50%; font-size:0.8rem; color:#d97706; }

        /* responsive */
        @media (max-width: 1024px) {
            .site-header { padding: 0.8rem 1.5rem; }
            .search-bar input { width: 200px; }
            .main-nav { gap: 15px; }
        }
        @media (max-width: 768px) {
            main { padding-top: 70px; }
            .logo { height: 38px; }
            .search-bar input { width: 160px; padding:8px 15px; }
            .main-nav { width:100%; justify-content:space-around; gap:10px; padding-top:10px; border-top:1px solid #f3f4f6; flex-wrap:wrap; }
            .footer-container { grid-template-columns: 1fr; gap:2rem; padding:0 1.5rem 1.5rem; }
            .floating-help-container { bottom:20px; right:20px; }
            .help-trigger-btn { width:50px; height:50px; font-size:20px; }
        }
        @media (max-width: 480px) {
            .site-header { padding: 0.5rem 0.8rem; }
            .logo { height: 32px; }
            .search-bar input { width: 120px; padding:6px 12px; font-size:0.8rem; }
            .profile-img { width:30px; height:30px; }
        }

        /* utility */
        .prevent-shift { overflow-anchor: none; }
    </style>

    @stack('styles')
</head>

<body>
    {{-- SPLASH --}}
    <div id="logo-splash">
        <div class="splash-logo-container">
            <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="Jejak Layar" class="splash-logo">
        </div>
    </div>

    {{-- HEADER --}}
    <header class="site-header">
        <div class="header-left">
            <div class="logo-spark-container">
                <canvas id="logo-spark-canvas"></canvas>
                <a href="{{ route('home') }}" class="logo-link" id="logo-clickable">
                    <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" class="logo">
                </a>
            </div>
        </div>

        <div class="header-center">
            <form class="search-bar" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="q" placeholder="Cari: judul, tokoh, kata kunci..." value="{{ request('q') }}">
            </form>
        </div>

        <nav class="header-right main-nav">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('budaya') }}" class="nav-link {{ request()->routeIs('budaya') ? 'active' : '' }}">Budaya</a>
            <a href="{{ route('pustaka') }}" class="nav-link {{ request()->routeIs('pustaka') ? 'active' : '' }}">Pustaka</a>
            <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>

            @guest
                <a href="{{ route('login') }}" class="btn-primary">Login</a>
            @endguest

            @auth
                <div class="user-menu">
                    <div class="user-toggle" id="user-menu-toggle">
                        <img src="{{ asset('FOTO/avatar.png') }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random'"
                             alt="Profil" class="profile-img">
                        <span>{{ explode(' ', Auth::user()->name)[0] }} ▼</span>
                    </div>

                    <div class="user-menu-dropdown" id="user-menu-dropdown" aria-hidden="true">
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</a>
                        @elseif (Auth::user()->role === 'kontributor')
                            <a href="{{ route('kontributor.dashboard') }}"><i class="fas fa-pencil-alt"></i> Dashboard Kontributor</a>
                        @endif

                        @if (Route::has('kontributor.profil'))
                            <a href="{{ route('kontributor.profil') }}"><i class="fas fa-user-circle"></i> Profil Saya</a>
                        @elseif(Route::has('kontributor.profile'))
                            <a href="{{ route('kontributor.profile') }}"><i class="fas fa-user-circle"></i> Profil Saya</a>
                        @else
                            <div style="padding:12px 20px;color:#6b7280;"><i class="fas fa-user-circle"></i> Profil Saya</div>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            @endauth
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="prevent-shift">
        @yield('content')
    </main>

    {{-- FLOATING HELP --}}
    <div class="floating-help-container">
        <div class="help-trigger-btn" id="help-btn" aria-label="Bantuan">
            <i class="fas fa-question"></i>
        </div>

        <div class="help-options" id="help-options" aria-hidden="true">
            <a href="#" class="help-item"><span>FAQ / Pertanyaan</span><i class="fas fa-book-open"></i></a>
            <a href="mailto:admin@jejaklayar.com" class="help-item"><span>Email Admin</span><i class="fas fa-envelope"></i></a>
            <a href="#" class="help-item"><span>Panduan Kontributor</span><i class="fas fa-user-edit"></i></a>
            <a href="https://wa.me/628123456789" target="_blank" class="help-item"><span>Chat WhatsApp</span><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col brand">
                <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" style="height:50px;margin-bottom:15px;">
                <p>Melayu Bengkalis dalam satu portal digital untuk semua generasi. Kami berdedikasi menjaga warisan budaya dan mendekatkan generasi muda dengan sejarahnya.</p>
            </div>

            <div class="footer-col">
                <h3>JELAJAHI</h3>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right text-xs"></i> Beranda</a></li>
                    <li><a href="{{ route('budaya') }}"><i class="fas fa-chevron-right text-xs"></i> Budaya</a></li>
                    <li><a href="{{ route('pustaka') }}"><i class="fas fa-chevron-right text-xs"></i> Pustaka Digital</a></li>
                    <li><a href="{{ route('tentang') }}"><i class="fas fa-chevron-right text-xs"></i> Tentang Kami</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>BANTUAN</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-question-circle"></i> FAQ / Pertanyaan</a></li>
                    <li><a href="#"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a></li>
                    <li><a href="#"><i class="fas fa-file-contract"></i> Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Menjadi Kontributor</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>KONTAK KAMI</h3>
                <p class="flex items-center gap-2"><span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span> Bengkalis, Riau, Indonesia</p>
                <p class="flex items-center gap-2"><span class="contact-icon"><i class="fas fa-envelope"></i></span> admin@jejaklayar.com</p>
                <div class="socials">
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Jejak Layar — All Rights Reserved.</p>
        </div>
    </footer>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ===== splash =====
            const splash = document.getElementById('logo-splash');
            if (splash) {
                setTimeout(() => {
                    splash.classList.add('fade-out');
                    setTimeout(() => splash.style.display = 'none', 800);
                }, 2500);
            }

            // ===== Click Spark Effect class =====
            class ClickSparkEffect {
                constructor(canvas, options = {}) {
                    this.canvas = canvas;
                    this.ctx = canvas.getContext('2d');
                    this.sparks = [];
                    this.sparkColor = options.sparkColor || '#f4b400';
                    this.sparkSize = options.sparkSize || 10;
                    this.sparkRadius = options.sparkRadius || 20;
                    this.sparkCount = options.sparkCount || 8;
                    this.duration = options.duration || 400;
                    this.extraScale = options.extraScale || 1.0;
                    this.setupCanvas();
                    this.animate();
                }
                setupCanvas() {
                    const parent = this.canvas.parentElement;
                    const rect = parent.getBoundingClientRect();
                    this.canvas.width = rect.width;
                    this.canvas.height = rect.height;
                    window.addEventListener('resize', () => {
                        const newRect = parent.getBoundingClientRect();
                        this.canvas.width = newRect.width;
                        this.canvas.height = newRect.height;
                    });
                }
                easeOutQuad(t) { return t * (2 - t); }
                createSparks(x, y) {
                    const now = performance.now();
                    for (let i = 0; i < this.sparkCount; i++) {
                        this.sparks.push({ x, y, angle: (2*Math.PI*i)/this.sparkCount, startTime: now });
                    }
                }
                animate() {
                    const draw = (timestamp) => {
                        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                        this.sparks = this.sparks.filter(spark => {
                            const elapsed = timestamp - spark.startTime;
                            if (elapsed >= this.duration) return false;
                            const progress = elapsed / this.duration;
                            const eased = this.easeOutQuad(progress);
                            const distance = eased * this.sparkRadius * this.extraScale;
                            const lineLength = this.sparkSize * (1 - eased);
                            const x1 = spark.x + distance * Math.cos(spark.angle);
                            const y1 = spark.y + distance * Math.sin(spark.angle);
                            const x2 = spark.x + (distance + lineLength) * Math.cos(spark.angle);
                            const y2 = spark.y + (distance + lineLength) * Math.sin(spark.angle);
                            this.ctx.strokeStyle = this.sparkColor;
                            this.ctx.lineWidth = 2;
                            this.ctx.beginPath();
                            this.ctx.moveTo(x1, y1);
                            this.ctx.lineTo(x2, y2);
                            this.ctx.stroke();
                            return true;
                        });
                        requestAnimationFrame(draw);
                    };
                    requestAnimationFrame(draw);
                }
            }

            // init logo spark
            const logoCanvas = document.getElementById('logo-spark-canvas');
            const logoClickable = document.getElementById('logo-clickable');
            if (logoCanvas && logoClickable) {
                const sparkEffect = new ClickSparkEffect(logoCanvas, {
                    sparkColor: '#d97706', sparkSize:8, sparkRadius:18, sparkCount:8, duration:600
                });
                logoClickable.addEventListener('click', (e) => {
                    e.preventDefault();
                    const rect = logoCanvas.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    sparkEffect.createSparks(x, y);
                    setTimeout(() => window.location.href = logoClickable.href, 200);
                });
            }

            // ===== dropdown user =====
            const userToggle = document.getElementById('user-menu-toggle');
            const userDropdown = document.getElementById('user-menu-dropdown');
            if (userToggle && userDropdown) {
                userToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isShown = userDropdown.style.display === 'block';
                    userDropdown.style.display = isShown ? 'none' : 'block';
                });
                document.addEventListener('click', (e) => {
                    if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.style.display = 'none';
                    }
                });
            }

            // ===== help floating =====
            const helpBtn = document.getElementById('help-btn');
            const helpOptions = document.getElementById('help-options');
            if (helpBtn && helpOptions) {
                helpBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    helpBtn.classList.toggle('active');
                });
                document.addEventListener('click', (e) => {
                    if (!helpBtn.contains(e.target) && !helpOptions.contains(e.target)) {
                        helpBtn.classList.remove('active');
                    }
                });
            }

            // ===== header shadow on scroll =====
            const header = document.querySelector('.site-header');
            if (header) {
                window.addEventListener('scroll', () => {
                    const currentScroll = window.pageYOffset;
                    header.style.boxShadow = currentScroll > 100 ? '0 4px 15px rgba(0,0,0,0.12)' : '0 2px 10px rgba(0,0,0,0.06)';
                }, { passive: true });
            }

            // ===== smooth anchor =====
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || !href) return;
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const headerHeight = header ? header.offsetHeight : 0;
                        const targetPosition = target.offsetTop - headerHeight - 20;
                        window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                    }
                });
            });

            // ===== prevent layout shift on images =====
            document.querySelectorAll('img').forEach(img => {
                if (!img.complete) {
                    img.addEventListener('load', () => img.style.display = 'block');
                } else {
                    img.style.display = 'block';
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
