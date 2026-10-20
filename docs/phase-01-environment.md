# Phase 1 — Environment verification

Completed: 2026-10-20

## Verified local toolchain

| Tool | Verified version/status |
| --- | --- |
| PHP | 8.3.33 |
| Laravel | 13.38.0 |
| Composer | 2.10.3 |
| Node.js | 24.22.0 |
| npm | 11.19.1 (use `npm.cmd` in PowerShell) |
| Git | 2.56.0.windows.2 |
| PHP ZIP extension | Enabled |
| Laragon | Installed at `C:\laragon` |
| MySQL | 8.4.3, running locally on port 3306 |

## Project verification

- Laravel was scaffolded in this repository and `php artisan --version` succeeds.
- The local MySQL database is `icf_investment`; Laravel's ignored `.env` uses the MySQL driver.
- Base Laravel migrations completed successfully.
- `php artisan test` passed (2 tests).
- `npm.cmd run build` completed successfully.
- Git commit `4bf0088` is the clean Laravel baseline.

## Safety checks

- `.env`, `vendor/`, and `node_modules/` are ignored by Git.
- Local database credentials remain only in `.env`; no secrets are tracked.
- Git author identity is configured locally for this repository only.

## Normal local commands

```powershell
# Ensure Laragon/MySQL is running, then from this project folder:
php artisan serve
npm.cmd run dev
php artisan migrate
php artisan test
```

Do not change the system-wide PowerShell execution policy to run npm. Use `npm.cmd` when PowerShell blocks `npm.ps1`.
