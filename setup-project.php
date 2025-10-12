<?php
/**
 * Digital Dignity Project Setup Script
 * 
 * This script creates the complete file structure with template files
 * Run once: php setup-project.php
 */

// Color output for terminal
function colorOutput($text, $color = 'green') {
    $colors = [
        'green' => "\033[0;32m",
        'blue' => "\033[0;34m",
        'yellow' => "\033[1;33m",
        'red' => "\033[0;31m",
        'reset' => "\033[0m"
    ];
    return $colors[$color] . $text . $colors['reset'];
}

function createDirectory($path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo colorOutput("✓ Created: $path\n");
    } else {
        echo colorOutput("⊙ Exists: $path\n", 'yellow');
    }
}

function createFile($path, $content) {
    if (!file_exists($path)) {
        file_put_contents($path, $content);
        echo colorOutput("✓ Created: $path\n");
    } else {
        echo colorOutput("⊙ Exists: $path\n", 'yellow');
    }
}

echo colorOutput("\n╔════════════════════════════════════════╗\n", 'blue');
echo colorOutput("║  Digital Dignity Project Setup        ║\n", 'blue');
echo colorOutput("╚════════════════════════════════════════╝\n\n", 'blue');

// ============================================
// DIRECTORY STRUCTURE
// ============================================

$directories = [
    'dashboard',
    'modules',
    'assets/css/modules',
    'assets/css/pages',
    'assets/js/modules',
    'assets/js/pages',
    'assets/images/heroes',
    'assets/images/icons',
    'config'
];

echo colorOutput("Creating directories...\n\n", 'blue');
foreach ($directories as $dir) {
    createDirectory($dir);
}

// ============================================
// CONFIGURATION FILES
// ============================================

echo colorOutput("\nCreating configuration files...\n\n", 'blue');

// .env template
$envContent = <<<ENV
# Supabase Configuration
SUPABASE_URL=your_project_url.supabase.co
SUPABASE_ANON_KEY=your_anon_key_here
SUPABASE_SERVICE_KEY=your_service_key_here

# Environment
ENVIRONMENT=development

# Site Configuration
SITE_URL=http://localhost:8000
SITE_NAME=Digital Dignity
ENV;

createFile('.env', $envContent);

// .gitignore
$gitignoreContent = <<<GITIGNORE
# Environment
.env
.env.local
.env.production

# System Files
.DS_Store
Thumbs.db
desktop.ini

# IDE
.vscode/
.idea/
*.sublime-project
*.sublime-workspace

# Logs
*.log
error_log

# Temporary files
*.tmp
*.temp
*.cache

# Dependencies (if you add them later)
/vendor/
/node_modules/
GITIGNORE;

createFile('.gitignore', $gitignoreContent);

// Supabase config
$supabaseConfig = <<<PHP
<?php
/**
 * Supabase Configuration
 * Load environment variables and set up Supabase connection
 */

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    \$env = parse_ini_file(__DIR__ . '/../.env');
    foreach (\$env as \$key => \$value) {
        \$_ENV[\$key] = \$value;
    }
}

// Supabase constants
define('SUPABASE_URL', \$_ENV['SUPABASE_URL'] ?? '');
define('SUPABASE_ANON_KEY', \$_ENV['SUPABASE_ANON_KEY'] ?? '');
define('SUPABASE_SERVICE_KEY', \$_ENV['SUPABASE_SERVICE_KEY'] ?? '');

// Site constants
define('SITE_URL', \$_ENV['SITE_URL'] ?? 'http://localhost:8000');
define('SITE_NAME', \$_ENV['SITE_NAME'] ?? 'Digital Dignity');
define('ENVIRONMENT', \$_ENV['ENVIRONMENT'] ?? 'development');

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
PHP;

createFile('config/supabase.php', $supabaseConfig);

// Auth helpers
$authConfig = <<<PHP
<?php
/**
 * Authentication Helper Functions
 */

require_once __DIR__ . '/supabase.php';

/**
 * Check if user is logged in
 * This validates the Supabase JWT token
 */
function isLoggedIn() {
    // Check for Supabase auth token in cookie/session
    // This is a placeholder - implement based on your auth strategy
    return isset(\$_COOKIE['sb-access-token']) || isset(\$_SESSION['user_id']);
}

