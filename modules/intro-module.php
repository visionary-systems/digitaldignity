<!-- Intro Module: Landing Animation & Transition -->
<section class="intro-module" id="introModule">
  <!-- Stage 1: Landing Animation (plays once, then static/loops) -->
  <video 
    id="animation1"
    class="intro-module__video intro-module__video--active"
    poster="/assets/videos/animation1-poster.jpg"
    preload="metadata"
    muted
    playsinline>
    <source src="/assets/videos/animation1.mp4" type="video/mp4">
  </video>

  <!-- Stage 2: Transition Animation (PRIORITY LOAD - no poster needed) -->
  <video 
    id="animation2"
    class="intro-module__video"
    preload="auto"
    muted
    playsinline>
    <source src="/assets/videos/animation2.mp4" type="video/mp4">
  </video>

  <!-- Stage 3: Looping Animation -->
  <video 
    id="animation3"
    class="intro-module__video"
    poster="/assets/videos/animation3-poster.jpg"
    preload="metadata"
    muted
    loop
    playsinline>
    <source src="/assets/videos/animation3.mp4" type="video/mp4">
  </video>

  <!-- Slideshow Overlay (Stage 1 only) -->
  <div class="intro-module__slideshow" id="introSlideshow">
    <div class="intro-module__slideshow-container">
      
      <!-- Slide 1 (Active by default) -->
      <div class="intro-module__slide intro-module__slide--active" data-slide="1">
        <div class="intro-module__slide-content">
          <h1 class="intro-module__headline">Your Data.<br>Your Property.</h1>
          <p class="intro-module__subhead">Transform your personal data into intellectual property</p>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="intro-module__slide" data-slide="2">
        <div class="intro-module__slide-content">
          <h1 class="intro-module__headline">Data as<br>Universal Basic Income</h1>
          <p class="intro-module__subhead">Earn from your digital footprint</p>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="intro-module__slide" data-slide="3">
        <div class="intro-module__slide-content">
          <h1 class="intro-module__headline">Join the<br>Movement</h1>
          <p class="intro-module__subhead">20 million followers can change everything</p>
        </div>
      </div>

      <!-- Navigation Controls -->
      <div class="intro-module__controls">
        <button class="intro-module__arrow intro-module__arrow--prev" id="prevSlide" aria-label="Previous slide">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        
        <div class="intro-module__indicators">
          <button class="intro-module__indicator intro-module__indicator--active" data-slide="1" aria-label="Slide 1"></button>
          <button class="intro-module__indicator" data-slide="2" aria-label="Slide 2"></button>
          <button class="intro-module__indicator" data-slide="3" aria-label="Slide 3"></button>
        </div>
        
        <button class="intro-module__arrow intro-module__arrow--next" id="nextSlide" aria-label="Next slide">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="intro-module__scroll-hint">
      <span>Scroll to continue</span>
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M10 5V15M10 15L5 10M10 15L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
  </div>

  <!-- Scroll Detection Trigger (invisible element) -->
  <div class="intro-module__scroll-trigger" id="scrollTrigger"></div>
</section>