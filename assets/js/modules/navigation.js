/**
 * Navigation Module JavaScript
 */

const NavigationModule = (function() {
  let isOpen = false;
  
  function init() {
    const nav = document.querySelector('.navigation');
    if (!nav) return;
    
    const toggle = nav.querySelector('.navigation__toggle');
    const menu = nav.querySelector('.navigation__menu');
    
    if (toggle) {
      toggle.addEventListener('click', function() {
        isOpen = !isOpen;
        menu.classList.toggle('navigation__menu--open', isOpen);
        toggle.classList.toggle('navigation__toggle--active', isOpen);
      });
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (isOpen && !nav.contains(e.target)) {
        isOpen = false;
        menu.classList.remove('navigation__menu--open');
        toggle.classList.remove('navigation__toggle--active');
      }
    });
  }
  
  return { init };
})();

// TEMPLATE: Expand with actual navigation functionality