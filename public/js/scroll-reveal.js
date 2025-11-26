// Scroll Reveal Animation with GSAP
(function() {
  'use strict';

  // Wait for GSAP and ScrollTrigger to load
  function initScrollReveal() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.error('GSAP or ScrollTrigger not loaded');
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    // Configuration
    const config = {
      enableBlur: true,
      baseOpacity: 0.1,
      baseRotation: 3,
      blurStrength: 4,
      rotationEnd: 'bottom bottom',
      wordAnimationEnd: 'bottom bottom'
    };

    // Function to split text into words
    function splitTextIntoWords(element) {
      const text = element.textContent;
      const words = text.split(/(\s+)/);
      
      element.innerHTML = '';
      
      words.forEach((word) => {
        if (word.match(/^\s+$/)) {
          element.appendChild(document.createTextNode(word));
        } else {
          const span = document.createElement('span');
          span.className = 'word';
          span.textContent = word;
          element.appendChild(span);
        }
      });
    }

    // Function to apply scroll reveal to an element
    function applyScrollReveal(element) {
      // Split text into words
      splitTextIntoWords(element);

      const wordElements = element.querySelectorAll('.word');

      // Rotation animation
      gsap.fromTo(
        element,
        { 
          transformOrigin: '0% 50%', 
          rotate: config.baseRotation 
        },
        {
          ease: 'none',
          rotate: 0,
          scrollTrigger: {
            trigger: element,
            start: 'top bottom',
            end: config.rotationEnd,
            scrub: true,
            markers: false // Set to true for debugging
          }
        }
      );

      // Opacity animation
      gsap.fromTo(
        wordElements,
        { 
          opacity: config.baseOpacity,
          willChange: 'opacity'
        },
        {
          ease: 'none',
          opacity: 1,
          stagger: 0.05,
          scrollTrigger: {
            trigger: element,
            start: 'top bottom-=20%',
            end: config.wordAnimationEnd,
            scrub: true,
            markers: false
          }
        }
      );

      // Blur animation (if enabled)
      if (config.enableBlur) {
        gsap.fromTo(
          wordElements,
          { 
            filter: `blur(${config.blurStrength}px)` 
          },
          {
            ease: 'none',
            filter: 'blur(0px)',
            stagger: 0.05,
            scrollTrigger: {
              trigger: element,
              start: 'top bottom-=20%',
              end: config.wordAnimationEnd,
              scrub: true,
              markers: false
            }
          }
        );
      }
    }

    // Initialize all elements with data-scroll-reveal attribute
    const revealElements = document.querySelectorAll('[data-scroll-reveal]');
    
    revealElements.forEach((element) => {
      applyScrollReveal(element);
    });

    console.log(`Scroll Reveal initialized for ${revealElements.length} elements`);
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollReveal);
  } else {
    initScrollReveal();
  }

})();