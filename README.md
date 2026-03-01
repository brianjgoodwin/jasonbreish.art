# Jason Breish Portfolio

> **Note:** Non-commercial portfolio site for artist friend Jason Breish. This README is for future maintenance sessions - either me or a future Claude Code session that needs context quickly.

## Project Overview

Simple, minimal portfolio website for Jason Breish (artist) built on Kirby CMS 5.2. Dark-themed, single-page design with blocks editor for content management.

**Live Site:** https://jason.brianjgoodwin.dev
**Status:** Production (actively maintained)

## Tech Stack

- **CMS:** Kirby 5.2.2 (file-based, no database)
- **PHP:** 8.3.6 with OPcache
- **Server:** nginx on Hetzner VPS
- **Deployment:** Auto-deploy via GitHub webhooks
- **SSL:** Let's Encrypt (auto-renews)

## Project Structure

```
/WEB_jasonbriesh.art/
├── site/
│   ├── templates/default.php      # Main page template
│   ├── snippets/blocks/gallery.php # Custom gallery block
│   ├── blueprints/                # Panel editor config
│   ├── config/config.php          # Kirby settings
│   └── accounts/                  # Users (gitignored)
├── content/                       # Page content (markdown + images)
├── assets/
│   ├── css/style.css             # Main styles (dark theme)
│   └── js/gallery.js             # Gallery auto-rotate
├── kirby/                        # Kirby CMS core (composer-managed)
├── deploy.php                    # Webhook handler
└── DEPLOYMENT.md                 # Full deployment/server docs
```

## Key Features

### Design
- Max width 500px centered
- Dark theme (#1a1a1a background, white text)
- Dyslexia-friendly typography (18px, 1.6 line-height)
- Horizontal-scroll gallery with 4-second auto-rotate

### Content Management
- Panel access: https://jason.brianjgoodwin.dev/panel
- Blocks editor (markdown, images, gallery only)
- File-based (no database)
- Content in `/content/1_home/`

### Deployment
- Push to `main` → Auto-deploys via webhook
- GitHub verifies HMAC-SHA256 signature
- Clears Kirby cache on deploy

## Local Development

**Start local server:**
```bash
composer start
# OR
php -S localhost:8000 kirby/router.php
```

**Access:**
- Site: http://localhost:8000
- Panel: http://localhost:8000/panel

## Making Updates

**For code/template changes:**
```bash
git add .
git commit -m "Description of change"
git push origin main
# Site auto-deploys within seconds
```

**For content changes:**
- Login to panel: https://jason.brianjgoodwin.dev/panel
- Edit content directly
- Changes are immediate (no deployment needed)

## Important Files

**Template:** `site/templates/default.php` (19 lines)
**Styles:** `assets/css/style.css` (dark theme, gallery styles)
**Gallery JS:** `assets/js/gallery.js` (auto-rotate logic)
**Config:** `site/config/config.php` (debug off, panel locked, cache on)
**Blueprint:** `site/blueprints/pages/default.yml` (editor config)

## Server Details

**Quick reference:**
- IP: 95.216.149.68
- SSH: `ssh brian@95.216.149.68`
- Web root: `/var/www/jason.brianjgoodwin.dev`
- Deploy log: `/var/log/webhook-deploy.log`

**See DEPLOYMENT.md for:**
- Full server architecture
- Security configuration (A rating)
- SSL/fail2ban setup
- Troubleshooting steps
- Backup procedures

## Maintenance Tasks

**Update Kirby:**
```bash
composer update getkirby/cms
git commit -am "Update Kirby CMS"
git push origin main
```

**Clear cache manually:**
```bash
ssh brian@95.216.149.68
sudo -u www-data rm -rf /var/www/jason.brianjgoodwin.dev/site/cache/*
```

**Monitor deployments:**
```bash
ssh brian@95.216.149.68
sudo tail -f /var/log/webhook-deploy.log
```

## Common Issues

**Site not updating after push?**
1. Check GitHub webhook deliveries
2. Check deployment log on server
3. Manually deploy if needed (see DEPLOYMENT.md)

**Panel not accessible?**
- Check `site/config/config.php` has `'panel' => ['install' => false]`
- Verify user account exists in `site/accounts/`

**Content not displaying?**
- Clear Kirby cache
- Check content files exist in `/content/`
- Verify file permissions (should be www-data:www-data)

## Credentials

**Panel Login:**
- URL: https://jason.brianjgoodwin.dev/panel
- Email: brianjgoodwin@gmail.com
- Password: (set in panel, not in version control)

**Webhook Secret:** Stored in server PHP-FPM config (not in repo)

## Key Customizations

This is NOT a stock Kirby Plainkit. Key modifications:

1. **Custom gallery block** with horizontal scroll + auto-rotate
2. **Minimal template** (site/templates/default.php)
3. **Dark theme** with dyslexia-friendly typography
4. **Auto-deploy webhook** (deploy.php)
5. **Locked panel** (blocks editor only - markdown, image, gallery)
6. **GLightbox integration** for image popups

## Client Info

**Artist:** Jason Breish
**Site Manager:** Brian Goodwin (brianjgoodwin@gmail.com)
**Purpose:** Portfolio/artwork showcase
**Update Frequency:** As needed (content-managed by editor)

---

**Based on:** Kirby Plainkit
**Kirby Version:** 5.2.2
**Last Updated:** February 15, 2026
**License:** Kirby license (owned/managed by Brian Goodwin)
