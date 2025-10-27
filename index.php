<?php
/**
 * Home Page - Digital Dignity
 */

require_once 'config/supabase.php';
require_once 'config/auth.php';

$pageTitle = "Digital Dignity - Your Data, Your Rights, Your Future";
$pageClass = "page-home";
$modules = [
  'intro-module',    // NEW: Intro with videos and slideshow
  'navigation',
  'hero-1',
  'footer-1'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <meta name="description" content="Digital Dignity - Join 20 million people demanding data ownership. Tech giants make $1,089/year from your data. Time to claim your share.">
  
  <!-- Animated Favicon -->
  <link rel="icon" href="data:image/svg+xml,<svg viewBox='0 0 123.05 108.17' xmlns='http://www.w3.org/2000/svg'><defs><style>@keyframes colorShift{0%{fill:%23667eea}25%{fill:%23764ba2}50%{fill:%23f093fb}75%{fill:%234facfe}100%{fill:%23667eea}}.shift-path{animation:colorShift 6s ease-in-out infinite}</style></defs><g><path class='shift-path' d='M8.98,105.13c0-2.04.23-2.38.91-2.5l3.86-.79c1.13-.23,1.36-.45,1.36-1.59v-29.83c0-1.13-.23-1.25-1.36-1.47l-3.86-.68c-.68-.11-.91-.34-.91-2.16,0-1.7.23-1.93.91-2.16,9.3-3.63,19.39-9.41,28.47-15.65.34-.23.57-.34.91-.34.79,0,2.95.91,2.95,1.7,0,1.93-.91,9.64-.91,23.59v26.99c0,1.13.23,1.36,1.36,1.59l3.86.79c.68.11.91.45.91,2.5s-.23,2.38-.91,2.38c-2.61,0-9.98-.79-18.26-.79s-15.88.79-18.38.79c-.68,0-.91-.34-.91-2.38ZM16.7,29.81c0-7.37,5.44-13.04,13.04-13.04s13.04,5.67,13.04,13.04-5.45,13.04-13.04,13.04-13.04-5.67-13.04-13.04Z'/><path class='shift-path' d='M63.96,0c-6.04,0-22.84,1.03-28.74,1.03h-3.1C18.42,1.03,4.57,0,1.18,0,.3,0,0,.44,0,3.09s.3,3.09,1.18,3.24l3.2.51.65.1,21.12,1.06c2.16.11,4.33.11,6.49,0l16.73-.8h.59c5.45,0,10.02,1.62,15.92,7.52,10.32,10.32,15.92,27.26,15.92,50.4,0,18.72-8.84,35.81-26.08,35.81,0,0-13.98-1.03-21.03-1.56-6.57-.49-26.52,1.49-29.16,1.75l-4.33.69c-.88.15-1.18.59-1.18,3.24s.3,3.09,1.18,3.09c3.39,0,11.94-1.03,31.54-1.03h2.21c10.32,0,20.34,1.03,29.03,1.03,29.03,0,59.09-17.83,59.09-54.23C123.05,23.28,101.39,0,63.96,0Z'/></g></svg>">
  
  <!-- Google Fonts: Jost and Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
  
  <!-- Tone.js for sound effects -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.49/Tone.js"></script>
  
  <!-- Main stylesheet -->
  <link rel="stylesheet" href="/assets/css/main.css">
  
  <!-- Page-specific styles (if any) -->
  <?php if(file_exists("assets/css/pages/{$pageClass}.css")): ?>
    <link rel="stylesheet" href="/assets/css/pages/<?php echo $pageClass; ?>.css">
  <?php endif; ?>
  
  <!-- Supabase credentials for client-side JS -->
  <script>
    window.SUPABASE_URL = '<?php echo SUPABASE_URL; ?>';
    window.SUPABASE_ANON_KEY = '<?php echo SUPABASE_ANON_KEY; ?>';
  </script>
</head>
<body class="<?php echo $pageClass; ?>">
  <?php
  foreach($modules as $module) {
    $modulePath = "modules/{$module}.php";
    if (file_exists($modulePath)) {
      include $modulePath;
    } else {
      echo "<!-- Module not found: {$module} -->";
    }
  }
  ?>
  
  <!-- Module JavaScript files -->
  <script src="/assets/js/modules/intro-module.js"></script>
  <script src="/assets/js/modules/navigation.js"></script>
  <script src="/assets/js/modules/footer-column-3.js"></script>

  <!-- Main JavaScript (initializes modules) -->
  <script src="/assets/js/main.js"></script>
  
  <!-- Page-specific JS (if any) -->
  <?php if(file_exists("assets/js/pages/{$pageClass}.js")): ?>
    <script src="/assets/js/pages/<?php echo $pageClass; ?>.js"></script>
  <?php endif; ?>
</body>
</html>