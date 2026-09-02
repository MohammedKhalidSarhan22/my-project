# Restaurant ERP (Laravel API + Blade)

This project is a restaurant management ERP built with Laravel. It includes both:

- REST API endpoints for categories, menu items, tables, orders, and dashboard data
- Blade admin panels for dashboard and operational views

## Features

- Dashboard overview with sales and table status summary
- Menu categories management
- Menu items catalog with pricing and stock
- Restaurant tables status tracking
- Orders and order items with statuses
- SQLite database schema and demo seed data

## Local development

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Copy the environment file and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Run the migrations and seed demo data:
   ```bash
   php artisan migrate --seed
   ```
4. Start the app:
   ```bash
   php artisan serve
   ```
5. Open the Blade dashboard:
   - http://localhost:8000
   - http://localhost:8000/dashboard

## API routes

- GET /api/dashboard
- GET /api/categories
- POST /api/categories
- GET /api/menu-items
- POST /api/menu-items
- GET /api/tables
- POST /api/tables
- GET /api/orders
- POST /api/orders

## Blade pages

- /
- /dashboard
- /categories
- /menu-items
- /tables
- /orders
