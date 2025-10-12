# Quick Start Guide

## First Time Setup

### 1. Run the setup script
```bash
php setup-project.php
```

This creates:
- ✅ Complete directory structure
- ✅ All page templates
- ✅ Module templates with examples
- ✅ CSS/JS framework
- ✅ Configuration files
- ✅ .env template
- ✅ .gitignore

### 2. Configure Supabase
Edit `.env` file:
```env
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_ANON_KEY=your_anon_key_here
SUPABASE_SERVICE_KEY=your_service_key_here
```

### 3. Start development server
```bash
php -S localhost:8000
```

Visit: http://localhost:8000

---

## Working with Claude

### Starting a New Session

**Option 1: Share the full briefing**
```
I'm working on Digital Dignity website. Here's the project briefing:

[Paste contents of PROJECT_BRIEFING.md]

I need to create [specific module/page].
```

**Option 2: Quick context (for experienced Claude sessions)**
```
Digital Dignity project context:
- PHP site on Hostinger (no frameworks)
- Supabase backend
- Modular architecture (modules/ directory)
- CSS must be namespaced (.module-name)
- JS uses module pattern
- Next-gen design: glassmorphism, holographic effects

I need to create [specific request].
```

### Module Creation Workflow

#### Step 1: Request the module
```
Create a "hero-2" module for Digital Dignity with:
- Large heading: "20 Million Strong"
- Subheading about the movement
- Stats: $1,089 per user (what tech giants make)
- CTA button "Join the Movement"
- Holographic gradient background
- Glassmorphism card effects
- Mobile responsive

Technical:
- Use .hero-2 namespace for all CSS
- Include JavaScript module pattern if interactive
- Follow project standards (see PROJECT_BRIEFING.md)
```

#### Step 2: Claude provides 3 files
1. **hero-2.php** (HTML/PHP)
2. **hero-2.css** (Namespaced styles)
3. **hero-2.js** (If needed, with module pattern)

#### Step 3: Integrate the code

**Copy HTML:**
```bash
# Create or update the module file
nano modules/hero-2.php
# Paste the HTML/PHP code
```

**Copy CSS:**
```bash
# Create the CSS file
nano assets/css/modules/hero-2.css
# Paste the CSS code
```

**Import CSS in main.css:**
```css
/* Add to assets/css/main.css */
@import url('modules/hero-2.css');
```

**Copy JS (if provided):**
```bash
# Create the JS file
nano assets/js/modules/hero-2.js
# Paste the JS code
```

**Initialize JS in main.js:**
```javascript
// Add to assets/js/main.js DOMContentLoaded section
if (typeof Hero2Module !== 'undefined') Hero2Module.init();
```

#### Step 4: Test
1. Refresh browser
2. Check module appearance
3. Test interactions
4. Verify mobile responsive

#### Step 5: Commit
```bash
git add modules/hero-2.php
git add assets/css/modules/hero-2.css
git add assets/css/main.css
git add assets/js/modules/hero-2.js
git add assets/js/main.js
git commit -m "feat: Add hero-2 module with holographic effects"
git push
```

---

## Creating a New Page

### Request from Claude:
```
Create a "sponsors" page for Digital Dignity:
- Show sponsor logos in grid
- Tier system: Platinum, Gold, Silver
- "Become a Sponsor" CTA
- Use header-1 and footer-1 modules
- Create new sponsor-grid module

Follow project template structure.
```

### Claude provides:
1. **sponsors.php** (Complete page)
2. **sponsor-grid.php** (New module)
3. **sponsor-grid.css** (Module styles)
4. **sponsor-grid.js** (If needed)

### You integrate:
1. Copy `sponsors.php` to root
2. Copy `sponsor-grid.php` to `modules/`
3. Copy CSS and update imports
4. Copy JS and update main.js
5. Test and commit

---

## Common Tasks

### Adding a new utility class
Edit `assets/css/utilities.css`:
```css
.new-utility {
  /* styles */
}
```

### Modifying existing module
```
Update the hero-1 module:
- Change title to "[new title]"
- Add animation to CTA button
- Update background gradient colors

Only provide the changed sections, not entire files.
```

### Creating page-specific styles
```css
/* assets/css/pages/sponsors.css */
.page-sponsors .sponsor-grid {
  /* Page-specific overrides */
}
```

Link in page:
```php
<link rel="stylesheet" href="/assets/css/pages/sponsors.css">
```

