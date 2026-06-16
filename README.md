# Transaction Processing System

## Overview
The **Transaction Processing System (TPS)** is a robust and scalable system designed to efficiently handle and manage transactions in a secure and reliable manner. It ensures accurate processing of transactions while maintaining data integrity and security.

## Features
- Secure transaction handling
- Real-time processing
- Data integrity and consistency
- User authentication and authorization
- Scalable and efficient performance
- Comprehensive logging and reporting

## Technologies Used (Laravel + Vue rewrite)
- Database: PostgreSQL
- Backend Framework: Laravel 12 (REST API, Sanctum SPA auth)
- Frontend: Vue 3 + Vite + Vue Router + Pinia

> The original procedural-PHP application now lives under `legacy/` for reference
> during the port. The new stack lives at the repository root.

## Local setup

Prerequisites: PHP 8.2+, Composer, Node 18+, PostgreSQL.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate

# create a `tps` database in Postgres, then:
php artisan migrate --seed     # builds schema + seeds admin (username: test / password: test)

# run both servers (two terminals):
php artisan serve              # http://localhost:8000
npm run dev                    # Vite dev server for hot-reloaded Vue
```

Open http://localhost:8000 and log in with `test` / `test`.

### Architecture
- `app/Models` — Eloquent models (Category, Inventory, Product, Customer, Employee, Order, Task, Delivery, PurchaseOrder, User, ActivityLog).
- `app/Http/Controllers/Api` — RESTful resource controllers; routes in `routes/api.php`.
- `database/migrations` — schema derived from the legacy `model/tps.sql` dump plus tables inferred from the legacy CRUD code.
- `resources/js` — Vue SPA (router, Pinia auth store, reusable `CrudTable`, one page per module).
- Auth: Sanctum cookie/session SPA auth; `access` 1 = admin, 2 = user (enforced by the `role` middleware).

### Migrating legacy data
The legacy MySQL `tps` dump is at `legacy/model/tps.sql`. Column names were
modernised (e.g. `employee_id` → `employee_code`, `assigned`/`due` → `assigned_date`/`due_date`,
`logs` → `activity_logs`). Map columns accordingly when importing old data into Postgres.
