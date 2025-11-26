/* ============================================
   HOME PAGE ANIMATIONS JAVASCRIPT
   Letakkan di: public/js/home-animations.js
   ============================================ */

// ============================================
// SCROLL REVEAL FUNCTIONALITY
// ============================================
function initScrollReveal() {
  const revealElements = document.querySelectorAll('[data-scroll-reveal]');
  
  revealElements.forEach(container => {
    const textElement = container.querySelector('.scroll-reveal-text');
    if (!textElement) return;
    
    const baseOpacity = parseFloat(textElement.dataset.baseOpacity || '0.15');
    const baseRotation = parseFloat(textElement.dataset.baseRotation || '1.5');
    const blurStrength = parseFloat(textElement.dataset.blurStrength || '8');
    const enableBlur = textElement.dataset.enableBlur !== 'false';
    
    const originalText = textElement.textContent;
    const words = originalText.split(/(\s+)/);
    
    // Split into words but keep text visible initially
    textElement.innerHTML = words.map(word => {
      if (word.match(/^\s+$/)) return word;
      return `<span class="word">${word}</span>`;
    }).join('');
    
    const wordElements = textElement.querySelectorAll('.word');
    
    // Wait a bit before initializing animation to show content first
    setTimeout(() => {
      textElement.classList.add('ready');
      container.style.transformOrigin = 'center center';
      container.style.transition = 'transform 0.1s linear';
      
      wordElements.forEach(word => {
        word.style.display = 'inline-block';
        word.style.transition = 'opacity 0.15s ease-out, filter 0.15s ease-out';
      });
      
      // Start animation
      animateOnScroll();
    }, 100);
    
    function animateOnScroll() {
      const rect = container.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      
      const elementTop = rect.top;
      const elementHeight = rect.height;
      const startTrigger = windowHeight * 0.85;
      const endTrigger = windowHeight * 0.2;
      
      let scrollProgress = 0;
      
      if (elementTop < startTrigger && elementTop > endTrigger - elementHeight) {
        scrollProgress = 1 - ((elementTop - endTrigger) / (startTrigger - endTrigger));
        scrollProgress = Math.max(0, Math.min(1, scrollProgress));
      } else if (elementTop <= endTrigger - elementHeight) {
        scrollProgress = 1;
      }
      
      // Apply rotation with easing
      const rotation = baseRotation * (1 - scrollProgress);
      container.style.transform = `rotate(${rotation}deg)`;
      
      // Animate words with stagger
      wordElements.forEach((word, index) => {
        const wordDelay = index * 0.025;
        const wordProgress = Math.max(0, Math.min(1, (scrollProgress - wordDelay) * 1.5));
        
        const opacity = baseOpacity + (1 - baseOpacity) * wordProgress;
        word.style.opacity = opacity;
        
        if (enableBlur) {
          const blur = blurStrength * (1 - wordProgress);
          word.style.filter = `blur(${Math.max(0, blur)}px)`;
        }
      });
    }
    
    let ticking = false;
    function onScroll() {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          animateOnScroll();
          ticking = false;
        });
        ticking = true;
      }
    }
    
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
  });
}

// ============================================
// CIRCULAR GALLERY WITH AUTO-ROTATE
// ============================================
class CircularGallery {
  constructor(container, options = {}) {
    this.container = container;
    this.items = options.items || this.getDefaultItems();
    this.bend = options.bend || 0;
    this.textColor = options.textColor || '#2d3748';
    this.scrollSpeed = options.scrollSpeed || 2;
    this.scrollEase = options.scrollEase || 0.12; // Lebih smooth (dari 0.08)
    this.autoRotate = options.autoRotate !== false;
    this.autoRotateSpeed = options.autoRotateSpeed || 0.8;
    
    this.scroll = { ease: this.scrollEase, current: 0, target: 0, last: 0 };
    this.isDown = false;
    this.medias = [];
    this.userInteracted = false;
    this.lastInteractionTime = 0;
    this.autoRotateDelay = 2000;
    this.autoRotateStarted = false;
    
    this.init();
  }
  
