# CLAUDE.md

Guidance for Claude Code when working in this repository.

## Project

Transaction Processing System (TPS) — an inventory / orders / purchasing admin app.
Mid-migration from a procedural-PHP app to a **Laravel 12 + Vue 3** stack.

- **New stack** lives at the repo root.
- **Legacy app** lives in `legacy/` (procedural PHP + AdminLTE). Reference only — do not extend it. Port features out of it instead.

## Stack

- **Backend:** Laravel 12, PHP 8.2+, REST API under `routes/api.php`.
- **Auth:** Laravel Sanctum, cookie/session SPA auth (not token headers). `access` column: `1` = admin, `2` = user; enforced by the `role` middleware (`app/Http/Middleware/EnsureUserHasRole.php`).
- **Database:** PostgreSQL (`DB_CONNECTION=pgsql`).
- **Frontend:** Vue 3 + Vite + Vue Router + Pinia, in `resources/js/`.

## Layout

| Path | Contents |
|------|----------|
| `app/Models/` | Eloquent models |
| `app/Http/Controllers/Api/` | REST resource controllers |
| `routes/api.php` | API routes (auth + apiResource) |
| `routes/web.php` | Catch-all serving the Vue SPA shell |
| `database/migrations/` | Schema (framework tables prefixed `0001_…`, domain tables `2026_…`) |
| `database/factories/` | Model factories for every entity (used by the seeder) |
| `database/seeders/` | `DatabaseSeeder` — admin/staff users + full faker dataset across all tables |
| `resources/js/` | Vue SPA: `pages/`, `components/`, `layouts/`, `stores/`, `router/` |
| `resources/css/app.css` | Design system: theme tokens (light/dark) + shared `.btn`/`.input`/`.card` classes |
| `legacy/` | Original PHP app — read-only reference |

## Commands

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed     # builds schema + seeds full test dataset
                               # logins: test/test (admin), staff/password (user)
php artisan migrate:fresh --seed  # wipe + reseed fresh faker data anytime
php artisan serve              # backend  http://localhost:8000
npm run dev                    # Vite dev server (Vue HMR) — Laravel auto-detects the port via public/hot
npm run build                  # production assets (use instead of `npm run dev` if you don't need HMR)
php artisan test               # tests
./vendor/bin/pint              # format PHP (run before committing)
```

**Database:** default is PostgreSQL (`DB_CONNECTION=pgsql`). For a zero-install local run, set
`DB_CONNECTION=sqlite`, `touch database/database.sqlite`, then `php artisan migrate --seed`.

## Conventions

- **Validate every write** in the controller (Laravel `validate()` / Form Requests). The legacy code had SQL injection from raw string concatenation — never reproduce that; use Eloquent / query bindings only.
- **No hardcoded credentials.** Everything via `.env` (the legacy `app/database.php` hardcoded `root`/no-password — do not copy).
- **REST CRUD** maps to `index/store/show/update/destroy`. New modules: add a model + migration + `Api/*Controller` + an `apiResource` route + a Vue page using the reusable `CrudTable` component.
- **Column naming:** legacy business IDs were renamed to `*_code` (e.g. `employee_code`), and FK columns are `*_id`. Keep this when porting more legacy tables.
- Frontend talks to the API via the global `window.axios` (configured for Sanctum CSRF in `resources/js/bootstrap.js`).
- **UI**: minimalist design system driven by CSS variables in `resources/css/app.css`; dark mode via `data-theme` on `<html>`, managed by the `theme` Pinia store (persisted to `localStorage`). Use the shared `.btn`/`.input`/`.card`/`.badge` classes and theme tokens (`var(--surface)`, `var(--text)`, etc.) — don't hardcode colours. The `AppLayout` provides sidebar + topbar (theme toggle + user dropdown → Profile/Settings/Logout).
- **Tables**: build list views with the reusable `CrudTable` component (props: `title`, `endpoint`, `columns`, `fields`, optional `filterKeys`). It provides search, column filters, click-to-sort, pagination, and the create/edit modal — pages just declare config.
- **Auth is Sanctum SPA (cookie/session)**, not bearer tokens. Login flow: `GET /sanctum/csrf-cookie` → `POST /api/login`. Keep `SESSION_DOMAIN=null` for localhost (a bare `localhost` Domain attribute is browser-rejected → CSRF mismatch); only set a real domain in production. The SPA's served origin must be listed in `SANCTUM_STATEFUL_DOMAINS`.

## Migrating legacy data

The legacy MySQL dump is `legacy/model/tps.sql` (only 4 of ~11 tables; the rest were inferred from legacy CRUD code). Column names were modernised — map old → new when importing (`employee_id`→`employee_code`, `assigned`/`due`→`assigned_date`/`due_date`, `logs`→`activity_logs`, legacy `accounts`+`users` merged into `users`).
