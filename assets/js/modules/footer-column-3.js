/**
 * Footer Column 3 - Interactive Poll Module
 * Location: /assets/js/modules/footer-column-3.js
 * 
 * Module Pattern (IIFE) - Self-contained, auto-initializing
 */

const FooterColumn3Module = (function() {
  // Private variables
  let slider = null;
  let valueDisplay = null;
  let voteBtn = null;
  let backBtn = null;
  let pollContainer = null;
  let resultsContainer = null;
  let currentValue = 0;
  
  // Vote storage key
  const STORAGE_KEY = 'dd_poll_votes';
  
  /**
   * Initialize the module
   */
  function init() {
    console.log('FooterColumn3Module: Initializing...');
    
    // Get DOM elements
    slider = document.getElementById('pollSlider');
    valueDisplay = document.getElementById('valueDisplay');
    voteBtn = document.getElementById('voteBtn');
    backBtn = document.getElementById('backBtn');
    pollContainer = document.getElementById('pollContainer');
    resultsContainer = document.getElementById('resultsContainer');
    
    console.log('FooterColumn3Module: Elements found:', {
      slider: !!slider,
      valueDisplay: !!valueDisplay,
      voteBtn: !!voteBtn
    });
    
    // Check if elements exist (module might not be on this page)
    if (!slider || !valueDisplay || !voteBtn) {
      console.log('FooterColumn3Module: Required elements not found, skipping initialization');
      return;
    }
    
    // Set initial value
    updateValueDisplay();
    console.log('FooterColumn3Module: Initial value set');
    
    // Attach event listeners - use both 'input' and 'change' for better compatibility
    slider.addEventListener('input', function(e) {
      console.log('Slider input event:', e.target.value);
      handleSliderChange(e);
    });
    slider.addEventListener('change', function(e) {
      console.log('Slider change event:', e.target.value);
      handleSliderChange(e);
    });
    
    voteBtn.addEventListener('click', handleVote);
    
    if (backBtn) {
      backBtn.addEventListener('click', handleBackToVote);
    }
    
    // Check if user has already voted
    checkExistingVote();
    
    console.log('FooterColumn3Module: Initialization complete');
  }
  
  /**
   * Handle slider value change
   */
  function handleSliderChange(event) {
    console.log('handleSliderChange called with value:', slider.value);
    updateValueDisplay();
  }
  
  /**
   * Update the value display
   */
  function updateValueDisplay() {
    if (!slider || !valueDisplay) {
      console.log('updateValueDisplay: slider or valueDisplay not found');
      return;
    }
    
    // Convert slider value (-100 to 100) to display value (-10.0 to 10.0)
    const sliderValue = parseFloat(slider.value);
    currentValue = (sliderValue / 10).toFixed(1);
    valueDisplay.textContent = currentValue;
    
    console.log('Value updated:', {
      sliderValue: sliderValue,
      displayValue: currentValue
    });
  }
  
  /**
   * Handle vote submission
   */
  function handleVote() {
    // Add pulse animation to button
    voteBtn.style.transform = 'scale(0.95)';
    setTimeout(() => {
      voteBtn.style.transform = 'scale(1)';
    }, 100);
    
    // Store the vote
    storeVote(parseFloat(currentValue));
    
    // Show results after brief delay
    setTimeout(() => {
      showResults();
    }, 300);
  }
  
  /**
   * Store vote in localStorage
   * In production, this would be sent to Supabase
   */
  function storeVote(value) {
    let votes = getStoredVotes();
    votes.push(value);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(votes));
  }
  
  /**
   * Get all stored votes
   */
  function getStoredVotes() {
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored ? JSON.parse(stored) : [];
  }
  
  /**
   * Check if user has already voted
   */
  function checkExistingVote() {
    const votes = getStoredVotes();
    if (votes.length > 0) {
      // User has voted before, but allow them to vote again
      // You could modify this to only allow one vote
    }
  }
  
  /**
   * Show results view
   */
  function showResults() {
    // Hide poll container
    pollContainer.style.display = 'none';
    
    // Show results container
    resultsContainer.style.display = 'flex';
    
    // Populate results
    displayResults();
  }
  
  /**
   * Display results data
   */
  function displayResults() {
    const votes = getStoredVotes();
    const userVote = votes[votes.length - 1]; // Most recent vote
    
    // Calculate statistics
    const total = votes.length;
    const sum = votes.reduce((acc, vote) => acc + vote, 0);
    const average = total > 0 ? (sum / total).toFixed(1) : '0.0';
    
    // Update statistics
    document.getElementById('userVoteValue').textContent = userVote.toFixed(1);
    document.getElementById('avgVoteValue').textContent = average;
    document.getElementById('totalVotes').textContent = total;
    
    // Create distribution visualization
    createDistribution(votes);
  }
  
  /**
   * Create distribution bar chart
   */
  function createDistribution(votes) {
    const distributionBar = document.getElementById('distributionBar');
    distributionBar.innerHTML = ''; // Clear existing
    
    // Create 10 buckets from -10 to 10
    const buckets = new Array(10).fill(0);
    
    // Distribute votes into buckets
    votes.forEach(vote => {
      const bucketIndex = Math.floor((vote + 10) / 2);
      const clampedIndex = Math.max(0, Math.min(9, bucketIndex));
      buckets[clampedIndex]++;
    });
    
    // Find max bucket count for scaling
    const maxCount = Math.max(...buckets, 1);
    
    // Create segments
    buckets.forEach((count, index) => {
      const segment = document.createElement('div');
      segment.className = 'footer-column-3__distribution-segment';
      
      // Calculate height as percentage
      const heightPercent = (count / maxCount) * 100;
      segment.style.height = `${heightPercent}%`;
      
      // Color gradient based on position
      const colors = [
        '#0066ff', // Blue
        '#00ccff', // Cyan
        '#00ff88', // Green
        '#88ff00', // Yellow-green
        '#ffff00', // Yellow
        '#ffcc00', // Yellow-orange
        '#ff8800', // Orange
        '#ff4400', // Red-orange
        '#ff0000', // Red
        '#ff0000'  // Red
      ];
      segment.style.background = colors[index];
      
      // Tooltip (optional)
      segment.title = `Votes: ${count}`;
      
      distributionBar.appendChild(segment);
    });
  }
  
  /**
   * Handle back to vote
   */
  function handleBackToVote() {
    // Reset slider to center
    slider.value = 0;
    updateValueDisplay();
    
    // Hide results
    resultsContainer.style.display = 'none';
    
    // Show poll
    pollContainer.style.display = 'flex';
  }
  
  /**
   * Update display with a specific value (public method for inline handlers)
   */
  function updateDisplay(value) {
    console.log('updateDisplay called with:', value);
    if (valueDisplay) {
      const displayValue = (parseFloat(value) / 10).toFixed(1);
      valueDisplay.textContent = displayValue;
      currentValue = displayValue;
      console.log('Display updated to:', displayValue);
    }
  }
  
  /**
   * Get slider element (for debugging)
   */
  function getSlider() {
    return slider;
  }
  
  /**
   * Public API
   */
  return {
    init: init,
    getStoredVotes: getStoredVotes,
    getSlider: getSlider,
    updateDisplay: updateDisplay
  };
})();

// Expose to window for inline handlers
window.FooterColumn3Module = FooterColumn3Module;

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - initializing FooterColumn3Module');
    FooterColumn3Module.init();
  });
} else {
  console.log('DOM already loaded - initializing FooterColumn3Module immediately');
  FooterColumn3Module.init();
}

// Also try initializing after a short delay as a fallback
setTimeout(function() {
  if (document.getElementById('pollSlider') && typeof FooterColumn3Module !== 'undefined') {
    console.log('Fallback initialization check');
    // Only reinit if slider exists but module hasn't captured it
    if (!FooterColumn3Module.getSlider()) {
      console.log('Slider found but not initialized, attempting reinitialization');
      FooterColumn3Module.init();
    }
  }
}, 500);