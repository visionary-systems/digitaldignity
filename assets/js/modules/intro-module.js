// =============================================================================
// Intro Module - Animation & Slideshow Controller
// =============================================================================

const IntroModule = (() => {
  // State
  let currentState = 'landing'; // 'landing', 'transition', 'loop'
  let currentSlide = 1;
  let totalSlides = 3;
  let hasTransitioned = false;
  let isTransitioning = false;

  // DOM Elements
  let animation1, animation2, animation3;
  let slideshow, scrollTrigger;
  let slides, indicators;
  let prevBtn, nextBtn;

  // Configuration
  const SCROLL_THRESHOLD = 50; // pixels

  /**
   * Initialize the module
   */
  function init() {
    // Cache DOM elements
    animation1 = document.getElementById('animation1');
    animation2 = document.getElementById('animation2');
    animation3 = document.getElementById('animation3');
    slideshow = document.getElementById('introSlideshow');
    scrollTrigger = document.getElementById('scrollTrigger');
    
    slides = document.querySelectorAll('.intro-module__slide');
    indicators = document.querySelectorAll('.intro-module__indicator');
    prevBtn = document.getElementById('prevSlide');
    nextBtn = document.getElementById('nextSlide');

    if (!animation1 || !animation2 || !animation3) {
      console.error('IntroModule: Required video elements not found');
      return;
    }

    // Setup
    setupVideoEvents();
    setupSlideshowControls();
    setupScrollDetection();
    setupKeyboardNavigation();
    
    // Start Stage 1: Landing
    startLandingStage();
  }

  /**
   * Stage 1: Landing - Play animation1 MUTED, show slideshow
   */
  function startLandingStage() {
    currentState = 'landing';
    
    // CRITICAL: Mute animation1 for autoplay (no sound on page load)
    animation1.muted = true;
    
    // Play animation1
    const playPromise = animation1.play();
    
    if (playPromise !== undefined) {
      playPromise.catch(error => {
        console.log('Autoplay prevented, waiting for user interaction:', error);
        // Fallback: show poster image, wait for user interaction
        document.addEventListener('click', () => {
          animation1.play();
        }, { once: true });
      });
    }
  }

  /**
   * Setup video event listeners
   */
  function setupVideoEvents() {
    // Animation1: Play once, then optionally loop
    animation1.addEventListener('ended', () => {
      if (currentState === 'landing') {
        // Optionally loop animation1 in background (still muted)
        animation1.loop = true;
        animation1.play();
      }
    });

    // Animation2: Transition to animation3 when complete
    animation2.addEventListener('ended', () => {
      if (currentState === 'transition') {
        transitionToLoopStage();
      }
    });

    // Preload animation3 when animation2 starts
    animation2.addEventListener('playing', () => {
      if (animation3.readyState < 3) {
        animation3.load();
      }
    });
  }

  /**
   * Setup slideshow controls
   */
  function setupSlideshowControls() {
    if (!prevBtn || !nextBtn) return;
    
    // Previous button
    prevBtn.addEventListener('click', () => navigateSlide(-1));
    
    // Next button
    nextBtn.addEventListener('click', () => navigateSlide(1));
    
    // Indicator dots
    indicators.forEach(indicator => {
      indicator.addEventListener('click', (e) => {
        const targetSlide = parseInt(e.target.dataset.slide);
        goToSlide(targetSlide);
      });
    });

    // Touch swipe support
    setupTouchSwipe();
  }

  /**
   * Navigate slideshow
   */
  function navigateSlide(direction) {
    const nextSlide = currentSlide + direction;
    
    if (nextSlide < 1) {
      goToSlide(totalSlides); // Wrap to last
    } else if (nextSlide > totalSlides) {
      goToSlide(1); // Wrap to first
    } else {
      goToSlide(nextSlide);
    }
  }

  /**
   * Go to specific slide
   */
  function goToSlide(slideNumber) {
    if (slideNumber === currentSlide || currentState !== 'landing') return;
    
    // Remove active class from current slide and indicator
    slides[currentSlide - 1].classList.remove('intro-module__slide--active');
    indicators[currentSlide - 1].classList.remove('intro-module__indicator--active');
    
    // Add active class to new slide and indicator
    currentSlide = slideNumber;
    slides[currentSlide - 1].classList.add('intro-module__slide--active');
    indicators[currentSlide - 1].classList.add('intro-module__indicator--active');
  }

  /**
   * Setup touch swipe for slideshow
   */
  function setupTouchSwipe() {
    if (!slideshow) return;
    
    let touchStartX = 0;
    let touchEndX = 0;
    
    slideshow.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    slideshow.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;
      
      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          navigateSlide(1); // Swipe left - next slide
        } else {
          navigateSlide(-1); // Swipe right - previous slide
        }
      }
    }
  }

  /**
   * Setup keyboard navigation
   */
  function setupKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
      if (currentState !== 'landing') return;
      
      switch(e.key) {
        case 'ArrowLeft':
          navigateSlide(-1);
          break;
        case 'ArrowRight':
          navigateSlide(1);
          break;
        case 'ArrowDown':
        case 'PageDown':
          if (!hasTransitioned) {
            triggerTransition();
          }
          break;
      }
    });
  }

  /**
   * Setup scroll detection
   */
  function setupScrollDetection() {
    let scrollAmount = 0;
    
    window.addEventListener('scroll', () => {
      if (hasTransitioned || isTransitioning) return;
      
      scrollAmount = window.scrollY || window.pageYOffset;
      
      // Low threshold trigger
      if (scrollAmount >= SCROLL_THRESHOLD) {
        triggerTransition();
      }
    }, { passive: true });

    // Also use IntersectionObserver as backup
    if ('IntersectionObserver' in window && scrollTrigger) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting && !hasTransitioned && !isTransitioning) {
            triggerTransition();
          }
        });
      }, {
        threshold: 0.99 // Trigger when 99% is out of view
      });
      
      observer.observe(scrollTrigger);
    }
  }

  /**
   * Stage 2: Transition - Hide slideshow, play animation2
   */
  function triggerTransition() {
    if (hasTransitioned || isTransitioning) return;
    
    isTransitioning = true;
    currentState = 'transition';
    
    console.log('IntroModule: Triggering transition');
    
    // Hide slideshow immediately
    if (slideshow) {
      slideshow.classList.add('intro-module__slideshow--hidden');
    }
    
    // Fade out animation1
    animation1.classList.remove('intro-module__video--active');
    
    // Small delay, then start animation2
    setTimeout(() => {
      animation2.classList.add('intro-module__video--active');
      
      const playPromise = animation2.play();
      
      if (playPromise !== undefined) {
        playPromise
          .then(() => {
            console.log('IntroModule: Animation2 playing');
          })
          .catch(error => {
            console.error('IntroModule: Animation2 play failed:', error);
            // Fallback to animation3 if animation2 fails
            transitionToLoopStage();
          });
      }
    }, 300);
  }

  /**
   * Stage 3: Loop - Play animation3 on loop
   */
  function transitionToLoopStage() {
    currentState = 'loop';
    hasTransitioned = true;
    isTransitioning = false;
    
    console.log('IntroModule: Transitioning to loop stage');
    
    // Fade out animation2
    animation2.classList.remove('intro-module__video--active');
    
    // Small delay, then start animation3
    setTimeout(() => {
      animation3.classList.add('intro-module__video--active');
      
      const playPromise = animation3.play();
      
      if (playPromise !== undefined) {
        playPromise
          .then(() => {
            console.log('IntroModule: Animation3 looping');
          })
          .catch(error => {
            console.error('IntroModule: Animation3 play failed:', error);
          });
      }
    }, 300);
    
    // CRITICAL: Dispatch event to notify navigation module
    setTimeout(() => {
      document.dispatchEvent(new CustomEvent('introTransitionComplete'));
      console.log('IntroModule: Dispatched introTransitionComplete event');
    }, 800); // Give animation3 time to start
  }

  // Public API
  return {
    init
  };
})();

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', IntroModule.init);
} else {
  IntroModule.init();
}

// Expose to window
window.IntroModule = IntroModule;