/**
 * Require authentication - redirect to login if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    // Implement based on your session/token strategy
    return \$_SESSION['user_id'] ?? null;
}

/**
 * Redirect if already logged in
 */
function redirectIfLoggedIn(\$destination = '/dashboard/') {
    if (isLoggedIn()) {
        header("Location: \$destination");
        exit;
    }
}
PHP;

createFile('config/auth.php', $authConfig);

// ============================================
// PAGE TEMPLATES
// ============================================

echo colorOutput("\nCreating page templates...\n\n", 'blue');

// Page template generator function
function generatePageTemplate($pageName, $pageTitle, $modules, $protected = false) {
    $configPath = $protected ? '../config' : 'config';
    $modulePrefix = $protected ? '../modules' : 'modules';
    $authCheck = $protected ? "\nrequireLogin(); // Redirect if not logged in\n" : "";
    
    return <<<PHP
<?php
/**
 * {$pageTitle}
 */

require_once '{$configPath}/supabase.php';
require_once '{$configPath}/auth.php';{$authCheck}
\$pageTitle = "{$pageTitle} - Digital Dignity";
\$pageClass = "{$pageName}";
\$modules = [
    '{$modules[0]}',
    '{$modules[1]}',
    '{$modules[2]}'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \$pageTitle; ?></title>
    <meta name="description" content="Digital Dignity - Your data is your intellectual property">
    <link rel="stylesheet" href="/assets/css/main.css">
    <?php if(file_exists("assets/css/pages/{\$pageClass}.css")): ?>
        <link rel="stylesheet" href="/assets/css/pages/<?php echo \$pageClass; ?>.css">
    <?php endif; ?>
</head>
<body class="<?php echo \$pageClass; ?>">
    <?php
    foreach(\$modules as \$module) {
        \$modulePath = "{$modulePrefix}/{\$module}.php";
        if (file_exists(\$modulePath)) {
            include \$modulePath;
        } else {
            echo "<!-- Module not found: {\$module} -->";
        }
    }
    ?>
    
    <script src="/assets/js/main.js"></script>
    <?php if(file_exists("assets/js/pages/{\$pageClass}.js")): ?>
        <script src="/assets/js/pages/<?php echo \$pageClass; ?>.js"></script>
    <?php endif; ?>
</body>
</html>
PHP;
}

// Public pages
$publicPages = [
    ['index', 'Home', ['navigation', 'hero-1', 'footer-1']],
    ['about', 'About', ['navigation', 'header-1', 'footer-1']],
    ['community', 'Community', ['navigation', 'header-1', 'footer-1']],
    ['founders', 'Founders', ['navigation', 'header-1', 'footer-1']],
    ['mission', 'Mission', ['navigation', 'header-1', 'footer-1']],
    ['roadmap', 'Roadmap', ['navigation', 'header-1', 'footer-1']],
    ['sponsors', 'Sponsors', ['navigation', 'header-1', 'footer-1']],
    ['register', 'Register', ['navigation', 'header-2', 'footer-2']],
    ['login', 'Login', ['navigation', 'header-2', 'footer-2']],
    ['privacy', 'Privacy Policy', ['navigation', 'header-2', 'footer-2']],
    ['terms', 'Terms of Service', ['navigation', 'header-2', 'footer-2']],
];

foreach ($publicPages as $page) {
    createFile("{$page[0]}.php", generatePageTemplate($page[0], $page[1], $page[2]));
}

// Dashboard pages (protected)
$dashboardPages = [
    ['index', 'Dashboard', ['navigation', 'content-1', 'footer-1']],
    ['everything', 'The Everything App', ['navigation', 'content-1', 'footer-1']],
    ['atlas', 'Atlas', ['navigation', 'content-1', 'footer-1']],
    ['grail', 'Grail', ['navigation', 'content-1', 'footer-1']],
    ['scout', 'Scout', ['navigation', 'content-1', 'footer-1']],
    ['party-hard-party', 'Party Hard Party', ['navigation', 'content-1', 'footer-1']],
    ['px-protocol', 'PX Protocol', ['navigation', 'content-1', 'footer-1']],
    ['rfdd', 'Run for Digital Dignity', ['navigation', 'content-1', 'footer-1']],
    ['events', 'Events', ['navigation', 'content-1', 'footer-1']],
];

foreach ($dashboardPages as $page) {
    createFile("dashboard/{$page[0]}.php", generatePageTemplate($page[0], $page[1], $page[2], true));
}

// ============================================
// MODULE TEMPLATES
// ============================================

echo colorOutput("\nCreating module templates...\n\n", 'blue');

// Navigation module
$navigationModule = <<<HTML
<?php
/**
 * Navigation Module
 * Floating navigation bar that appears on all pages
 */
?>
<nav class="navigation" data-module="navigation">
    <div class="navigation__container">
        <a href="/" class="navigation__logo">
            <span class="navigation__logo-text">Digital Dignity</span>
        </a>
        
        <button class="navigation__toggle" aria-label="Toggle menu">
            <span class="navigation__toggle-icon"></span>
        </button>
        
        <ul class="navigation__menu">
            <li><a href="/about.php" class="navigation__link">About</a></li>
            <li><a href="/community.php" class="navigation__link">Community</a></li>
            <li><a href="/mission.php" class="navigation__link">Mission</a></li>
            <li><a href="/roadmap.php" class="navigation__link">Roadmap</a></li>
            
            <?php if (isLoggedIn()): ?>
                <li><a href="/dashboard/" class="navigation__link navigation__link--dashboard">Dashboard</a></li>
            <?php else: ?>
                <li><a href="/login.php" class="navigation__link">Login</a></li>
                <li><a href="/register.php" class="navigation__link navigation__link--cta">Get Started</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- TEMPLATE: Replace with actual design -->
HTML;

createFile('modules/navigation.php', $navigationModule);

// Hero-1 module
$hero1Module = <<<HTML
<?php
/**
 * Hero Module 1
 * Primary hero section with holographic effects
 */
?>
<section class="hero-1" data-module="hero-1">
    <div class="hero-1__container">
        <h1 class="hero-1__title">Your Data. Your Rights. Your Future.</h1>
        <p class="hero-1__subtitle">
            Join 20 million people demanding digital dignity. 
            Tech giants make \$1,089/year from your data. Time to claim your share.
        </p>
        <div class="hero-1__cta-group">
            <a href="/register.php" class="hero-1__cta hero-1__cta--primary">Get Started</a>
            <a href="/about.php" class="hero-1__cta hero-1__cta--secondary">Learn More</a>
        </div>
    </div>
    
    <!-- Background effects placeholder -->
    <div class="hero-1__background">
        <!-- Add holographic gradient animations here -->
    </div>
</section>

<!-- TEMPLATE: Replace with actual design -->
HTML;

createFile('modules/hero-1.php', $hero1Module);

// Other module templates
$moduleTemplates = [
    'hero-2' => 'Hero Module 2 - Alternate hero section',
    'hero-3' => 'Hero Module 3 - Alternate hero section',
    'header-1' => 'Header Module 1 - Standard page header',
    'header-2' => 'Header Module 2 - Alternate page header',
    'content-1' => 'Content Module 1 - Standard content section',
    'content-2' => 'Content Module 2 - Alternate content section',
    'content-3' => 'Content Module 3 - Alternate content section',
    'footer-1' => 'Footer Module 1 - Primary footer',
    'footer-2' => 'Footer Module 2 - Alternate footer',
];

foreach ($moduleTemplates as $module => $description) {
    $content = <<<HTML
<?php
/**
 * {$description}
 */
?>
<section class="{$module}" data-module="{$module}">
    <div class="{$module}__container">
        <h2 class="{$module}__title">Module: {$module}</h2>
        <p class="{$module}__description">{$description}</p>
    </div>
</section>

<!-- TEMPLATE: Replace with actual design -->
HTML;
    createFile("modules/{$module}.php", $content);
}

// ============================================
// CSS FILES
// ============================================

echo colorOutput("\nCreating CSS templates...\n\n", 'blue');

// Main CSS
$mainCSS = <<<CSS
/**
 * Digital Dignity - Master Stylesheet
 * Next-generation design with glassmorphism and holographic effects
 */

/* Import utilities first */
@import url('utilities.css');

/* Import modules */
@import url('modules/navigation.css');
@import url('modules/hero-1.css');
@import url('modules/hero-2.css');
@import url('modules/hero-3.css');
@import url('modules/header-1.css');
@import url('modules/header-2.css');
@import url('modules/content-1.css');
@import url('modules/content-2.css');
@import url('modules/content-3.css');
@import url('modules/footer-1.css');
@import url('modules/footer-2.css');

/* ============================================
   GLOBAL STYLES
   ============================================ */

:root {
  /* Color palette - holographic/cyberpunk theme */
  --color-primary: #00f0ff;
  --color-secondary: #ff00ff;
  --color-accent: #00ff88;
  --color-bg-dark: #0a0a0f;
  --color-bg-darker: #050508;
  --color-text: #ffffff;
  --color-text-muted: #a0a0b0;
  
  /* Spacing */
  --spacing-xs: 0.5rem;
  --spacing-sm: 1rem;
  --spacing-md: 2rem;
  --spacing-lg: 4rem;
  --spacing-xl: 6rem;
  
  /* Typography */
  --font-primary: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  --font-display: 'Orbitron', sans-serif;
  
  /* Transitions */
  --transition-fast: 0.2s ease;
  --transition-normal: 0.3s ease;
  --transition-slow: 0.6s ease;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  font-size: 16px;
  scroll-behavior: smooth;
}

body {
  font-family: var(--font-primary);
  color: var(--color-text);
  background: var(--color-bg-dark);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* ============================================
   TYPOGRAPHY
   ============================================ */

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-display);
  font-weight: 700;
  line-height: 1.2;
  margin-bottom: var(--spacing-sm);
}