  getDefaultItems() {
    const items = [];
    // 8 foto untuk looping yang lebih smooth
    for (let i = 1; i <= 8; i++) {
      items.push({
        image: `/images/circular-gallery(${i}).png`,
        text: `Warisan ${i}`
      });
    }
    return items;
  }
  
  init() {
    this.createCanvas();
    this.createMediaElements();
    this.addEventListeners();
    this.animate();
  }
  
  createCanvas() {
    this.canvas = document.createElement('canvas');
    this.ctx = this.canvas.getContext('2d');
    this.container.appendChild(this.canvas);
    this.resize();
  }
  
  createMediaElements() {
    // Triple the items for smoother infinite loop
    const tripledItems = [...this.items, ...this.items, ...this.items];
    let loadedCount = 0;
    const totalImages = tripledItems.length;
    
    tripledItems.forEach((item, index) => {
      const media = {
        image: new Image(),
        text: item.text,
        index: index,
        length: tripledItems.length,
        extra: 0,
        loaded: false
      };
      
      media.image.crossOrigin = 'anonymous';
      media.image.onload = () => {
        media.loaded = true;
        loadedCount++;
        
        // Start auto-rotate as soon as first few images load
        if (loadedCount >= 3 && !this.autoRotateStarted) {
          this.autoRotateStarted = true;
          console.log('Auto-rotate started with 8 images');
        }
      };
      media.image.onerror = () => {
        console.warn(`Failed to load: ${item.image}`);
        loadedCount++;
      };
      
      // Load images immediately
      media.image.src = item.image;
      
      this.medias.push(media);
    });
    
    this.updateMediaPositions();
    
    // SET POSISI AWAL: Gambar pertama di tengah
    // Hitung offset agar gambar pertama (index 8) di center
    // Karena triple items, gambar pertama asli ada di index 8
    const firstImageIndex = this.items.length; // Index 8
    const itemWidth = Math.min(this.height * 0.65, 380) * 0.75;
    const padding = itemWidth * 0.25;
    const totalWidth = itemWidth + padding;
    
    // Set scroll target dan current ke posisi gambar pertama
    this.scroll.target = firstImageIndex * totalWidth;
    this.scroll.current = firstImageIndex * totalWidth;
    this.scroll.last = firstImageIndex * totalWidth;
    
    console.log(`Initial position set: Image 1 centered at scroll ${this.scroll.current}`);
  }
  
  updateMediaPositions() {
    const rect = this.container.getBoundingClientRect();
    this.width = rect.width;
    this.height = rect.height;
    
    const itemHeight = Math.min(this.height * 0.65, 380);
    const itemWidth = itemHeight * 0.75;
    const padding = itemWidth * 0.25; // Lebih rapat untuk 8 foto
    
    this.medias.forEach((media, index) => {
      media.width = itemWidth;
      media.height = itemHeight;
      media.padding = padding;
      media.totalWidth = itemWidth + padding;
      media.x = (itemWidth + padding) * index;
      media.widthTotal = (itemWidth + padding) * this.medias.length;
    });
    
    // Update scroll position after resize if needed
    if (this.scroll.current === 0 && this.medias.length > 0) {
      const firstImageIndex = this.items.length;
      const totalWidth = itemWidth + padding;
      this.scroll.target = firstImageIndex * totalWidth;
      this.scroll.current = firstImageIndex * totalWidth;
      this.scroll.last = firstImageIndex * totalWidth;
    }
  }
  
  resize() {
    const rect = this.container.getBoundingClientRect();
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    this.canvas.width = rect.width * dpr;
    this.canvas.height = rect.height * dpr;
    this.canvas.style.width = rect.width + 'px';
    this.canvas.style.height = rect.height + 'px';
    this.ctx.scale(dpr, dpr);
    this.updateMediaPositions();
  }
  
