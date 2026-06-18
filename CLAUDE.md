# CLAUDE.md

Guidance for Claude Code when working in this repository.

## Project

Transaction Processing System (TPS) — an inventory / orders / purchasing admin app.
Mid-migration from a procedural-PHP app to a **Laravel 12 + Vue 3** stack.

- **New stack** lives at the repo root.
- **Legacy app** lives in `legacy/` (procedural PHP + AdminLTE). Reference only — do not extend it. Port features out of it instead.

## Stack

- **Backend:** Laravel 12, PHP 8.2+, REST API under `routes/api.php`.
- **Auth:** Laravel Sanctum, cookie/session SPA auth (not token headers). Access is **role-based** — `users.role` is one of `admin, manager, deliveries, orders, warehouse, staff`. The role → module map lives in `config/roles.php` (read via `App\Support\Roles`). See the Access control section below.
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
- **Tables**: build list views with the reusable `CrudTable` component (props: `title`, `endpoint`, `columns`, `fields`, optional `filterKeys`, `onChange`; emits `saved`). It provides search, column filters, click-to-sort, pagination, and the create/edit modal — pages just declare config.
  - **Column** config: `{ key, label, format?(value, row) }` — `format` renders a cell (e.g. dates as `MM/DD/YYYY`). Use dotted keys for relations (`category.name`).
  - **Field** config: `{ key, label, type?, options?, searchable?, placeholder?, default?, readonly?, generate? }`. `options` (array of `{value,label}`) renders a native `<select>`; add `searchable: true` to render the `SearchableSelect` combobox (type-ahead) instead. `type: 'textarea'` renders a full-width multi-line input. `default` seeds the value on create. `readonly: true` locks the input. `generate: '<endpoint>'` fetches a value to pre-fill on create (the response's `[key]`, falling back to the whole body) — used for previewing system-generated codes. All inputs get an auto placeholder (`Enter <label>` / `Select <label>`) unless overridden.
  - **Slots / exposed methods**: `#toolbar` adds buttons to the toolbar (next to New); `#row-actions="{ row }"` injects extra per-row buttons; the default slot mounts page-specific UI (drawers, panels, modals). The component exposes `reload()` (via `ref`) so a page can refresh the list after a custom action. See `Tasks.vue` (comments/status drawer) and `Users.vue` (provision-login modal).
  - **`onChange(key, value, formData)`** prop fires on every field change — use it to auto-fill dependent inputs (e.g. selecting an order fills customer/address). `@saved` fires after create/update/delete — use it to refresh dependent data (e.g. live product stock on the Orders page).
- **FK selects**: pages that need a dropdown of another resource fetch it on mount with `?per_page=1000` (controllers' `index` honour `per_page`, default 25) and map rows to `{value,label}`. See `Inventory.vue` (product+category), `Orders.vue` (customer+product), `Deliveries.vue` (order), `Tasks.vue` (employee).
- **System-generated codes**: `order_code` (`ORD-#####`) and delivery `control_number` (`DCN-######`) are assigned server-side in the controller `store()` (sequential off `max(id)+1`), never user-supplied — keep them out of the form `fields`. `employee_code` (`EMP-####`) is also server-generated in `store()` (off the highest existing numeric suffix), but is *shown* in the create form as a read-only, pre-filled field via the `readonly` + `generate` field options (see below) backed by `GET /api/employees/next-code`.
- **Access control (roles → modules)**: `config/roles.php` is the single source of truth — `gated` lists access-restricted module keys (`inventory_products`, `orders`, `deliveries`, `purchase_orders`), and `roles` maps each role to its modules (`admin` ⇒ `['*']` = all). Read it via `App\Support\Roles` (`names()`, `gated()`, `modulesFor()`, `canAccess()`). Enforce with the `module:<key>` middleware (`EnsureModuleAccess`) on route groups in `routes/api.php`; the Users area uses the `admin` middleware (`EnsureUserIsAdmin`). `User::isAdmin()` = `role === 'admin'`; `User::canAccessModule()` delegates to `Roles`. The User model **appends** a `modules` array to its JSON so the SPA gates the sidebar/router off the server-resolved list (no role map duplicated in JS) — see `auth` store getters `role`/`isAdmin`/`can(module)` and router `meta.module` guards. Open modules (dashboard, customers, employees, tasks) have no `module` meta. To add a gated module: add its key to `config/roles.php` + relevant roles, wrap its routes in `module:<key>`, and add `meta.module` to the route + `module` to the `AppLayout` nav item.
- **Per-resource authorization**: gate row-level actions with a Policy (auto-discovered by `Model`→`ModelPolicy` convention) and `$this->authorize('ability', $model)` in the controller (the base `Controller` uses `AuthorizesRequests`). Example: `TaskPolicy::manage` allows admins or the user linked to the task's assignee. Login accounts link to an employee via `users.employee_id` (nullable **unique** FK); that's how "is this user the assignee" is resolved.
- **Employee logins / temp passwords**: admins provision a login from the Users page ("Provision login" → `POST /api/users/provision`): username = `employee_code`, an auto-generated temp password is returned **once**, and `must_change_password` is set. The router's forced-change gate traps such accounts on `ChangePassword.vue` until they set a new password via `POST /api/change-password` (no current password required while forced; required otherwise). `UserController` blocks demoting/deleting the **last active admin**.
- **Stock**: `inventory.product_id` links stock to a catalog `product`. Orders validate `order_quantity` against `product.quantity` and adjust stock transactionally in `OrderController` (decrement on create, diff on update, restore on delete).
- **Auth is Sanctum SPA (cookie/session)**, not bearer tokens. Login flow: `GET /sanctum/csrf-cookie` → `POST /api/login`. Keep `SESSION_DOMAIN=null` for localhost (a bare `localhost` Domain attribute is browser-rejected → CSRF mismatch); only set a real domain in production. The SPA's served origin must be listed in `SANCTUM_STATEFUL_DOMAINS`.

## Migrating legacy data

The legacy MySQL dump is `legacy/model/tps.sql` (only 4 of ~11 tables; the rest were inferred from legacy CRUD code). Column names were modernised — map old → new when importing (`employee_id`→`employee_code`, `assigned`/`due`→`assigned_date`/`due_date`, `logs`→`activity_logs`, legacy `accounts`+`users` merged into `users`).