### Debugging CSS conflicts
**Problem:** Styles not applying
**Check:**
1. Is CSS imported in `main.css`?
2. Is the class namespaced correctly? (`.module-name`)
3. Is there a more specific selector overriding?
4. Browser cache cleared?

### Debugging JavaScript issues
**Problem:** Module not initializing
**Check:**
1. Is JS file created?
2. Is module initialized in `main.js`?
3. Check browser console for errors
4. Is the module pattern correct?

---

## File Locations Quick Reference

| What | Where |
|------|-------|
| Public pages | `/page-name.php` |
| Dashboard pages | `/dashboard/page-name.php` |
| Modules (HTML) | `/modules/module-name.php` |
| Module CSS | `/assets/css/modules/module-name.css` |
| Module JS | `/assets/js/modules/module-name.js` |
| Page CSS | `/assets/css/pages/page-name.css` |
| Page JS | `/assets/js/pages/page-name.js` |
| Images | `/assets/images/` |
| Config | `/config/` |
| Environment | `/.env` |

---

## GitHub Workflow

### Initial setup
```bash
git init
git add .
git commit -m "Initial Digital Dignity setup"
git remote add origin git@github.com:yourusername/digitaldignity.git
git push -u origin main
```

### Daily workflow
```bash
# Pull latest changes
git pull

# Create feature branch (optional)
git checkout -b feature/new-module

# Make changes, then:
git add .
git commit -m "feat: Add new module"
git push

# Or push to feature branch:
git push -u origin feature/new-module
```

### Commit message conventions
```
feat: Add new feature
fix: Bug fix
style: Visual/CSS changes
docs: Documentation
refactor: Code restructuring
```

---

## Pro Tips

### 1. Keep Claude sessions focused
- ✅ "Create hero-2 module"
- ❌ "Create entire website"

### 2. Request incremental updates
```
Update hero-1 module:
- Only change the title text
- Keep everything else the same
```

### 3. Use specific design language
```
Style should be:
- Glassmorphism effect (rgba background, backdrop-filter blur)
- Holographic gradient (cyan to magenta to green)
- Smooth transitions (0.3s ease)
- Dark background (#0a0a0f)
```

### 4. Reference existing modules
```
Create footer-2 module similar to footer-1 but:
- Simpler layout (single column)
- No newsletter signup
- Minimal links
```

### 5. Test on mobile
```bash
# Use phone on same network
# Find your IP: ifconfig | grep "inet "
# Visit: http://YOUR_IP:8000
```

---

## Troubleshooting

### Module not showing on page
1. Check module is in `$modules` array
2. Check file path is correct
3. Check for PHP errors: `tail -f error_log`

### CSS not applying
1. Hard refresh: Cmd+Shift+R (Mac) or Ctrl+Shift+R (Windows)
2. Check browser inspector for loaded CSS
3. Verify CSS imported in `main.css`
4. Check specificity conflicts

### JavaScript not working
1. Open browser console (F12)
2. Check for errors
3. Verify module is initialized in `main.js`
4. Check function names match

### Supabase connection issues
1. Verify `.env` credentials
2. Check Supabase dashboard is accessible
3. Check browser console for CORS errors
4. Verify API keys are correct type (anon vs service)

---

## Next Steps

1. ✅ Setup complete? Start with navigation module
2. ✅ Navigation done? Create hero-1 module  
3. ✅ Hero done? Build footer-1 module
4. ✅ Core modules done? Create first full page
5. ✅ First page done? Add authentication
6. ✅ Auth done? Build dashboard pages

---

## Getting Help

### From Claude:
```
I'm stuck on [specific problem].

Context:
- Working on [module/page name]
- Expected: [what should happen]
- Actual: [what is happening]
- Already tried: [what you've tried]

[Include relevant code snippet if needed]
```

### From Browser DevTools:
- Console: See JavaScript errors
- Network: Check file loading
- Elements: Inspect CSS application
- Application: Check localStorage/cookies

---

## Success Checklist

Before considering a module "done":

- [ ] Looks good on desktop (1920px)
- [ ] Looks good on laptop (1440px)
- [ ] Looks good on tablet (768px)
- [ ] Looks good on mobile (375px)
- [ ] All interactions work
- [ ] No console errors
- [ ] CSS is namespaced
- [ ] JS uses module pattern
- [ ] Code is committed to GitHub
- [ ] Live site is updated (if applicable)

---

**You're all set! Start building. 🚀**
