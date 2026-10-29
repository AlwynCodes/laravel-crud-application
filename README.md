# Laravel CRUD Application

A product inventory application built with Laravel 12 and Laravel Breeze, extended for
Laboratory No. 4 (Application Development and Emerging Technologies).

## Features

- **Role-based authorization** — administrators can create, edit and delete products;
  regular users can only browse. Enforced by route middleware, a policy, controller
  checks and hidden interface buttons.
- **Server-side validation** — Form Requests validate every field with per-field
  messages. Invalid input is never saved, and previously entered values are kept when
  validation fails.
- **Product images** — JPEG, PNG or WebP up to 2 MB, stored on the public disk. An image
  can be replaced (the old file is deleted only after the new one is saved) and is removed
  when the product is deleted.
- **Search and pagination** — filter products by name, eight per page, with the keyword
  preserved while paging.

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js 18 or newer (only needed to rebuild CSS/JS assets)
- MySQL (XAMPP) or SQLite

## Installation

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Open http://127.0.0.1:8000.

## Demo Accounts

| Email | Password | Role |
| --- | --- | --- |
| admin@example.com | password | admin |
| user@example.com | password | user |

## Tests

```bash
php artisan test
```

60 feature tests cover validation, authorization, image handling, search and pagination
(183 assertions).

## Screenshots

<img width="582" height="306" alt="Application preview" src="https://github.com/user-attachments/assets/05f33ed7-269d-455f-96af-d8fde31231f8" />
