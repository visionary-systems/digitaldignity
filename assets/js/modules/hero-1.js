/**
 * Hero-1 Module JavaScript
 */

const Hero1Module = (function() {
  function init() {
    const hero = document.querySelector('.hero-1');
    if (!hero) return;
    
    // Add interactive effects here
    console.log('Hero-1 module initialized');
    
    // Example: Parallax effect on scroll
    window.addEventListener('scroll', function() {
      const scrolled = window.pageYOffset;
      const background = hero.querySelector('.hero-1__background');
      if (background) {
        background.style.transform = `translateY(${scrolled * 0.5}px)`;
      }
    });
  }
  
  return { init };
})();

// TEMPLATE: Expand with actual hero functionality