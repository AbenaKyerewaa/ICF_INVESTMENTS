# Phase 18 — Deployment Checklist

> This checklist covers publishing the ICF Investment portfolio demo to a production-equivalent host.  
> Complete every item before sharing the public URL.

---

## Pre-deployment Requirements

- [ ] All 43 automated tests pass locally (`php artisan test`)
- [ ] No `APP_DEBUG=true` in the production environment
- [ ] No secrets committed to Git (run `git log -- .env` to verify)
- [ ] `.gitignore` includes `.env`, `storage/`, `node_modules/`, `vendor/`

---

## Hosting Selection

Choose a host that supports:
- PHP 8.3+
- Composer
- MySQL 8+ (or PostgreSQL)
- Node.js / npm (for frontend build, or pre-build and commit assets)
- Writable `storage/` and `bootstrap/cache/` directories
- HTTPS (SSL certificate — Let's Encrypt is free on most providers)

**Suitable options:** Laravel Cloud, Railway, Render, DigitalOcean App Platform, Forge + VPS, Heroku (with PHP buildpack).

---

## Production Environment Variables

Set the following in your host's environment / secrets manager — **never** in a committed `.env` file:

```ini
APP_NAME="ICF Investment"
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generate with: php artisan key:generate --show>
APP_URL=https://your-domain.example.com

DB_CONNECTION=mysql
DB_HOST=<your-db-host>
DB_PORT=3306
DB_DATABASE=icf_investments
DB_USERNAME=<least-privilege-user>
DB_PASSWORD=<strong-random-password>

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log          # or configure smtp/ses for real delivery
```

---

## Deployment Steps

### 1. Push code to your host

```bash
git push origin main
```

Or upload via SFTP / host-specific CLI.

### 2. Install PHP dependencies (no dev packages)

```bash
composer install --no-dev --optimize-autoloader
```

### 3. Build frontend assets

```bash
npm ci
npm run build
```

### 4. Generate application key (first deploy only)

```bash
php artisan key:generate
```

### 5. Run database migrations

```bash
php artisan migrate --force
```

### 6. Seed demo data (first deploy only)

```bash
php artisan db:seed --force
```

### 7. Cache configuration for performance

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Ensure storage permissions

```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link   # if using public disk
```

---

## Post-deployment Verification

Work through each flow on the **live URL**:

| Check | Expected |
|---|---|
| Visit homepage | Simulation notice visible; no debug output |
| Login as customer (maya.bennett@icf-investment.demo / password) | Redirects to dashboard |
| Dashboard balance card and charts | Data loaded; no JS errors in console |
| Date-range filter (30D / 12M) | Chart updates correctly |
| New simulated transfer | Completes; receipt page loads |
| Transfer receipt PDF download | PDF opens in browser |
| Account statement PDF download | PDF opens; amounts match ledger |
| Beneficiary add / deactivate | Works; audit log entry created |
| Notifications | Appear after transfer; mark-as-read works |
| Login as admin (admin@icf.test / password) | Admin dashboard accessible |
| Admin user toggle-status | User status changes; audit log entry created |
| Regular user trying /admin | 403 Forbidden |
| Try accessing another user's account by ID | 404 Not Found |
| Browser console | Zero JavaScript errors |
| Mobile layout (375px wide) | Sidebar, charts, and tables are usable |
| HTTPS | Green padlock; no mixed-content warnings |
| `APP_DEBUG=false` | Error pages show generic message, not stack trace |

---

## Rollback / Recovery

If a migration or deployment step fails:

```bash
# Rollback the last migration batch
php artisan migrate:rollback

# Clear caches and restart
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Keep a recent database dump before running `migrate --force` in production.

---

## Simulation Boundary Reminder

Confirm that the deployed site:

- ✅ Shows the "Simulation Notice" on the landing page and in document footers
- ❌ Does **not** claim to be a licensed financial institution
- ❌ Does **not** have any real payment or bank-connection functionality
- ❌ Does **not** collect real banking credentials or PII beyond the demo login

---

## Final Release Checklist

- [ ] `APP_DEBUG=false` confirmed in production
- [ ] HTTPS works with valid certificate
- [ ] All post-deployment verification checks pass
- [ ] Simulation notice is visible on the landing page
- [ ] Demo credentials are documented in README but flagged as non-production
- [ ] No real-money functionality or claims are present
- [ ] Git history is clean (no secrets, no large binary files)
- [ ] Public README explains the project purpose and setup steps
