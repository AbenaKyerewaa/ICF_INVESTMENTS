# Phases 5–8 — Data, environment, authentication, and demo seed foundation

## Implemented data model

| Table | Role |
| --- | --- |
| `users` | Login identity with `customer`/`administrator` role and active status |
| `accounts` | User-owned USD demo account and reconciled cached balance |
| `beneficiaries` | Customer-owned fictional recipients, retained by status rather than deletion |
| `transfers` | Future transfer workflow record with account-scoped idempotency key |
| `ledger_entries` | Immutable-style account activity source of truth |
| `invoices` | Reserved optional document data model |
| `notifications` | Customer-facing fictional account events |
| `audit_logs` | Append-only-style security and administrator event history |

## Ledger rules

- Amounts use `DECIMAL(20,2)` and explicit ISO currency codes.
- `ledger_entries` are the accounting source of truth; `accounts.balance` is a reconciled cached display value.
- Every entry has a unique reference, type, status, timestamp, and account relationship.
- Transfer requests reserve a unique `(sending_account_id, idempotency_key)` pair to prevent double submission.
- Foreign keys use restrictive or nulling deletion behavior to preserve history.

## Local database

Laravel uses the local MySQL database `icf_investment`. A full `php artisan migrate:fresh --seed` completes successfully.

## Authentication foundation

- Public registration is intentionally absent: only administrator-created demo users are in scope.
- Login accepts only active accounts, regenerates the session, and throttles repeated failed attempts.
- Protected dashboard, profile, password update, and logout routes require both `auth` and active-account middleware.
- Passwords use Laravel hashing; profile updates use form requests and validated fields.
- Password-reset delivery remains deferred until a safe mail configuration is selected.

## Seeded fictional demo data

- Administrator: `admin@icf-investment.demo`
- Customer: `maya.bennett@icf-investment.demo`
- Password for local demonstration: `password`
- One active USD account with a reconciled `$1,000,000.00` balance.
- Two fictional beneficiaries plus twelve months of synthetic credit/debit activity.

The seed test verifies that total credits minus total debits exactly equals the displayed account balance.
