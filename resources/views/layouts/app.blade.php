<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Layar')</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body>
    {{-- SPLASH --}}
    <div id="logo-splash">
        <div class="splash-logo-container">
            <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="Jejak Layar" class="splash-logo">
        </div>
    </div>

    {{-- MOBILE OVERLAY --}}
    <div class="mobile-overlay" id="mobileOverlay"></div>

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
                <input type="search" name="q" placeholder="Cari: judul, tokoh, kata kunci..."
                    value="{{ request('q') }}">
            </form>
        </div>

        <div class="header-right">
            {{-- MOBILE MENU TOGGLE --}}
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>

                @if (isset($globalCategories) && $globalCategories->count() > 0)
                    @foreach ($globalCategories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}"
                            class="nav-link {{ request()->is('kategori/' . $cat->slug . '*') ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @else
                    <a href="{{ route('budaya') }}"
                        class="nav-link {{ request()->routeIs('budaya') ? 'active' : '' }}">
                        Budaya
                    </a>
                    <a href="{{ route('pustaka') }}"
                        class="nav-link {{ request()->routeIs('pustaka') ? 'active' : '' }}">
                        Pustaka
                    </a>
                @endif

                <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">
                    Tentang
                </a>

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
                                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard
                                    Admin</a>
                            @elseif (Auth::user()->role === 'kontributor')
                                <a href="{{ route('kontributor.dashboard') }}"><i class="fas fa-pencil-alt"></i> Dashboard
                                    Kontributor</a>
                            @endif

                            <a href="{{ route('kontributor.profil') }}"><i class="fas fa-user-circle"></i> Profil Saya</a>

                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i>
                                    Keluar</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    {{-- MOBILE MENU PANEL --}}
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Beranda
        </a>

        @if (isset($globalCategories) && $globalCategories->count() > 0)
            @foreach ($globalCategories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}"
                    class="nav-link {{ request()->is('kategori/' . $cat->slug . '*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i> {{ $cat->name }}
                </a>
            @endforeach
        @else
            <a href="{{ route('budaya') }}" class="nav-link {{ request()->routeIs('budaya') ? 'active' : '' }}">
                <i class="fas fa-landmark"></i> Budaya
            </a>
            <a href="{{ route('pustaka') }}" class="nav-link {{ request()->routeIs('pustaka') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Pustaka
            </a>
        @endif

        <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i> Tentang
        </a>

        @guest
            <a href="{{ route('login') }}" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        @endguest

        @auth
            <div class="mobile-user-section">
                <div class="mobile-user-info">
                    <img src="{{ asset('FOTO/avatar.png') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random'"
                        alt="Profil" class="profile-img">
                    <span>{{ Auth::user()->name }}</span>
                </div>

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                    </a>
                @elseif (Auth::user()->role === 'kontributor')
                    <a href="{{ route('kontributor.dashboard') }}" class="nav-link">
                        <i class="fas fa-pencil-alt"></i> Dashboard Kontributor
                    </a>
                @endif

                <a href="{{ route('kontributor.profil') }}" class="nav-link">
                    <i class="fas fa-user-circle"></i> Profil Saya
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin:15px 0 0 0;">
                    @csrf
                    <button type="submit" class="btn-logout-mobile">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        @endauth
    </div>

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
            <a href="{{ route('faq') }}" class="help-item">
                <span>FAQ / Pertanyaan</span>
                <i class="fas fa-book-open"></i>
            </a>

            <a href="mailto:admin@jejaklayar.com" class="help-item">
                <span>Email Admin</span>
                <i class="fas fa-envelope"></i>
            </a>

            <a href="{{ route('panduan') }}" class="help-item">
                <span>Panduan Kontributor</span>
                <i class="fas fa-user-edit"></i>
            </a>

            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Jejak%20Layar%2C%20saya%20butuh%20bantuan"
                target="_blank" rel="noopener noreferrer" class="help-item">
                <span>Chat WhatsApp</span>
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col brand">
                <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar"
                    style="height:50px;margin-bottom:15px;">
                <p>Melayu Bengkalis dalam satu portal digital untuk semua generasi. Kami berdedikasi menjaga warisan
                    budaya dan mendekatkan generasi muda dengan sejarahnya.</p>
            </div>

            <div class="footer-col">
                <h3>JELAJAHI</h3>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right text-xs"></i> Beranda</a></li>
                    <li><a href="{{ route('budaya') }}"><i class="fas fa-chevron-right text-xs"></i> Budaya</a></li>
                    <li><a href="{{ route('pustaka') }}"><i class="fas fa-chevron-right text-xs"></i> Pustaka
                            Digital</a></li>
                    <li><a href="{{ route('tentang') }}"><i class="fas fa-chevron-right text-xs"></i> Tentang
                            Kami</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>BANTUAN</h3>
                <ul>
                    <li><a href="{{ route('faq') }}"><i class="fas fa-question-circle"></i> FAQ / Pertanyaan</a>
                    </li>
                    <li><a href="#"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a></li>
                    <li><a href="#"><i class="fas fa-file-contract"></i> Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Menjadi Kontributor</a>
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>KONTAK KAMI</h3>
                <p class="flex items-center gap-2"><span class="contact-icon"><i
                            class="fas fa-map-marker-alt"></i></span> Bengkalis, Riau, Indonesia</p>
                <p class="flex items-center gap-2"><span class="contact-icon"><i class="fas fa-envelope"></i></span>
                    admin@jejaklayar.com</p>
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
                }, 500);
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
                easeOutQuad(t) {
                    return t * (2 - t);
                }
                createSparks(x, y) {
                    const now = performance.now();
                    for (let i = 0; i < this.sparkCount; i++) {
                        this.sparks.push({
                            x,
                            y,
                            angle: (2 * Math.PI * i) / this.sparkCount,
                            startTime: now
                        });
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
                    sparkColor: '#d97706',
                    sparkSize: 8,
                    sparkRadius: 18,
                    sparkCount: 8,
                    duration: 600
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

            // ===== Mobile menu toggle =====
            const mobileToggle = document.getElementById('mobileMenuToggle');
            const mobilePanel = document.getElementById('mobileMenuPanel');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (mobileToggle && mobilePanel) {
                mobileToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileToggle.classList.toggle('active');
                    mobilePanel.classList.toggle('active');
                    mobileOverlay.classList.toggle('active');
                    document.body.style.overflow = mobilePanel.classList.contains('active') ? 'hidden' : '';
                });

                mobileOverlay.addEventListener('click', () => {
                    mobileToggle.classList.remove('active');
                    mobilePanel.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });

                // Close on link click
                mobilePanel.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileToggle.classList.remove('active');
                        mobilePanel.classList.remove('active');
                        mobileOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    });
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
                    header.style.boxShadow = currentScroll > 100 ? '0 4px 15px rgba(0,0,0,0.12)' :
                        '0 2px 10px rgba(0,0,0,0.06)';
                }, {
                    passive: true
                });
            }

            // ===== smooth anchor =====
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || !href) return;
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const headerHeight = header ? header.offsetHeight : 0;
                        const targetPosition = target.offsetTop - headerHeight - 20;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
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
