@extends('layouts.app')

@section('title', 'Tentang Jejak Layar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tentang.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

<!-- Hero Section -->
<section class="hero-about">
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    
    <div class="hero-content">
        <div class="hero-badge">
            <span>Est. 2024</span>
        </div>
        
        <h1 class="hero-title">
            Tentang <span>Jejak Layar</span>
        </h1>
        
        <p class="hero-description">
            Jejak Layar adalah platform digital yang didedikasikan untuk mendokumentasikan,
            mengarsipkan, dan memperkenalkan kekayaan budaya Melayu Bengkalis kepada dunia.
            Kami percaya bahwa warisan budaya adalah identitas bangsa yang harus dijaga dan diwariskan.
        </p>
        
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">100+</span>
                <span class="stat-label">Koleksi Budaya</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number">50+</span>
                <span class="stat-label">Cerita Rakyat</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number">1000+</span>
                <span class="stat-label">Pengguna Aktif</span>
            </div>
        </div>
    </div>
</section>

<!-- Decorative Ornament -->
<div class="ornament-divider">
    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M30 10L35 25H50L38 33L42 48L30 40L18 48L22 33L10 25H25L30 10Z" fill="#d4a744"/>
    </svg>
</div>

<!-- Visi & Misi Section -->
<section class="vision-mission-section">
    <div class="container">
        <h2 class="section-title">
            Visi dan Misi Kami
        </h2>
        
        <div class="vision-mission-grid">
            
            <!-- Visi Card -->
            <div class="vm-card visi-card">
                <div class="vm-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z"/>
                        <path d="M2 17L12 22L22 17"/>
                        <path d="M2 12L12 17L22 12"/>
                    </svg>
                </div>
                <h3 class="vm-title">Visi</h3>
                <p class="vm-description">
                    Melestarikan dan memperkenalkan budaya Melayu Bengkalis ke generasi muda dan dunia melalui digitalisasi warisan budaya yang inovatif.
                </p>
            </div>

            <!-- Misi Card -->
            <div class="vm-card misi-card">
                <div class="vm-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <h3 class="vm-title">Misi</h3>
                <ul class="vm-list">
                    <li>📖 Mendokumentasikan seni, adat, dan tradisi lokal</li>
                    <li>💾 Menyediakan pustaka digital budaya Melayu Bengkalis</li>
                    <li>🎓 Mengedukasi generasi muda lewat media interaktif</li>
                    <li>🌐 Membangun komunitas pecinta budaya Melayu</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- Tim Kami Section -->
<section class="team-section">
    <div class="container">
        <h2 class="section-title">
            Tim Kami
        </h2>
        
        <p class="team-subtitle">
            Orang-orang di balik layar yang berdedikasi melestarikan budaya Melayu
        </p>

        <div class="team-grid">
            
            <!-- Team Member 1 -->
            <div class="team-card" onclick="toggleTeamInfo(this)">
                <div class="team-frame">
                    <div class="frame-pattern"></div>
                    <img src="{{ asset('images/team/Irfan Iswandi.png') }}" 
                         alt="Natasya" 
                         class="team-photo"
                         onerror="this.src='{{ asset('images/team/Irfan Iswandi.png') }}'">
                    <div class="frame-shine"></div>
                </div>
                
                <div class="team-info">
                    <h3 class="team-name">Natasya</h3>
                    <p class="team-role">Lead Developer</p>
                    <p class="team-description">
                        Spesialis dalam pengembangan web dan digitalisasi budaya
                    </p>
                </div>
                
                <div class="team-social">
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="team-card" onclick="toggleTeamInfo(this)">
                <div class="team-frame">
                    <div class="frame-pattern"></div>
                    <img src="{{ asset('images/team/Irfan Iswandi.png') }}" 
                         alt="Irfan Iswandi" 
                         class="team-photo"
                         onerror="this.src='{{ asset('images/team/placeholder.png') }}'">
                    <div class="frame-shine"></div>
                </div>
                
                <div class="team-info">
                    <h3 class="team-name">Irfan Iswandi</h3>
                    <p class="team-role">UI/UX Designer</p>
                    <p class="team-description">
                        Ahli desain antarmuka dengan sentuhan budaya Melayu
                    </p>
                </div>
                
                <div class="team-social">
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="team-card" onclick="toggleTeamInfo(this)">
                <div class="team-frame">
                    <div class="frame-pattern"></div>
                    <img src="{{ asset('images/team/masdinar.png') }}" 
                         alt="Masdinar Akmi" 
                         class="team-photo"
                         onerror="this.src='{{ asset('images/team/placeholder.png') }}'">
                    <div class="frame-shine"></div>
                </div>
                
                <div class="team-info">
                    <h3 class="team-name">Masdinar Akmi</h3>
                    <p class="team-role">Content Curator</p>
                    <p class="team-description">
                        Kurator konten budaya dan peneliti tradisi Melayu
                    </p>
                </div>
                
                <div class="team-social">
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <h2 class="section-title">Nilai-Nilai Kami</h2>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🏛️</div>
                <h3>Pelestarian</h3>
                <p>Menjaga warisan budaya untuk generasi mendatang</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Kolaborasi</h3>
                <p>Bekerja sama dengan komunitas dan ahli budaya</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3>Inovasi</h3>
                <p>Menggunakan teknologi untuk digitalisasi budaya</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">📚</div>
                <h3>Edukasi</h3>
                <p>Mengedukasi masyarakat tentang budaya Melayu</p>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script>
function toggleTeamInfo(card) {
    // Remove active class from all cards
    document.querySelectorAll('.team-card').forEach(c => {
        if (c !== card) {
            c.classList.remove('active');
        }
    });
    
    // Toggle active class on clicked card
    card.classList.toggle('active');
}

// Add scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

document.querySelectorAll('.vm-card, .team-card, .value-card').forEach(el => {
    observer.observe(el);
});
</script>

@endsection