<?php
/**
 * Navigation Module
 * Glassmorphic floating navigation with dropdown and mobile menu
 */
?>
<div class="navigation">
  <div class="navigation__container">
    <div class="navigation__wrapper">
      <div class="navigation__background"></div>
      
      <div class="navigation__content">
        <div class="navigation__left">
          <a href="/" class="navigation__logo-link">
            <svg class="navigation__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 123.05 108.17">
              <style>
                .navigation__logo-fill {
                  fill: #ffffff;
                  transition: fill 0.3s ease;
                }
              </style>
              <g>
                <path class="navigation__logo-fill" d="M8.98,105.13c0-2.04.23-2.38.91-2.5l3.86-.79c1.13-.23,1.36-.45,1.36-1.59v-29.83c0-1.13-.23-1.25-1.36-1.47l-3.86-.68c-.68-.11-.91-.34-.91-2.16,0-1.7.23-1.93.91-2.16,9.3-3.63,19.39-9.41,28.47-15.65.34-.23.57-.34.91-.34.79,0,2.95.91,2.95,1.7,0,1.93-.91,9.64-.91,23.59v26.99c0,1.13.23,1.36,1.36,1.59l3.86.79c.68.11.91.45.91,2.5s-.23,2.38-.91,2.38c-2.61,0-9.98-.79-18.26-.79s-15.88.79-18.38.79c-.68,0-.91-.34-.91-2.38ZM16.7,29.81c0-7.37,5.44-13.04,13.04-13.04s13.04,5.67,13.04,13.04-5.45,13.04-13.04,13.04-13.04-5.67-13.04-13.04Z"/>
                <path class="navigation__logo-fill" d="M63.96,0c-6.04,0-22.84,1.03-28.74,1.03h-3.1C18.42,1.03,4.57,0,1.18,0,.3,0,0,.44,0,3.09s.3,3.09,1.18,3.24l3.2.51.65.1,21.12,1.06c2.16.11,4.33.11,6.49,0l16.73-.8h.59c5.45,0,10.02,1.62,15.92,7.52,10.32,10.32,15.92,27.26,15.92,50.4,0,18.72-8.84,35.81-26.08,35.81,0,0-13.98-1.03-21.03-1.56-6.57-.49-26.52,1.49-29.16,1.75l-4.33.69c-.88.15-1.18.59-1.18,3.24s.3,3.09,1.18,3.09c3.39,0,11.94-1.03,31.54-1.03h2.21c10.32,0,20.34,1.03,29.03,1.03,29.03,0,59.09-17.83,59.09-54.23C123.05,23.28,101.39,0,63.96,0Z"/>
              </g>
            </svg>
          </a>
          
          <div class="navigation__about-section" id="aboutSection">
            <span class="navigation__about-link">About</span>
            <svg class="navigation__arrow" id="arrowHover" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.1 23.12">
              <path class="navigation__arrow-fill" d="M.42,8.02C1.73,4.94,3.69,2.33,7.01.99c.63-.26,1.39-.63,2.21-.78,8.17-1.53,15.2,5.52,13.68,13.68-.63,3.36-3.13,6.49-6.34,8.05C7.79,26.18-2.05,18.43.37,8.74c.06-.23-.05-.47.05-.72ZM8.16,17.44h2.99c.21,0,.99-.73,1.17-.94.91-1.05,1.98-2.53,2.8-3.67.1-.14.46-.36.49-.44.65-1.39-.62-2.19-1.33-3.12-.84-1.1-1.65-2.41-2.74-3.28-.05-.04-.05-.15-.05-.22h-3.34l4.46,5.9c-.02.23-.63.61-.79.82-.89,1.15-1.72,2.37-2.62,3.51-.36.45-1.04.73-1.05,1.44Z"/>
            </svg>
          </div>
        </div>
        
        <div class="navigation__right">
          <?php if (isLoggedIn()): ?>
            <a href="/dashboard/" class="navigation__join-button">Dashboard</a>
          <?php else: ?>
            <a href="/register.php" class="navigation__join-button">Join</a>
          <?php endif; ?>
        </div>
        
        <div class="navigation__hamburger" id="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      
      <div class="navigation__submenu-wrapper">
        <div class="navigation__submenu" id="submenu">
          <div class="navigation__submenu-item">
            <a href="/community.php" class="navigation__submenu-link">Community</a>
          </div>
          <div class="navigation__submenu-item">
            <a href="/founders.php" class="navigation__submenu-link">Founders</a>
          </div>
          <div class="navigation__submenu-item">
            <a href="/mission.php" class="navigation__submenu-link">Mission</a>
          </div>
          <div class="navigation__submenu-item">
            <a href="/roadmap.php" class="navigation__submenu-link">Road Map</a>
          </div>
          <div class="navigation__submenu-item">
            <a href="/sponsors.php" class="navigation__submenu-link">Sponsors</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="navigation__mobile-menu" id="mobileMenu">
      <div class="navigation__mobile-menu-item">
        <span class="navigation__mobile-menu-link">About</span>
      </div>
      <div class="navigation__mobile-submenu-item">
        <a href="/community.php" class="navigation__mobile-submenu-link">Community</a>
      </div>
      <div class="navigation__mobile-submenu-item">
        <a href="/founders.php" class="navigation__mobile-submenu-link">Founders</a>
      </div>
      <div class="navigation__mobile-submenu-item">
        <a href="/mission.php" class="navigation__mobile-submenu-link">Mission</a>
      </div>
      <div class="navigation__mobile-submenu-item">
        <a href="/roadmap.php" class="navigation__mobile-submenu-link">Road Map</a>
      </div>
      <div class="navigation__mobile-submenu-item">
        <a href="/sponsors.php" class="navigation__mobile-submenu-link">Sponsors</a>
      </div>
      <div class="navigation__mobile-join">
        <?php if (isLoggedIn()): ?>
          <a href="/dashboard/" class="navigation__join-button">Dashboard</a>
        <?php else: ?>
          <a href="/register.php" class="navigation__join-button">Join</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>