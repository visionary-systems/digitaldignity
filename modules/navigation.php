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