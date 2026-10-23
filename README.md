# ICF Investment Dashboard

> **⚠ Simulation Notice — This is a portfolio demonstration.**  
> ICF Investment Dashboard is a **non-functional, simulated** investment/banking-style web application.  
> It does **not** accept real deposits, execute real payments, connect to any bank rails, or handle real financial credentials. All balances, transactions, and account data are entirely fictional and generated solely for demonstration purposes.

---

## Purpose

A polished full-stack Laravel portfolio project that demonstrates:

- Authenticated multi-role user experience (customer + admin)
- Double-entry ledger accounting with balance reconciliation
- Simulated fund transfer workflow with idempotency protection
- PDF receipt and account statement generation
- Interactive Chart.js analytics sourced from server-side aggregates
- Paginated admin dashboard with audit log viewer
- Role-based access control enforced server-side

---

## Technology Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 / PHP 8.3 |
| Database | MySQL (via Laragon) / SQLite (for tests) |
| Frontend | Blade templates, Bootstrap 5, Vanilla CSS |
| Charts | Chart.js (loaded via CDN) |
| PDF | barryvdh/laravel-dompdf |
| Assets | Vite + npm |
| Auth | Custom session-based authentication (bcrypt) |
| Testing | PHPUnit 12 |

---

## Features

- **Dashboard** — Balance card, Chart.js credit/debit timeline, cashflow breakdown, recent ledger entries, date-range filtering (30D / 90D / 6M / 12M / custom)
- **Account detail** — Full paginated ledger history with search, type/status filters, running balance reconciliation
- **Simulated transfers** — Two-step preview → confirm flow with server-side balance validation, idempotency key, and failure rollback
- **Beneficiary management** — Add, edit, deactivate saved recipients; history preserved on deactivation
- **Documents** — Downloadable PDF account statements (date-range) and transfer receipts
- **Notifications** — Per-user alerts for transfer events; mark-as-read and delete
- **Profile** — Name/email update, password change with rate limiting
- **Admin dashboard** — User summary, account overview, recent audit events
- **User management** — Search, enable/disable users and accounts (with self-disable guard)
- **Audit logs** — Append-only records for login failures, profile changes, transfers, admin actions; paginated and filterable
- **Security** — CSRF protection, ownership guards on every route, rate-limited endpoints, session hardening

---

## Prerequisites

- PHP 8.3+
- Composer
- Node.js / npm
- MySQL (Laragon recommended on Windows) **or** SQLite (zero-config for local dev)
- Git

---

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/ICF_INVESTMENTS.git
cd ICF_INVESTMENTS
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your database credentials:

```ini
# For MySQL (Laragon default):
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=icf_investments
DB_USERNAME=root
DB_PASSWORD=

# Or keep DB_CONNECTION=sqlite for a zero-config local database
```

### 4. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build frontend assets

```bash
npm run build
```

### 6. Start the development server

```bash
php artisan serve
```

Visit **http://localhost:8000** in your browser.

---

## One-command Setup (using the composer script)

```bash
composer run setup
```

This runs `composer install`, copies `.env.example`, generates `APP_KEY`, runs migrations, installs npm packages, and builds assets in one step.

---

## Demo Credentials

> These credentials are for the pre-seeded demo data only. Do **not** use real passwords here.

| Role | Email | Password |
|---|---|---|
| Customer | maya.bennett@icf-investment.demo | password |
| Administrator | admin@icf.test | password |

---

## Running Tests

```bash
php artisan test
```

Or run a specific file:

```bash
php artisan test tests/Feature/BalanceReconciliationTest.php
```

The test suite covers:

- Authentication and authorization flows
- Balance reconciliation (credits − debits = stored balance)
- Simulated transfer workflow including idempotency and insufficient-funds rejection
- Beneficiary management CRUD and ownership enforcement
- PDF document download authorization
- Admin tools and audit log creation
- Security hardening (role escalation, rate limiting, cross-user data access)
- Charts and notifications isolation

---

## Project Structure (key paths)

```
app/
  Http/Controllers/       — Route handlers
  Http/Requests/          — Form request validation
  Models/                 — Eloquent models
  Services/               — AccountAnalyticsService
  ProcessSimulatedTransfer.php  — Core transfer + ledger logic
database/
  migrations/             — Schema history
  seeders/                — Demo data
resources/views/          — Blade templates
routes/web.php            — All application routes
tests/Feature/            — PHPUnit feature tests
```

---

## Deployment Notes (Phase 18)

Before deploying to a production-equivalent host:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in your production `.env`
2. Generate a fresh `APP_KEY` — never reuse a local key in production
3. Set all `DB_*` values to the hosted database credentials
4. Enable HTTPS and set `SESSION_SECURE_COOKIE=true`
5. Run `npm run build` and commit the compiled assets, **or** build on the server
6. Run `php artisan migrate --force` during deployment
7. Run `php artisan config:cache` and `php artisan route:cache` for performance
8. Use a least-privilege database user (SELECT, INSERT, UPDATE, DELETE only — no DROP)
9. Verify `storage/` and `bootstrap/cache/` are writable by the web server process
10. Test login, dashboard, transfer, PDF download, and admin routes on the hosted URL

See the [deployment checklist](docs/phase-18-deployment-checklist.md) for the full release checklist.

---

## Simulation Boundary

This project is a **portfolio demonstration**. It:

- ✅ Simulates investment account activity with fictional data
- ✅ Demonstrates full-stack Laravel patterns and security practices
- ❌ Does **not** connect to any payment processor, bank API, or financial network
- ❌ Does **not** accept or hold real money
- ❌ Is **not** a licensed financial institution or regulated product

A production financial product would require specialist legal, regulatory, security, and provider review well beyond the scope of this portfolio project.

---

## License

This portfolio project is released under the [MIT License](https://opensource.org/licenses/MIT).
