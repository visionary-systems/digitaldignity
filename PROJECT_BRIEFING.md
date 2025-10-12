# Digital Dignity Website - Project Briefing

## 🎯 Project Mission
Digital Dignity is a comprehensive movement and platform advocating for personal data ownership rights, positioning personal data as intellectual property with economic value. The core mission is to reach 20 million people who agree with data ownership principles.

### Key Value Proposition
Tech giants generate **$1,089 per user annually** (Google: $724, Meta: $365) from user data while users receive nothing. Digital Dignity empowers users to claim their share.

---

## 🏗️ Technical Architecture

### Hosting Environment
- **Platform**: Hostinger (generic PHP shared hosting)
- **Database**: Supabase (PostgreSQL with real-time capabilities)
- **Version Control**: GitHub
- **Languages**: PHP, HTML, CSS, Vanilla JavaScript
- **No frameworks**: Keep it simple - vanilla PHP with includes

### Why These Choices?
- ✅ Hostinger doesn't support Node.js/React builds
- ✅ Supabase provides backend infrastructure (no MySQL needed)
- ✅ PHP allows modular construction with includes
- ✅ Vanilla JS keeps it lightweight and compatible

---

## 📁 File Structure

```
digitaldignity.org/
├── index.php                    # Home page
├── about.php                    # About Digital Dignity
├── community.php                # Community page
├── founders.php                 # Founders page
├── mission.php                  # Mission statement
├── roadmap.php                  # Project roadmap
├── sponsors.php                 # Sponsors page
├── register.php                 # User registration
├── login.php                    # User login
├── privacy.php                  # Privacy policy
├── terms.php                    # Terms of service
│
├── dashboard/                   # Protected area (login required)
│   ├── index.php               # User dashboard
│   ├── everything.php          # The Everything App (∑)
│   ├── atlas.php               # Atlas product
│   ├── grail.php               # Grail product
│   ├── scout.php               # Scout product
│   ├── party-hard-party.php    # Future
│   ├── px-protocol.php         # Future
│   ├── rfdd.php                # Future
│   └── events.php              # Future
│
├── modules/                     # Reusable page sections
│   ├── navigation.php
│   ├── hero-1.php
│   ├── hero-2.php
│   ├── hero-3.php
│   ├── header-1.php
│   ├── header-2.php
│   ├── content-1.php
│   ├── content-2.php
│   ├── content-3.php
│   ├── footer-1.php
│   └── footer-2.php
│
├── assets/
│   ├── css/
│   │   ├── main.css            # Master stylesheet
│   │   ├── utilities.css       # Utility classes
│   │   └── modules/            # Module-specific CSS
│   │       ├── navigation.css
│   │       ├── hero-1.css
│   │       └── [etc].css
│   │
│   ├── js/
│   │   ├── main.js             # Master JavaScript
│   │   ├── supabase-client.js  # Supabase connection
│   │   └── modules/            # Module-specific JS
│   │       ├── navigation.js
│   │       ├── hero-1.js
│   │       └── [etc].js
│   │
│   └── images/
│       ├── logo.svg
│       ├── heroes/
│       └── icons/
│
├── config/
│   ├── supabase.php            # Supabase configuration
│   └── auth.php                # Authentication helpers
│
├── .env                         # Environment variables (DO NOT COMMIT)
├── .gitignore                   # Git ignore rules
└── PROJECT_BRIEFING.md         # This file
```

---

## 🎨 Design System

### Brand Identity
- **Aesthetic**: Next-generation, inspired by opal.so
- **Visual Style**: Glassmorphism, holographic gradients, cyberpunk elements
- **Effects**: Smooth animations, glitch text, distortion effects
- **Tone**: Revolutionary movement-building (Thomas Paine style), not corporate

### Color Palette
- Holographic gradients with iridescent effects
- Dark backgrounds with neon accents
- Premium, futuristic feel

### Typography
- Bold headers with glitch effects
- Clean, readable body text
- Cyber-inspired display fonts

---

## 🧩 Module System

### Module Philosophy
Pages are constructed from reusable modules. Each module is self-contained with its own HTML, CSS, and JS.

### Module Naming Convention
- **PHP files**: `module-name.php` (e.g., `hero-1.php`)
- **CSS files**: `module-name.css` (e.g., `hero-1.css`)
- **JS files**: `module-name.js` (e.g., `hero-1.js`)

### CSS Namespacing (CRITICAL)
All module CSS must be namespaced to prevent conflicts:

