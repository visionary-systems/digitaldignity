<?php
/**
 * Supabase Configuration
 * Load environment variables and set up Supabase connection
 */

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
}

// Supabase constants
define('SUPABASE_URL', $_ENV['SUPABASE_URL'] ?? '');
define('SUPABASE_ANON_KEY', $_ENV['SUPABASE_ANON_KEY'] ?? '');
define('SUPABASE_SERVICE_KEY', $_ENV['SUPABASE_SERVICE_KEY'] ?? '');

// Site constants
define('SITE_URL', $_ENV['SITE_URL'] ?? 'http://localhost:8000');
define('SITE_NAME', $_ENV['SITE_NAME'] ?? 'Digital Dignity');
define('ENVIRONMENT', $_ENV['ENVIRONMENT'] ?? 'development');

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}