  draw() {
    this.ctx.clearRect(0, 0, this.width, this.height);
    
    const centerY = this.height / 2;
    
    this.medias.forEach(media => {
      if (!media.loaded) return;
      
      // Calculate base position
      let baseX = media.x - this.scroll.current - media.extra;
      
      // INFINITE LOOP LOGIC - Seamless wrapping
      const viewportOffset = this.width / 2 + media.width * 2;
      
      // Wrap around logic for infinite scroll
      if (baseX < -viewportOffset) {
        media.extra -= media.widthTotal;
      } else if (baseX > viewportOffset) {
        media.extra += media.widthTotal;
      }
      
      // Recalculate position after wrapping
      const x = media.x - this.scroll.current - media.extra;
      
      let posX = this.width / 2 + x;
      let posY = centerY;
      let rotation = 0; // FRAME TIDAK ROTATE - selalu 0
      
      // Apply bend effect (CURVE DOWN - positive value)
      if (this.bend !== 0) {
        const H = this.width / 2;
        const B_abs = Math.abs(this.bend) * 100;
        const R = (H * H + B_abs * B_abs) / (2 * B_abs);
        const effectiveX = Math.min(Math.abs(x), H);
        const arc = R - Math.sqrt(R * R - effectiveX * effectiveX);
        
        if (this.bend > 0) {
          posY = centerY + arc; // Curve DOWN
        } else {
          posY = centerY - arc; // Curve UP
        }
        
        // ROTATION DISABLED - frame tetap horizontal
        // rotation = 0; // Already set to 0 above
      }
      
      this.ctx.save();
      this.ctx.translate(posX, posY);
      // TIDAK ADA ROTATE - komentar baris ini
      // this.ctx.rotate(rotation);
      
      this.ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
      this.ctx.shadowBlur = 15;
      this.ctx.shadowOffsetY = 5;
      
      const radius = 12;
      this.ctx.beginPath();
      this.ctx.moveTo(-media.width / 2 + radius, -media.height / 2);
      this.ctx.lineTo(media.width / 2 - radius, -media.height / 2);
      this.ctx.quadraticCurveTo(media.width / 2, -media.height / 2, media.width / 2, -media.height / 2 + radius);
      this.ctx.lineTo(media.width / 2, media.height / 2 - radius);
      this.ctx.quadraticCurveTo(media.width / 2, media.height / 2, media.width / 2 - radius, media.height / 2);
      this.ctx.lineTo(-media.width / 2 + radius, media.height / 2);
      this.ctx.quadraticCurveTo(-media.width / 2, media.height / 2, -media.width / 2, media.height / 2 - radius);
      this.ctx.lineTo(-media.width / 2, -media.height / 2 + radius);
      this.ctx.quadraticCurveTo(-media.width / 2, -media.height / 2, -media.width / 2 + radius, -media.height / 2);
      this.ctx.closePath();
      this.ctx.clip();
      
      this.ctx.drawImage(media.image, -media.width / 2, -media.height / 2, media.width, media.height);
      
      this.ctx.restore();
      
      // Draw text below image - JUGA TIDAK ROTATE
      this.ctx.save();
      this.ctx.translate(posX, posY);
      // TIDAK ADA ROTATE untuk text
      
      this.ctx.fillStyle = this.textColor;
      this.ctx.font = 'bold 18px system-ui, -apple-system, sans-serif';
      this.ctx.textAlign = 'center';
      this.ctx.textBaseline = 'top';
      
      this.ctx.shadowColor = 'rgba(255, 255, 255, 0.8)';
      this.ctx.shadowBlur = 4;
      this.ctx.fillText(media.text, 0, media.height / 2 + 15);
      
      this.ctx.restore();
    });
  }
  
  animate() {
    // Check if gallery is in viewport
    const rect = this.container.getBoundingClientRect();
    const isInViewport = (
      rect.top < window.innerHeight &&
      rect.bottom > 0
    );
    
    // Auto-rotate logic - ONLY when in viewport
    if (this.autoRotate && isInViewport) {
      const now = Date.now();
      const timeSinceInteraction = now - this.lastInteractionTime;
      
      // Always rotate, but pause briefly during interaction
      if (!this.isDown) {
        // Resume faster after interaction
        if (timeSinceInteraction > 2000 || !this.userInteracted) {
          this.scroll.target += this.autoRotateSpeed;
        }
      }
    }
    
    this.scroll.current += (this.scroll.target - this.scroll.current) * this.scroll.ease;
    this.draw();
    this.scroll.last = this.scroll.current;
    this.animationFrame = requestAnimationFrame(() => this.animate());
  }
  