h1 { font-size: 3rem; }
h2 { font-size: 2.5rem; }
h3 { font-size: 2rem; }
h4 { font-size: 1.5rem; }

p {
  margin-bottom: var(--spacing-sm);
}

a {
  color: var(--color-primary);
  text-decoration: none;
  transition: color var(--transition-fast);
}

a:hover {
  color: var(--color-secondary);
}

/* ============================================
   LAYOUT
   ============================================ */

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

/* ============================================
   UTILITY CLASSES (see utilities.css)
   ============================================ */
CSS;

createFile('assets/css/main.css', $mainCSS);

// Utilities CSS
$utilitiesCSS = <<<CSS
/**
 * Utility Classes
 * Reusable helper classes for common patterns
 */

/* Spacing utilities */
.mt-0 { margin-top: 0; }
.mt-1 { margin-top: var(--spacing-xs); }
.mt-2 { margin-top: var(--spacing-sm); }
.mt-3 { margin-top: var(--spacing-md); }
.mt-4 { margin-top: var(--spacing-lg); }

.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: var(--spacing-xs); }
.mb-2 { margin-bottom: var(--spacing-sm); }
.mb-3 { margin-bottom: var(--spacing-md); }
.mb-4 { margin-bottom: var(--spacing-lg); }

/* Text utilities */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.text-muted { color: var(--color-text-muted); }

