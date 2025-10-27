/**
 * Intro Animation Module JavaScript
 * Handles sound effects and fade-out timing
 */

const IntroAnimationModule = (function() {
  let audioStarted = false;
  
  async function startAudio() {
    if (!audioStarted && typeof Tone !== 'undefined') {
      try {
        await Tone.start();
        audioStarted = true;
        playAnimationSounds();
      } catch (error) {
        console.log('Audio could not be started:', error);
      }
    }
  }
  
function playAnimationSounds() {
  const synth = new Tone.Synth({
    oscillator: { type: 'sine' },
    envelope: { attack: 0.05, decay: 0.2, sustain: 0.1, release: 0.3 }
  }).toDestination();
  
  // Reduce volume by 25% (from 0dB to -6dB)
  synth.volume.value = -6;

  // 1. Dot drop sound
  setTimeout(() => {
    synth.triggerAttackRelease('G5', '0.3s');
    setTimeout(() => synth.triggerAttackRelease('C5', '0.2s'), 150);
  }, 0);

  // 2. Stem rise sound
  setTimeout(() => {
    synth.triggerAttackRelease('C4', '0.15s');
    setTimeout(() => synth.triggerAttackRelease('E4', '0.15s'), 100);
    setTimeout(() => synth.triggerAttackRelease('G4', '0.2s'), 200);
  }, 400);

  // 3. D curve sweep
  setTimeout(() => {
    const sweep = new Tone.Synth({
      oscillator: { type: 'triangle' },
      envelope: { attack: 0.1, decay: 0.3, sustain: 0.2, release: 0.4 }
    }).toDestination();
    
    sweep.volume.value = -6;  // ADD THIS LINE
    
    sweep.triggerAttack('E4');
    setTimeout(() => sweep.frequency.rampTo('A4', 0.6), 0);
    setTimeout(() => sweep.triggerRelease(), 800);
  }, 800);

  // 4. Company name chime
  setTimeout(() => {
    const chime = new Tone.PolySynth(Tone.Synth, {
      oscillator: { type: 'sine' },
      envelope: { attack: 0.02, decay: 0.3, sustain: 0.0, release: 0.5 }
    }).toDestination();
    
    chime.volume.value = -6;  // ADD THIS LINE
    
    chime.triggerAttackRelease(['C5', 'E5', 'G5'], '0.6s');
  }, 2000);

  // 5. Fade out sound (already has volume at -10, change to -16)
  setTimeout(() => {
    const fadeSound = new Tone.Synth({
      oscillator: { type: 'sine' },
      envelope: { attack: 0.1, decay: 0.5, sustain: 0.0, release: 0.8 }
    }).toDestination();
    
    fadeSound.volume.value = -16;  // CHANGE FROM -10
    fadeSound.triggerAttackRelease('A4', '0.8s');
  }, 3500);
}
  
  function setupFadeOut() {
    const introScreen = document.getElementById('introScreen');
    
    if (!introScreen) return;
    
    // Start fade out after 3.5 seconds
    setTimeout(() => {
      introScreen.classList.add('fade-out');
      
      // Remove intro screen from DOM after transition completes
      setTimeout(() => {
        introScreen.style.display = 'none';
      }, 800);
    }, 3500);
  }
  
  function init() {
    const introScreen = document.getElementById('introScreen');
    
    if (!introScreen) return;
    
    // Start audio on first user interaction
    document.addEventListener('click', startAudio, { once: true });
    document.addEventListener('keydown', startAudio, { once: true });
    
    // Auto-start after a brief delay (browsers may block this)
    setTimeout(() => {
      if (!audioStarted) {
        startAudio();
      }
    }, 100);
    
    // Setup the fade-out sequence
    setupFadeOut();
  }
  
  return { init };
})();
