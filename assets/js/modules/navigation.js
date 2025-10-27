/**
 * Navigation Module JavaScript
 * Handles dropdown menu, mobile menu, intro/expanded states, and logo animation
 */

const NavigationModule = (function() {
  // Dropdown state
  let isSubmenuOpen = false;
  let closeTimeout;
  
  // Navigation state (intro/expanded)
  let navState = 'intro';
  let isPlayingLogoAnimation = false;
  
  // DOM elements
  let navigation;
  let logoLink;
  
  function init() {
    // Get DOM elements
    navigation = document.querySelector('.navigation');
    logoLink = document.querySelector('.navigation__logo-link');
    const aboutSection = document.getElementById('aboutSection');
    const arrowHover = document.getElementById('arrowHover');
    const submenu = document.getElementById('submenu');
    const submenuWrapper = document.querySelector('.navigation__submenu-wrapper');
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    
    // Set initial state to intro
    if (navigation) {
      navigation.setAttribute('data-state', 'intro');
    }
    
    // Logo click handler (play animation with sound + scroll to top)
    if (logoLink) {
      setupLogoClickHandler();
    }
    
    // Desktop navigation interactions
    if (aboutSection) {
      setupDesktopNav(aboutSection, arrowHover, submenu, submenuWrapper);
    }
    
    // Mobile menu interactions
    if (hamburger && mobileMenu) {
      setupMobileNav(hamburger, mobileMenu);
    }
    
    // Listen for intro transition complete
    listenForIntroComplete();
    
    // Set active page in submenu
    setActiveSubmenuPage();
  }
  
  /**
   * Setup logo click handler - plays animation with sound and scrolls to top
   */
  function setupLogoClickHandler() {
    logoLink.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Don't trigger if already playing
      if (isPlayingLogoAnimation) return;
      
      // Check if click came from footer (prevent footer clicks)
      const clickedElement = e.target;
      const isInFooter = clickedElement.closest('.footer-1') || 
                         clickedElement.closest('[class*="footer"]');
      
      if (isInFooter) {
        console.log('Click from footer detected, ignoring');
        return;
      }
      
      // Play logo animation with sound
      playLogoAnimationWithSound();
      
      // Scroll to top smoothly
      scrollToTop();
    });
  }
  
  /**
   * Play logo animation (animation1) with sound
   */
  function playLogoAnimationWithSound() {
    const introModule = document.getElementById('introModule');
    const animation1 = document.getElementById('animation1');
    
    if (!animation1) {
      console.log('Animation1 not found, just scrolling to top');
      return;
    }
    
    isPlayingLogoAnimation = true;
    console.log('Playing logo animation with sound');
    
    // If intro module exists, use it
    if (introModule) {
      // Make sure intro module is visible
      const wasHidden = introModule.style.display === 'none';
      if (wasHidden) {
        introModule.style.display = 'block';
        introModule.style.position = 'fixed';
        introModule.style.top = '0';
        introModule.style.left = '0';
        introModule.style.width = '100%';
        introModule.style.height = '100vh';
        introModule.style.zIndex = '9999';
      }
      
      // Hide slideshow during animation
      const slideshow = introModule.querySelector('.intro-module__slideshow');
      if (slideshow) {
        slideshow.style.opacity = '0';
        slideshow.style.pointerEvents = 'none';
      }
      
      // Show animation1 and play WITH SOUND
      animation1.style.opacity = '1';
      animation1.style.zIndex = '2';
      animation1.currentTime = 0;
      animation1.muted = false; // UNMUTE for sound
      animation1.loop = false; // Play once
      
      const playPromise = animation1.play();
      
      if (playPromise !== undefined) {
        playPromise
          .then(() => {
            console.log('Logo animation playing with sound');
          })
          .catch(error => {
            console.warn('Autoplay blocked, trying muted:', error);
            // If blocked, try muted
            animation1.muted = true;
            animation1.play();
          });
      }
      
      // When animation ends, clean up
      animation1.addEventListener('ended', function onAnimationEnd() {
        animation1.removeEventListener('ended', onAnimationEnd);
        
        if (wasHidden) {
          introModule.style.display = 'none';
        }
        
        animation1.style.opacity = '0';
        animation1.muted = true; // Mute again for background
        
        if (slideshow) {
          slideshow.style.opacity = '1';
          slideshow.style.pointerEvents = 'all';
        }
        
        isPlayingLogoAnimation = false;
        console.log('Logo animation complete');
      }, { once: true });
    }
  }
  
  /**
   * Smooth scroll to top
   */
  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
  
  /**
   * Listen for intro transition complete event
   */
  function listenForIntroComplete() {
    // Listen for custom event from intro module
    document.addEventListener('introTransitionComplete', function() {
      expandNavigation();
    });
    
    // Fallback: If no intro module exists, expand immediately
    setTimeout(() => {
      const introModule = document.getElementById('introModule');
      if (!introModule) {
        expandNavigation();
      }
    }, 500);
  }
  
  /**
   * Expand navigation to show full nav (after intro)
   */
  function expandNavigation() {
    if (navState === 'expanded') return;
    
    navState = 'expanded';
    if (navigation) {
      navigation.setAttribute('data-state', 'expanded');
      console.log('Navigation expanded');
    }
  }
  
  /**
   * Setup desktop navigation (existing functionality)
   */
  function setupDesktopNav(aboutSection, arrowHover, submenu, submenuWrapper) {
    // Hover state - show white arrow
    aboutSection.addEventListener('mouseenter', () => {
      clearTimeout(closeTimeout);
      if (arrowHover) {
        arrowHover.style.display = 'block';
      }
    });

    // Click state - rotate arrow, turn orange, show submenu
    aboutSection.addEventListener('click', (e) => {
      e.stopPropagation();
      clearTimeout(closeTimeout);
      
      if (!isSubmenuOpen) {
        isSubmenuOpen = true;
        if (arrowHover) arrowHover.classList.add('active');
        if (submenu) submenu.classList.add('active');
        aboutSection.classList.add('active');
      } else {
        isSubmenuOpen = false;
        if (arrowHover) arrowHover.classList.remove('active');
        if (submenu) submenu.classList.remove('active');
        aboutSection.classList.remove('active');
      }
    });

    // Keep submenu open when hovering over it
    if (submenuWrapper) {
      submenuWrapper.addEventListener('mouseenter', () => {
        clearTimeout(closeTimeout);
        isSubmenuOpen = true;
      });

      // Close when leaving submenu area
      submenuWrapper.addEventListener('mouseleave', () => {
        closeTimeout = setTimeout(() => {
          isSubmenuOpen = false;
          if (arrowHover) {
            arrowHover.classList.remove('active');
            arrowHover.style.display = 'none';
          }
          if (submenu) submenu.classList.remove('active');
          aboutSection.classList.remove('active');
        }, 200);
      });
    }

    // Close when leaving about section (with delay to allow moving to submenu)
    aboutSection.addEventListener('mouseleave', () => {
      closeTimeout = setTimeout(() => {
        if (!isSubmenuOpen && arrowHover) {
          arrowHover.style.display = 'none';
        }
      }, 200);
    });

    // Prevent submenu links from closing the menu immediately
    if (submenu) {
      submenu.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    }
  }
  
  /**
   * Setup mobile navigation (existing functionality)
   */
  function setupMobileNav(hamburger, mobileMenu) {
    // Mobile menu toggle
    hamburger.addEventListener('click', (e) => {
      e.stopPropagation();
      hamburger.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
      }
    });

    // Close mobile menu when clicking a link
    const mobileMenuLinks = mobileMenu.querySelectorAll('a');
    mobileMenuLinks.forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
      });
    });
  }
  
  /**
   * Set active page in submenu based on current URL
   */
  function setActiveSubmenuPage() {
    const currentPath = window.location.pathname;
    const submenuLinks = document.querySelectorAll('.navigation__submenu-link, .navigation__mobile-submenu-link');
    
    submenuLinks.forEach(link => {
      const linkPath = new URL(link.href).pathname;
      
      if (linkPath === currentPath) {
        link.classList.add('active', 'selected');
      } else {
        link.classList.remove('active', 'selected');
      }
    });
  }
  
  // Public API
  return { 
    init,
    expandNavigation
  };
})();

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', NavigationModule.init);
} else {
  NavigationModule.init();
}

// Expose to window
window.NavigationModule = NavigationModule;