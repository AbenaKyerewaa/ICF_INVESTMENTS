# Phase 15: Security Hardening & Privacy Review

## Application: ICF Investment (Demo Portfolio Prototype)

---

### 1. Authorization & Access Control Review
- **Role Isolation**:
  - `EnsureUserIsAdministrator` middleware blocks regular `customer` accounts from accessing any `/admin/*` routes (enforcing strict HTTP 403 Forbidden).
  - Administrative self-lockout prevention: Administrators cannot disable their own active account.
- **Resource Ownership Enforcement (Anti-IDOR)**:
  - `AccountController@show`: Verifies `$account->user_id === $request->user()->id`.
  - `DocumentController@statement`: Verifies `$account->user_id === $request->user()->id`.
  - `DocumentController@receipt`: Verifies `$transfer->sendingAccount->user_id === $request->user()->id`.
  - `TransferController@receipt`: Verifies `$transfer->sendingAccount->user_id === $request->user()->id`.
  - `TransferController@review` & `confirm`: Verifies account & beneficiary belong to `$request->user()`.
  - `BeneficiaryController@update` & `deactivate`: Verifies `$beneficiary->user_id === $request->user()->id`.
  - `NotificationController@markAsRead` & `destroy`: Verifies `$notification->user_id === $request->user()->id`.

---

### 2. Financial Ledger & Concurrency Protections
- **Atomic Database Transactions**: All simulated transfer debits, clearing credits, and transfer states are encapsulated within `DB::transaction(...)`.
- **Pessimistic Row Locking**: `lockForUpdate()` is applied to both the customer account and clearing account to prevent double-spending in race conditions.
- **Strict Idempotency Keys**: Transfers store unique UUID idempotency keys scoped to the sending account to prevent duplicate submissions from network retries or repeated button clicks.
- **Immutable Ledger**: Entries are written to `ledger_entries` as append-only records with explicit credit/debit types and decimal precision (`BCMath`).

---

### 3. Privacy, Sensitive Data & Audit Integrity
- **Zero Plaintext Credentials**: All passwords hashed using bcrypt / Argon2id.
- **Audit Log Sanitization**:
  - Event listener `RecordAuthenticationAuditLog` explicitly filters incoming credentials. Passwords, secret tokens, and CSRF tokens are never written to `audit_logs` metadata.
  - Profile and password update audit records log metadata actions without capturing passwords or plaintext values.
- **No Real Banking Credentials or Rails**: Explicit simulation disclaimer banner maintained on every screen, export, statement, and error page.

---

### 4. Injection, CSRF & XSS Defenses
- **Escaped Blade Output**: All user-controlled fields rendered via standard `{{ ... }}` escaping.
- **CSRF Tokens**: All POST, PUT, PATCH, and DELETE routes require valid `@csrf` tokens.
- **Custom Error Views**: Custom 403, 404, 419, 429, and 500 error templates suppress stack traces and database credentials from public visitors.
- **Rate Limiting**:
  - `POST /login`: Protected by `throttle:10,1` and IP/email rate-limiter.
  - `PUT /profile/password`: Protected by `throttle:6,1`.
  - `POST /transfers/*`: Protected by `throttle:20,1`.

---

### 5. Production Deployment Recommendations
1. `APP_ENV=production` and `APP_DEBUG=false` in hosted `.env`.
2. `SESSION_SECURE_COOKIE=true` and HTTPS enforced across all endpoints.
3. Least-privilege MySQL user credentials configured with no DROP or ALTER database permissions in runtime web workers.
4. Run `npm run build` to generate hashed, minified production assets.
