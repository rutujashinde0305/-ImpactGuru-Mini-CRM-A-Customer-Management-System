# ImpactGuru Mini CRM

## Overview
Short description...

## Requirements
- PHP 8.1+
- Composer
- Node.js
- MySQL

## Installation
1. `git clone <repo>`
2. `cd impactguru-crm`
3. `composer install`
4. `cp .env.example .env` and configure DB
5. `php artisan key:generate`
6. `php artisan migrate --seed`
7. `php artisan storage:link`
8. `npm install && npm run dev`
9. `php artisan serve`

## Default Admin (for local testing)

- **Email:** `rutujashinde0305@gmail.com`
- **Password:** `admin123`

Note: This account is created/updated by `Database\Seeders\AdminSeeder`. Change the credentials in the seeder if you prefer a different admin.

## Features
- Authentication (Laravel Breeze)
- Roles: Admin & Staff
- Customers CRUD, profile image, soft deletes
- Orders CRUD, notifications
- Exports (CSV/PDF)
- REST API protected by Sanctum

## Roles & Permissions
- Admin: full access
- Staff: view/add/edit customers & orders (no delete users)
Project Description
-------------------
ImpactGuru Mini CRM is a lightweight customer & order management application built with Laravel and Blade. It provides basic CRM functionality for managing customers, orders, notifications (in-app), file uploads (profile images), PDF export, and a small role-based admin interface.

Installation Steps
# ImpactGuru Mini CRM — Internship Project

Project Title
-------------
ImpactGuru Mini CRM — A Customer Management System

Project Overview
----------------
This application helps manage customers, their orders, and access roles (Admin, Staff). The project demonstrates Laravel fundamentals: authentication (Breeze), routing, Eloquent, Blade, file uploads, middleware, notifications, REST APIs (Sanctum), and Git + GitHub usage.

Technical Requirements
----------------------
- Laravel 10/12 (project uses Laravel 12)
- PHP >= 8.1
- MySQL (or SQLite for quick local testing)
- Node.js + npm (build assets)

Quick Installation
------------------
1. Clone repository and enter folder:

	git clone https://github.com/rutujashinde0305/-ImpactGuru-Mini-CRM-A-Customer-Management-System.git
	cd impactguru-crm

2. Install dependencies:

	composer install
	npm install

3. Configure environment:

	cp .env.example .env
	php artisan key:generate
	Edit `.env` to set DB connection, `APP_URL`, `QUEUE_CONNECTION`, and `MAIL_*` if you plan to send email.

	Important `.env` keys:
	- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
	- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
	- `QUEUE_CONNECTION` (use `sync` for simple local tests)

4. Migrate and seed sample data:

	php artisan migrate --seed

5. Prepare storage and build assets:

	php artisan storage:link
	npm run build   # or `npm run dev` during development

6. Run the app locally:

	php artisan serve

Note: A SQL dump is provided as `database.sql` for quick import if you prefer that to running migrations.

Feature List
------------
- Authentication and password reset (Laravel Breeze)
- Role-based access control: `admin` and `staff` roles
- Customers: CRUD, profile image upload, soft deletes, export CSV/PDF
- Orders: CRUD, linked to customers, filtering by status, export CSV/PDF
- In-app notifications (database channel) with toast popups for admins
- REST API endpoints protected with Laravel Sanctum
- Form request validation and custom error pages (404, 500)

Project Modules (mapping to requirements)
---------------------------------------
1) Authentication
	- Implemented via Laravel Breeze (views in `resources/views/auth`).
	- Auth middleware applied to protected routes.

2) Customer Management
	- Model: `app/Models/Customer.php`
	- Migration: `database/migrations/*create_customers_table.php`
	- Controller: `app/Http/Controllers/CustomerController.php`
	- Validation: `app/Http/Requests/StoreCustomerRequest.php`, `UpdateCustomerRequest.php`
	- Views: `resources/views/customers/*` (index/create/edit/show/trashed)

3) Order Management
	- Model: `app/Models/Order.php`
	- Migration: `database/migrations/*create_orders_table.php`
	- Controller: `app/Http/Controllers/OrderController.php`
	- Views: `resources/views/orders/*`

4) Search & Filtering
	- Customer AJAX search endpoint: `CustomerController::ajaxSearch`
	- Orders filter by status available in UI and API

5) Dashboard
	- Admin and Staff dashboards with key statistics: `app/Http/Controllers/DashboardController.php` and `resources/views/dashboard/*`

6) REST API
	- Routes: `routes/api.php` (protected by `auth:sanctum`)
	- Controllers: `app/Http/Controllers/Api/CustomerApiController.php`, `OrderApiController.php`
	- Admin-only protections applied to update/delete via `admin` middleware

7) Notifications
	- Notification classes: `app/Notifications/NewCustomerNotification.php`, `NewOrderNotification.php`
	- AJAX polling controller: `app/Http/Controllers/AjaxNotificationController.php`
	- Migration for `notifications` table included

API Usage (Sanctum)
-------------------
The API routes are protected by Laravel Sanctum. To call the API you need an authenticated token.

One simple way to create a token for a user (development):

1. Use Tinker to create a personal access token:

	php artisan tinker
	>>> $user = \\App\\Models\\User::where('email', 'rutujashinde0305@gmail.com')->first();
	>>> $token = $user->createToken('api-token');
	>>> $token->plainTextToken

2. Use the token in requests:

	curl -H "Authorization: Bearer <token>" http://127.0.0.1:8000/api/customers

If you prefer, add an API login endpoint that calls `$user->createToken(...)` upon successful credentials authentication.

Example API endpoints

- GET `/api/customers` — list customers (paginated)
- GET `/api/customers/{id}` — retrieve customer
- POST `/api/customers` — create customer
- PUT `/api/customers/{id}` — update (admin only)
- DELETE `/api/customers/{id}` — delete (admin only)

Notes on Email Notifications
---------------------------
- The app uses database notifications by default (`database` channel) so admins receive in-app toast alerts.
- If you want email notifications, set `MAIL_MAILER` and the `MAIL_*` values in `.env` and change the notification `via()` to include `'mail'` (notification classes already have `toMail()` implemented). For Gmail SMTP use an App Password.

Security & Cleanup Before Submission
-----------------------------------
- Remove any debug or local-only routes (there is currently a temporary debug POST route for `orders/{order}` in `routes/web.php`).
- Ensure `.env.example` contains no real credentials (it should contain placeholders) — do not commit your real `.env`.

Submission Checklist
--------------------
- Source code pushed to GitHub (this repo)
- `.env.example` included
- `README.md` (this file) — installation and usage
- `database.sql` (SQL dump) included
- Screenshots (optional) in `images/` if desired

Optional next steps I can do for you
-----------------------------------
- Clean and consolidate the `README.md` (I will commit and push the cleaned version if you want).
- Add short API examples (curl/postman) or include a small script that creates a personal token.
- Remove the temporary debug route and push the change.

Contact / Notes
---------------
If you want me to make the README edits now and push them to GitHub, reply: "Yes — update README" and tell me whether to keep or remove the demo admin credentials listed in the README.
