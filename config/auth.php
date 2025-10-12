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
    return isset($_COOKIE['sb-access-token']) || isset($_SESSION['user_id']);
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
    return $_SESSION['user_id'] ?? null;
}

/**
 * Redirect if already logged in
 */
function redirectIfLoggedIn($destination = '/dashboard/') {
    if (isLoggedIn()) {
        header("Location: $destination");
        exit;
    }
}