```css
/* modules/hero-1.css */
.hero-1 {
  /* Container styles */
}

.hero-1__title {
  /* Element styles */
}

.hero-1__button {
  /* Element styles */
}
```

**Naming pattern**: `.module-name` → `.module-name__element`

### JavaScript Module Pattern
```javascript
// assets/js/modules/hero-1.js
const Hero1Module = (function() {
  function init() {
    // Module initialization
    const hero = document.querySelector('.hero-1');
    if (!hero) return;
    
    // Module-specific functionality
  }
  
  return { init };
})();

// Called from main.js
document.addEventListener('DOMContentLoaded', function() {
  Hero1Module.init();
});
```

---

## 📄 Page Construction Pattern

### Standard Page Template
```php
<?php
// page-name.php
require_once 'config/supabase.php';
require_once 'config/auth.php';

$pageTitle = "Page Title - Digital Dignity";
$pageClass = "page-name"; // for page-specific CSS targeting
$modules = [
  'navigation',
  'hero-1',
  'content-1',
  'content-2',
  'footer-1'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="/assets/css/main.css">
  <?php if(file_exists("assets/css/pages/{$pageClass}.css")): ?>
    <link rel="stylesheet" href="/assets/css/pages/<?php echo $pageClass; ?>.css">
  <?php endif; ?>
</head>
<body class="<?php echo $pageClass; ?>">
  <?php
  foreach($modules as $module) {
    include "modules/{$module}.php";
  }
  ?>
  <script src="/assets/js/main.js"></script>
  <?php if(file_exists("assets/js/pages/{$pageClass}.js")): ?>
    <script src="/assets/js/pages/<?php echo $pageClass; ?>.js"></script>
  <?php endif; ?>
</body>
</html>
```

### Protected Pages (Dashboard)
```php
<?php
// dashboard/index.php
require_once '../config/supabase.php';
require_once '../config/auth.php';

requireLogin(); // Redirect if not logged in

// Rest of page code...
?>
```

---

## 🔐 Authentication & Security

### Authentication Flow (Supabase)
1. **Client-side**: Supabase JS SDK handles auth UI and tokens
2. **Session storage**: Tokens stored in localStorage/cookies
3. **Server-side validation**: PHP validates Supabase JWT on protected pages

### Security Checklist
- ✅ Use HTTPS only (Hostinger SSL)
- ✅ Enable Supabase Row Level Security (RLS)
- ✅ Store credentials in `.env` (never commit)
- ✅ Validate all user inputs (PHP + Supabase constraints)
- ✅ Sanitize outputs to prevent XSS
- ✅ Use prepared statements for any custom queries
- ✅ Implement rate limiting on auth endpoints (Supabase built-in)

### .env File Template
```env
SUPABASE_URL=your_project_url.supabase.co
SUPABASE_ANON_KEY=your_anon_key
SUPABASE_SERVICE_KEY=your_service_key
```

---

## 🔄 Development Workflow with Claude

### Step 1: Request Module Creation
**Prompt Template:**
```
Create a [module-name] module for Digital Dignity website with:
- Purpose: [describe what this module does]
- Content: [list key elements]
- Style: Next-gen aesthetic, glassmorphism, holographic gradients
- Interactions: [describe any animations/interactions]
- Data needs: [any dynamic content from Supabase]

Technical requirements:
- Use namespaced CSS (.module-name, .module-name__element)
- Use JavaScript module pattern if needed
- Mobile-first responsive design
- Include accessibility attributes
```

### Step 2: Receive Three Files
Claude will provide:
1. **HTML** (PHP module file)
2. **CSS** (namespaced stylesheet)
3. **JS** (if interactive, using module pattern)

### Step 3: Integration Process
1. Copy HTML to `/modules/[module-name].php`
2. Copy CSS to `/assets/css/modules/[module-name].css`
3. Add CSS import to `main.css`:
   ```css
   @import url('modules/[module-name].css');
   ```
4. Copy JS to `/assets/js/modules/[module-name].js`
5. Add module init to `main.js`:
   ```javascript
   ModuleNameModule.init();
   ```
6. Test in browser
7. Commit to GitHub

### Step 4: Iterate if Needed
- Request modifications with specific feedback
- Claude provides updated code
- Replace files and test

---

## 🎯 Content Strategy

### Key Messages
- **Primary**: "Your data is your intellectual property - own it, understand it, benefit from it"
- **Value Prop**: "$1,089 per year - that's what your data is worth to tech giants"
- **Call to Action**: "Join 20 million people demanding digital dignity"