/* Display utilities */
.d-none { display: none; }
.d-block { display: block; }
.d-flex { display: flex; }
.d-grid { display: grid; }

/* Flexbox utilities */
.flex-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.flex-between {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Glassmorphism effect */
.glass {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
}

/* Holographic gradient */
.holographic {
  background: linear-gradient(
    135deg,
    var(--color-primary),
    var(--color-secondary),
    var(--color-accent)
  );
  background-size: 200% 200%;
  animation: holographicShift 3s ease infinite;
}

@keyframes holographicShift {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

/* Button utilities */
.btn {
  display: inline-block;
  padding: 0.75rem 2rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  text-align: center;
  cursor: pointer;
  transition: all var(--transition-normal);
}

.btn-primary {
  background: var(--color-primary);
  color: var(--color-bg-dark);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(0, 240, 255, 0.3);
}

/* Responsive utilities */
@media (max-width: 768px) {
  .hide-mobile { display: none; }
}

@media (min-width: 769px) {
  .show-mobile { display: none; }
}
CSS;

createFile('assets/css/utilities.css', $utilitiesCSS);

// Module CSS templates
foreach (array_merge(['navigation', 'hero-1'], array_keys($moduleTemplates)) as $module) {
    $cssContent = <<<CSS
/**
 * {$module} Module Styles
 * All styles namespaced under .{$module}
 */

.{$module} {
  /* Container styles */
  padding: var(--spacing-lg) 0;
}

.{$module}__container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.{$module}__title {
  /* Title styles */
}

/* Add more module-specific styles here */

/* Responsive styles */
@media (max-width: 768px) {
  .{$module} {
    padding: var(--spacing-md) 0;
  }
}

/* TEMPLATE: Replace with actual design */
CSS;
    createFile("assets/css/modules/{$module}.css", $cssContent);
}

// ============================================
// JAVASCRIPT FILES
// ============================================

echo colorOutput("\nCreating JavaScript templates...\n\n", 'blue');

// Main JS
$mainJS = <<<JS
/**
 * Digital Dignity - Main JavaScript
 * Initialize all modules and set up global functionality
 */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('Digital Dignity initialized');
  
  // Initialize modules
  if (typeof NavigationModule !== 'undefined') NavigationModule.init();
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
JS;

createFile('assets/js/main.js', $mainJS);

// Supabase client
$supabaseJS = <<<JS
/**
 * Supabase Client Setup
 * Initialize Supabase for client-side authentication and data access
 */

// Import Supabase from CDN
import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm';

// Get credentials from page (set by PHP)
const SUPABASE_URL = document.body.dataset.supabaseUrl || '';
const SUPABASE_ANON_KEY = document.body.dataset.supabaseKey || '';

// Create Supabase client
const supabase = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

// Auth helpers
const Auth = {
  async signUp(email, password) {
    const { data, error } = await supabase.auth.signUp({ email, password });
    return { data, error };
  },
  
  async signIn(email, password) {
    const { data, error } = await supabase.auth.signInWithPassword({ 
      email, 
      password 
    });
    return { data, error };
  },
  
  async signOut() {
    const { error } = await supabase.auth.signOut();
    return { error };
  },
  
  async getUser() {
    const { data: { user } } = await supabase.auth.getUser();
    return user;
  }
};

// Make available globally
window.supabase = supabase;
window.Auth = Auth;

export { supabase, Auth };
JS;

createFile('assets/js/supabase-client.js', $supabaseJS);

// Module JS templates
$navigationJS = <<<JS
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
JS;

createFile('assets/js/modules/navigation.js', $navigationJS);

$hero1JS = <<<JS
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
        background.style.transform = `translateY(\${scrolled * 0.5}px)`;
      }
    });
  }
  
  return { init };
})();

