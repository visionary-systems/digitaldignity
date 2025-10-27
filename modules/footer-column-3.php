<?php
/**
 * Footer Column 3 - Interactive Poll Module
 * Location: /modules/footer-column-3.php
 */
?>

<div class="footer-column-3">
  <div class="footer-column-3__content">
    
    <!-- Poll Container (shown initially) -->
    <div class="footer-column-3__poll-container" id="pollContainer">
      
      <!-- Title Section -->
      <div class="footer-column-3__header">
        <div class="footer-column-3__title-wrapper">
          <span class="footer-column-3__poll-label">POLL</span>
          <h3 class="footer-column-3__title">Do You Care About Owning Your Data?</h3>
        </div>
      </div>

      <!-- Gradient Slider Section -->
      <div class="footer-column-3__slider-section">
        <!-- Gradient Line -->
        <div class="footer-column-3__gradient-line"></div>
        
        <!-- Slider -->
        <input 
          type="range" 
          min="-100" 
          max="100" 
          value="0" 
          step="1"
          class="footer-column-3__slider" 
          id="pollSlider"
          aria-label="Poll slider from -10.0 to 10.0"
          oninput="if(window.FooterColumn3Module && window.FooterColumn3Module.updateDisplay) window.FooterColumn3Module.updateDisplay(this.value)"
        >
      </div>
        
      <!-- Value Display and Vote Button on Same Line -->
      <div class="footer-column-3__vote-section">
        <div class="footer-column-3__value-display" id="valueDisplay">0.0</div>
        <button class="footer-column-3__vote-btn" id="voteBtn">
          VOTE
        </button>
      </div>

      <!-- Text Content -->
      <div class="footer-column-3__text-content">
        <p class="footer-column-3__text">
          <strong>Stop being the product and start sending a message!</strong> 
          Discover a new way forward as a data aggregating hero! Take your attention public or keep it private! Share your data on your own terms.
        </p>
      </div>

      <!-- Logo Bug -->
      <div class="footer-column-3__logo">
        <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 69.99 61.52">
          <defs>
            <style>
              .cls-1 {
                fill: #231f20;
              }
            </style>
          </defs>
          <g id="Layer_1-2" data-name="Layer 1">
            <g>
              <path class="cls-1" d="M5.11,59.79c0-1.16.13-1.35.52-1.42l2.19-.45c.64-.13.77-.26.77-.9v-16.97c0-.65-.13-.71-.77-.84l-2.19-.39c-.39-.06-.52-.19-.52-1.23,0-.97.13-1.1.52-1.23,5.29-2.06,11.03-5.35,16.19-8.9.19-.13.32-.19.52-.19.45,0,1.68.52,1.68.97,0,1.1-.52,5.48-.52,13.42v15.35c0,.65.13.77.77.9l2.19.45c.39.06.52.26.52,1.42s-.13,1.35-.52,1.35c-1.48,0-5.68-.45-10.39-.45s-9.03.45-10.45.45c-.39,0-.52-.19-.52-1.35ZM9.5,16.96c0-4.19,3.1-7.42,7.42-7.42s7.42,3.23,7.42,7.42-3.1,7.42-7.42,7.42-7.42-3.23-7.42-7.42Z"/>
              <path class="cls-1" d="M36.38,0c-3.44,0-12.99.59-16.34.59h-1.76C10.48.59,2.6,0,.67,0,.17,0,0,.25,0,1.76s.17,1.76.67,1.84l1.82.29.37.06,12.01.6c1.23.06,2.46.06,3.69,0l9.51-.46h.34c3.1,0,5.7.92,9.05,4.27,5.87,5.87,9.05,15.51,9.05,28.67,0,10.65-5.03,20.37-14.84,20.37,0,0-7.95-.59-11.96-.89-3.74-.28-15.09.85-16.59,1l-2.47.39c-.5.08-.67.34-.67,1.84s.17,1.76.67,1.76c1.93,0,6.79-.59,17.94-.59h1.26c5.87,0,11.57.59,16.51.59,16.51,0,33.61-10.14,33.61-30.84C69.99,13.24,57.67,0,36.38,0Z"/>
            </g>
          </g>
        </svg>
      </div>
    </div>

    <!-- Results Container (shown after voting) -->
    <div class="footer-column-3__results-container" id="resultsContainer" style="display: none;">
      
      <!-- Results Header -->
      <div class="footer-column-3__results-header">
        <div class="footer-column-3__title-wrapper">
          <span class="footer-column-3__poll-label">POLL RESULTS</span>
          <h3 class="footer-column-3__title">Do You Care About Owning Your Data?</h3>
        </div>
      </div>

      <!-- Statistics -->
      <div class="footer-column-3__stats">
        <div class="footer-column-3__stat-item">
          <span class="footer-column-3__stat-label">Your Vote:</span>
          <span class="footer-column-3__stat-value" id="userVoteValue">0.0</span>
        </div>
        <div class="footer-column-3__stat-item">
          <span class="footer-column-3__stat-label">Average:</span>
          <span class="footer-column-3__stat-value" id="avgVoteValue">0.0</span>
        </div>
        <div class="footer-column-3__stat-item">
          <span class="footer-column-3__stat-label">Total Votes:</span>
          <span class="footer-column-3__stat-value" id="totalVotes">0</span>
        </div>
      </div>

      <!-- Distribution Visualization -->
      <div class="footer-column-3__distribution">
        <div class="footer-column-3__distribution-bar" id="distributionBar">
          <!-- Distribution segments will be added by JavaScript -->
        </div>
        <div class="footer-column-3__distribution-labels">
          <span>-10.0</span>
          <span>0.0</span>
          <span>+10.0</span>
        </div>
      </div>

      <!-- Back Button -->
      <button class="footer-column-3__back-btn" id="backBtn">
        VOTE AGAIN
      </button>

      <!-- Logo Bug -->
      <div class="footer-column-3__logo">
        <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 69.99 61.52">
          <defs>
            <style>
              .cls-1 {
                fill: #231f20;
              }
            </style>
          </defs>
          <g id="Layer_1-2" data-name="Layer 1">
            <g>
              <path class="cls-1" d="M5.11,59.79c0-1.16.13-1.35.52-1.42l2.19-.45c.64-.13.77-.26.77-.9v-16.97c0-.65-.13-.71-.77-.84l-2.19-.39c-.39-.06-.52-.19-.52-1.23,0-.97.13-1.1.52-1.23,5.29-2.06,11.03-5.35,16.19-8.9.19-.13.32-.19.52-.19.45,0,1.68.52,1.68.97,0,1.1-.52,5.48-.52,13.42v15.35c0,.65.13.77.77.9l2.19.45c.39.06.52.26.52,1.42s-.13,1.35-.52,1.35c-1.48,0-5.68-.45-10.39-.45s-9.03.45-10.45.45c-.39,0-.52-.19-.52-1.35ZM9.5,16.96c0-4.19,3.1-7.42,7.42-7.42s7.42,3.23,7.42,7.42-3.1,7.42-7.42,7.42-7.42-3.23-7.42-7.42Z"/>
              <path class="cls-1" d="M36.38,0c-3.44,0-12.99.59-16.34.59h-1.76C10.48.59,2.6,0,.67,0,.17,0,0,.25,0,1.76s.17,1.76.67,1.84l1.82.29.37.06,12.01.6c1.23.06,2.46.06,3.69,0l9.51-.46h.34c3.1,0,5.7.92,9.05,4.27,5.87,5.87,9.05,15.51,9.05,28.67,0,10.65-5.03,20.37-14.84,20.37,0,0-7.95-.59-11.96-.89-3.74-.28-15.09.85-16.59,1l-2.47.39c-.5.08-.67.34-.67,1.84s.17,1.76.67,1.76c1.93,0,6.79-.59,17.94-.59h1.26c5.87,0,11.57.59,16.51.59,16.51,0,33.61-10.14,33.61-30.84C69.99,13.24,57.67,0,36.38,0Z"/>
            </g>
          </g>
        </svg>
      </div>
    </div>

  </div>

</div>

<!-- Copyright (outside container) -->
<div class="footer-column-3__copyright">
  © 2025 DigitalDignity.org
</div>