### Page Purposes
- **Home**: Movement overview, emotional hook, CTA to register
- **About**: Mission, vision, the problem we're solving
- **Community**: How to get involved, ambassador program
- **Founders**: Team credibility, expertise
- **Mission**: Detailed mission statement, values
- **Roadmap**: Project timeline, milestones
- **Sponsors**: Partner logos, how to sponsor

### Dashboard Products
- **∑ (Everything)**: Data aggregation OS, vision boards
- **Atlas**: Visualization tools
- **Grail**: AI-powered insights
- **Scout**: Data discovery

---

## 🚀 Launch Priorities

### Phase 1: MVP (Months 1-2)
- [ ] Core public pages (home, about, mission)
- [ ] User registration/login via Supabase
- [ ] Basic dashboard with ∑ overview
- [ ] Navigation module (works everywhere)
- [ ] Footer module (works everywhere)
- [ ] 2-3 hero variations
- [ ] 3-4 content module types

### Phase 2: Expansion (Months 3-4)
- [ ] All dashboard product pages
- [ ] Community features
- [ ] Founders/team pages
- [ ] Roadmap visualization
- [ ] Sponsors showcase

### Phase 3: Advanced (Months 5-6)
- [ ] Store functionality
- [ ] Events system
- [ ] RFDD integration
- [ ] PX Protocol documentation
- [ ] Party Hard Party pages

---

## 📊 Success Metrics

### User Acquisition
- Target: 20 million registered users
- Initial milestone: 500,000 users (6 months)

### Engagement
- Dashboard login frequency
- Module interaction rates
- Vision board creation
- Data connection rates

### Movement Building
- Ambassador program growth
- Social media reach
- Media coverage
- Partnership acquisitions

---

## 🛠️ Technical Standards

### Code Quality
- **PHP**: Follow PSR-12 coding standards
- **CSS**: BEM naming for module elements
- **JS**: ES6+ features, module pattern
- **Comments**: Document complex logic

### Performance
- Page load time < 2 seconds
- Optimize images (WebP format)
- Minimize CSS/JS (later phase)
- Lazy load images below fold
- Use Supabase caching

### Accessibility
- Semantic HTML5
- ARIA labels on interactive elements
- Keyboard navigation support
- Color contrast WCAG AA minimum
- Alt text on all images

### Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile-first responsive
- No IE11 support needed

---

## 🔍 Git Workflow

### Branch Strategy
- `main` - production
- `develop` - integration branch
- `feature/module-name` - individual modules
- `fix/issue-description` - bug fixes

### Commit Messages
```
feat: Add hero-2 module with holographic effects
fix: Navigation dropdown z-index on mobile
style: Update glassmorphism effects on cards
docs: Add module creation guidelines
```

### .gitignore Essentials
```
.env
.DS_Store
node_modules/
vendor/
*.log
```

---

## 📞 Key Contacts & Resources

### Supabase Resources
- [Documentation](https://supabase.com/docs)
- [JS Client Library](https://supabase.com/docs/reference/javascript)
- [Authentication Guide](https://supabase.com/docs/guides/auth)

### Design Inspiration
- opal.so (primary inspiration)
- Glassmorphism trends
- Cyberpunk aesthetics

### Movement References
- Tim Berners-Lee (Web inventor, data ownership advocate)
- Jaron Lanier (Digital dignity thought leader)
- "Who Owns the Future?" by Jaron Lanier

---

## 📝 Quick Reference

### When Starting a New Conversation with Claude
1. Share this PROJECT_BRIEFING.md file
2. Specify which module/page you're working on
3. Reference the relevant product documents if needed
4. Provide any specific design requirements
5. Request HTML, CSS, and JS separately for easy integration

### Common Requests
- "Create [module] following the project briefing standards"
- "Update [module] with [specific change]"
- "Create a new page [name] following the standard template"
- "Debug this [issue] in [module]"

### File Organization Checklist
- ✅ Module PHP in `/modules/`
- ✅ Module CSS in `/assets/css/modules/`
- ✅ Module JS in `/assets/js/modules/`
- ✅ CSS imported in `main.css`
- ✅ JS initialized in `main.js`
- ✅ All classes namespaced properly

---

## 🎬 Getting Started

### For First-Time Setup
1. Run `setup-project.php` script (creates all directories)
2. Configure `.env` with Supabase credentials
3. Create Supabase database tables
4. Start building modules!

### For Continuing Development
1. Pull latest from GitHub
2. Share this briefing with Claude
3. Specify what you're building
4. Integrate provided code
5. Test and commit

---

**Last Updated**: [Date]
**Version**: 1.0
**Maintainer**: Digital Dignity Development Team
