# Phase 2 — Product scope and acceptance criteria

Status: approved initial scope, 2026-10-20. These are deliberately small, changeable prototype decisions, not real financial-product requirements.

## Product definition

ICF Investment is a portfolio-quality **investment/banking-style dashboard prototype**. It displays entirely fictional account activity and supports simulated transfers only. It is not a licensed financial institution and must never accept real deposits, collect banking credentials, connect to bank/payment rails, or execute real payments.

## Initial product decisions

| Decision | Initial value |
| --- | --- |
| Currency | USD (`USD`, `$`) |
| Starting account balance | $1,000,000.00 DEMO/SIMULATED |
| Accounts per customer | One primary demo account in the first release |
| Transaction-history period | Twelve months of fictional, reconciled history |
| Account creation | Administrator-created demo users only; no public registration |
| Customer role | Full access to only their own demo profile, account, beneficiaries, documents, notifications, and simulated transfers |
| Administrator role | Protected user/account administration plus audit-log access |
| Support role | Deferred; not included in the first release |

## Required first-release screens

- Public landing page with an unambiguous DEMO/SIMULATED disclaimer.
- Login/logout, profile, password change, and password reset when mail delivery is configured.
- Customer dashboard, account details, searchable/filterable/paginated transaction history, and responsive empty/error states.
- Beneficiary management before the simulated-transfer flow.
- Simulated transfer: input, server-side validation, review, confirmation, receipt, notification, and audit event.
- Downloadable DEMO/SIMULATED transfer receipts and date-range account statements.
- Activity charts derived from stored data.
- Protected administrator dashboard, user/account controls, and paginated audit-log viewer.

## Deferred or explicitly out-of-scope

- Real money, real bank connections, payment processors, mobile money, investment execution, deposits, withdrawals, or banking credentials.
- Public registration and the support role.
- Invoices, unless a later scope change defines their issuer, recipient, totals, and lifecycle.
- Investment advice, performance guarantees, or claims of regulated status.

## Simulated transfer rules

1. A customer can select only an active beneficiary they own.
2. The server validates account ownership, active status, positive USD amount, sufficient available demo balance, and optional reference length.
3. The review page repeats the server-validated details; the browser never supplies an authoritative balance or status.
4. The initial synchronous workflow completes immediately on success. A validation or persistence problem produces `failed` with no partial ledger/balance change. `pending` is reserved for a future deliberately asynchronous simulation.
5. A successful transfer creates an immutable ledger record and a transfer reference. For external simulated beneficiaries, the corresponding side is a defined demo clearing/suspense account, never a real recipient account.
6. An account-scoped, database-enforced idempotency key ensures a repeated submission returns the original result and never double-debits.
7. All displayed balances reconcile to the authoritative ledger. Cached balances, if introduced, are updated in the same database transaction only.

## Release acceptance criteria

| Feature | Acceptance criteria |
| --- | --- |
| Demo boundary | Every public, account, transfer, receipt, and statement surface visibly identifies the product/data as DEMO/SIMULATED. |
| Authentication | Guests cannot access private routes; passwords are hashed; logout invalidates the session; login is rate-limited. |
| Authorization | Customers cannot access another customer's records by modifying IDs or request data; administrators are protected server-side. |
| Ledger and balances | Monetary values use decimal columns; ledger history is immutable; opening balance plus credits minus debits equals the displayed closing balance. |
| Transfers | Invalid, unauthorized, duplicate, or insufficient-funds requests fail safely; successful transfers are atomic, traceable, and receipted. |
| Beneficiaries | A customer can create, update, and deactivate only their own fictional beneficiaries without erasing historical transfers. |
| Documents | Customers may download only their own readable, reconciled, DEMO/SIMULATED receipts and statements. |
| Admin and audit | Regular customers cannot reach admin tools; important authentication, transfer, profile, and administrator actions create append-only, secret-free audit records. |
| Quality | A clean local setup can migrate and seed; critical automated tests pass; desktop and mobile layouts are usable. |

## Next phase

Phase 3 will turn this scope into the design system, responsive navigation plan, state patterns, and reusable UI-component list.
