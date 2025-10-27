/**
 * Digital Dignity - Main JavaScript
 * Initialize all modules and set up global functionality
 */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('Digital Dignity initialized');
  
  // Initialize modules
  if (typeof NavigationModule !== 'undefined') NavigationModule.init();
  if (typeof IntroAnimationModule !== 'undefined') IntroAnimationModule.init();
  if (typeof Hero1Module !== 'undefined') Hero1Module.init();
  
  // Add more module initializations as needed
});

// Global utility functions
const DD = {
  // Smooth scroll to element
  scrollTo: function(selector) {
    const element = document.querySelector(selector);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  },
  
  // Add more global utilities as needed
};

// Make DD available globally
window.DD = DD;
