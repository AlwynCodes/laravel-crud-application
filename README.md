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

## How to run

```bash
## Installing
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install

## Running
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

# System Screenshots
## Admin | Dashboard  
<img width="1919" height="966" alt="image" src="https://github.com/user-attachments/assets/4dc768db-916c-4b8c-83d9-1500022b1e69" />

## Admin | Add Products
<img width="1919" height="965" alt="image" src="https://github.com/user-attachments/assets/0d1f0659-8506-473e-a4b8-d4d141176766" />

## Admin | Edit Products
<img width="1919" height="962" alt="image" src="https://github.com/user-attachments/assets/81eb3770-e1bc-4bb0-a835-eabb7801d74e" />

## Admin | View Products
<img width="1919" height="963" alt="image" src="https://github.com/user-attachments/assets/27e2cd73-94e6-4168-98d3-8ed79eaebddf" />


## User | Dashboard
<img width="1919" height="964" alt="image" src="https://github.com/user-attachments/assets/fcaa4291-c941-4d54-a304-d20ccc35d376" />

## User | View Products
<img width="1919" height="964" alt="image" src="https://github.com/user-attachments/assets/b21b2284-d810-4bbe-b561-c78efced3781" />


