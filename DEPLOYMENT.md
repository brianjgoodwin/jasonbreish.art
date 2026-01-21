# Jason Briesh Portfolio - Deployment Documentation

## Project Overview
Portfolio website for Jason Briesh built with Kirby CMS 5.2.2
**Live URL**: https://jason.brianjgoodwin.dev
**Repository**: https://github.com/brianjgoodwin/jasonbreish.art (private)

## Auto-Deployment Setup

### How It Works
1. Push changes to `main` branch on GitHub
2. GitHub webhook triggers `https://jason.brianjgoodwin.dev/deploy.php`
3. Server verifies HMAC-SHA256 signature
4. Deployment script pulls latest code and clears cache
5. Changes are live within seconds

### Making Updates
```bash
git add .
git commit -m "Your commit message"
git push origin main
# Site updates automatically
```

### Monitoring Deployments
```bash
ssh brian@95.216.149.68
sudo tail -f /var/log/webhook-deploy.log
```

## Server Details

### Infrastructure
- **Provider**: Hetzner VPS
- **IP**: 95.216.149.68
- **Domain**: jason.brianjgoodwin.dev (DNS via Squarespace)
- **Web Server**: nginx 1.24.0
- **PHP**: 8.3.6 with OPcache
- **SSL**: Let's Encrypt (auto-renews)

### File Locations
- **Web Root**: `/var/www/jason.brianjgoodwin.dev`
- **Deploy Script**: `/usr/local/bin/deploy.sh`
- **Webhook Handler**: `/var/www/jason.brianjgoodwin.dev/deploy.php`
- **Deployment Log**: `/var/log/webhook-deploy.log`
- **nginx Config**: `/etc/nginx/sites-available/jason.brianjgoodwin.dev`
- **PHP-FPM Config**: `/etc/php/8.3/fpm/pool.d/www.conf`

### SSH Access
```bash
ssh brian@95.216.149.68
```

## Security Features

### Active Protections
- ✅ TLS 1.2/1.3 with HSTS (max-age=31536000)
- ✅ fail2ban protecting SSH and nginx (34 IPs currently banned)
- ✅ Security headers (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
- ✅ Sensitive files blocked (.git, composer.json, /site/accounts/)
- ✅ nginx version hidden
- ✅ Debug mode disabled in production
- ✅ Webhook signature verification (HMAC-SHA256)

### Credentials & Secrets
- **Panel Access**: `https://jason.brianjgoodwin.dev/panel`
  - Email: brianjgoodwin@gmail.com
  - Password: (set in panel, not in version control)
- **Webhook Secret**: Stored in `/etc/php/8.3/fpm/pool.d/www.conf`
- **GitHub Deploy Key**: `/var/www/.ssh/id_ed25519` (www-data user)

### Security Score: **A**

## Architecture

### Content Management
- **CMS**: Kirby 5.2.2 (file-based, no database)
- **Editor**: Blocks editor (markdown, image, gallery only)
- **Content Location**: `/content/1_home/`
- **Accounts**: `/site/accounts/` (gitignored)

### Design
- **Max Width**: 500px centered
- **Color Scheme**: Dark theme (#1a1a1a background, white text)
- **Typography**: System sans-serif stack, 18px, 1.6 line-height (dyslexia-friendly)
- **Gallery**: Horizontal scroll with auto-rotate (4-second intervals)

### Key Files
- **Template**: `site/templates/default.php`
- **Styles**: `assets/css/style.css`
- **Gallery JS**: `assets/js/gallery.js`
- **Config**: `site/config/config.php`
- **Blueprint**: `site/blueprints/pages/default.yml`

## Maintenance

### SSL Certificate Renewal
Automatic via certbot (configured during setup)
```bash
# Manual renewal if needed
sudo certbot renew
```

### Updating Kirby
```bash
composer update getkirby/cms
git add composer.lock
git commit -m "Update Kirby CMS"
git push origin main
```

### Checking fail2ban Status
```bash
sudo fail2ban-client status sshd
sudo fail2ban-client status nginx-http-auth
```

### Viewing nginx Logs
```bash
sudo tail -f /var/log/nginx/access.log
sudo tail -f /var/log/nginx/error.log
```

### Manual Deployment
If webhook fails, deploy manually:
```bash
ssh brian@95.216.149.68
cd /var/www/jason.brianjgoodwin.dev
sudo -u www-data git pull origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data rm -rf site/cache/*
```

## Troubleshooting

### Webhook Not Triggering
1. Check GitHub webhook deliveries: https://github.com/brianjgoodwin/jasonbreish.art/settings/hooks
2. Verify webhook secret matches in PHP-FPM config
3. Check deployment log: `sudo tail /var/log/webhook-deploy.log`

### Site Not Updating
1. Clear browser cache
2. Check deployment log for errors
3. Verify nginx is running: `sudo systemctl status nginx`
4. Verify PHP-FPM is running: `sudo systemctl status php8.3-fpm`

### Permission Issues
Files should be owned by www-data:
```bash
sudo chown -R www-data:www-data /var/www/jason.brianjgoodwin.dev
```

### Panel Not Accessible
Check that panel installation is not blocked:
```php
// site/config/config.php
'panel' => [
    'install' => false  // Set to true temporarily if needed
]
```

## Backup Strategy

### What to Backup
- Content files: `/content/`
- User accounts: `/site/accounts/`
- Media files: `/media/`
- Configuration: `site/config/config.php`

### How to Backup
```bash
# From local machine
scp -r brian@95.216.149.68:/var/www/jason.brianjgoodwin.dev/content ./backup/
scp -r brian@95.216.149.68:/var/www/jason.brianjgoodwin.dev/site/accounts ./backup/
scp -r brian@95.216.149.68:/var/www/jason.brianjgoodwin.dev/media ./backup/
```

Note: Code is already backed up in GitHub

## Contact & Support

**Client**: Jason Briesh
**Developer**: Brian Goodwin (brianjgoodwin@gmail.com)
**Kirby Docs**: https://getkirby.com/docs
**Server Provider**: Hetzner Cloud

---

**Last Updated**: 2026-01-21
**Status**: Production (Live)
**Security Audit**: A rating