// TEMPLATE: Expand with actual hero functionality
JS;

createFile('assets/js/modules/hero-1.js', $hero1JS);

// ============================================
// README
// ============================================

$readme = <<<MD
# Digital Dignity Website

## Quick Start

1. **Configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your Supabase credentials
   ```

2. **Start local server:**
   ```bash
   php -S localhost:8000
   ```

3. **Visit:** http://localhost:8000

## Project Structure

See `PROJECT_BRIEFING.md` for complete documentation.

## Development Workflow

1. Share `PROJECT_BRIEFING.md` with Claude
2. Request module creation
3. Integrate provided code
4. Test in browser
5. Commit to GitHub

## Module System

- **PHP modules:** `/modules/[name].php`
- **CSS:** `/assets/css/modules/[name].css`
- **JS:** `/assets/js/modules/[name].js`

All styles must be namespaced (`.module-name`)

## Adding a New Module

1. Create PHP file in `/modules/`
2. Create CSS file in `/assets/css/modules/`
3. Import CSS in `main.css`
4. Create JS file (if needed) in `/assets/js/modules/`
5. Initialize in `main.js`

## Support

For detailed documentation, see `PROJECT_BRIEFING.md`
MD;

createFile('README.md', $readme);

// ============================================
// COMPLETION
// ============================================

echo colorOutput("\n╔════════════════════════════════════════╗\n", 'green');
echo colorOutput("║  Setup Complete!                      ║\n", 'green');
echo colorOutput("╚════════════════════════════════════════╝\n\n", 'green');

echo colorOutput("Next steps:\n", 'blue');
echo "1. Edit .env with your Supabase credentials\n";
echo "2. Start development server: php -S localhost:8000\n";
echo "3. Share PROJECT_BRIEFING.md with Claude to start building\n";
echo "4. Visit http://localhost:8000 in your browser\n\n";

echo colorOutput("Happy coding! 🚀\n\n", 'green');
?>