  onMouseDown(e) {
    this.isDown = true;
    this.userInteracted = true;
    this.lastInteractionTime = Date.now();
    this.startX = e.touches ? e.touches[0].clientX : e.clientX;
    this.scrollStart = this.scroll.current;
    this.container.style.cursor = 'grabbing';
  }
  
  onMouseMove(e) {
    if (!this.isDown) return;
    e.preventDefault();
    this.lastInteractionTime = Date.now();
    const x = e.touches ? e.touches[0].clientX : e.clientX;
    const distance = (this.startX - x) * (this.scrollSpeed * 0.6);
    this.scroll.target = this.scrollStart + distance;
  }
  
  onMouseUp() {
    this.isDown = false;
    this.lastInteractionTime = Date.now();
    this.container.style.cursor = 'grab';
  }
  
  onWheel(e) {
    e.preventDefault();
    this.userInteracted = true;
    this.lastInteractionTime = Date.now();
    const delta = e.deltaY || e.wheelDelta || e.detail;
    this.scroll.target += (delta > 0 ? this.scrollSpeed : -this.scrollSpeed) * 4;
  }
  
  addEventListeners() {
    this.boundResize = () => this.resize();
    this.boundMouseDown = (e) => this.onMouseDown(e);
    this.boundMouseMove = (e) => this.onMouseMove(e);
    this.boundMouseUp = () => this.onMouseUp();
    this.boundWheel = (e) => this.onWheel(e);
    
    window.addEventListener('resize', this.boundResize);
    this.container.addEventListener('mousedown', this.boundMouseDown);
    window.addEventListener('mousemove', this.boundMouseMove);
    window.addEventListener('mouseup', this.boundMouseUp);
    this.container.addEventListener('touchstart', this.boundMouseDown, { passive: false });
    this.container.addEventListener('touchmove', this.boundMouseMove, { passive: false });
    this.container.addEventListener('touchend', this.boundMouseUp);
    this.container.addEventListener('wheel', this.boundWheel, { passive: false });
  }
  
  destroy() {
    cancelAnimationFrame(this.animationFrame);
    window.removeEventListener('resize', this.boundResize);
    this.container.removeEventListener('mousedown', this.boundMouseDown);
    window.removeEventListener('mousemove', this.boundMouseMove);
    window.removeEventListener('mouseup', this.boundMouseUp);
    this.container.removeEventListener('touchstart', this.boundMouseDown);
    this.container.removeEventListener('touchmove', this.boundMouseMove);
    this.container.removeEventListener('touchend', this.boundMouseUp);
    this.container.removeEventListener('wheel', this.boundWheel);
  }
}

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Scroll Reveal immediately (no delay)
  initScrollReveal();
  
  // Initialize Circular Gallery IMMEDIATELY with auto-rotate
  const galleryContainer = document.getElementById('gallery-canvas');
  if (galleryContainer) {
    // Start immediately without waiting
    const gallery = new CircularGallery(galleryContainer, {
      bend: 2.5,               // Melengkung ke BAWAH (nilai POSITIF = curve down)
      textColor: '#2d3748',
      scrollSpeed: 2,
      scrollEase: 0.12,        // Lebih smooth
      autoRotate: true,
      autoRotateSpeed: 0.8     // Kecepatan rotasi
    });
    
    console.log('Gallery initialized: 8 images, no rotation, smooth loop, starts centered');
  }
  
  // Animate Cards
  const cards = document.querySelectorAll('[data-animate-in]');
  const fadeIns = document.querySelectorAll('[data-fade-in]');
  
  const observerOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -80px 0px'
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }, index * 100);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  
  cards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
  });
  
  fadeIns.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
    observer.observe(el);
  });
});