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