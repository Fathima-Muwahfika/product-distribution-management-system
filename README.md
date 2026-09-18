# Kedalla Distributors – Product Distribution Management System

A full-featured Laravel web application built to manage end-to-end product distribution operations — from inventory and order intake to invoicing, delivery tracking, and reporting.

## About the Project

This is a final-year HNDIT project developed to digitize and streamline the workflow of a product distribution business. The system provides two role-based dashboards — **Admin** and **Sales Rep** — each scoped to the actions relevant to that role.

## Features

### Admin Dashboard
- **Product & Inventory Management** – Full CRUD on products, with stock batch tracking and per-product stock history
- **Auto-Generated Product Codes** – Automatic, consistent product code generation
- **Dynamic Category Management** – Add, edit, and organize product categories on the fly
- **Shop Management** – Manage registered shops/customers
- **Order Management** – View all orders, update order status, delete orders
- **Delivery Management** – Full CRUD on deliveries
- **Invoicing** – Generate invoices, mark as paid, bulk-pay multiple invoices, and download invoices as PDF
- **Reports** – Stock, orders, payments, deliveries, and sales rep performance reports
- **User & Sales Rep Management** – Create and manage admin/sales rep accounts
- **Notifications** – In-app notifications with mark-as-read / mark-all-as-read
- **Activity Log** – Audit trail of key actions across the system
- **Profile Management** – Update profile details and password

### Sales Rep Dashboard
- **Personal Dashboard** – Overview of own activity
- **Product Catalog (Read-Only)** – Browse available products
- **Shop Access** – View shops and register new ones
- **Order Placement** – Create, view, and delete own orders
- **Delivery Tracking (Read-Only)** – View delivery status for own orders
- **Profile Management** – Update own profile and password

## Tech Stack

- **Backend:** Laravel 10 (PHP 8.1)
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap
- **Auth:** Laravel Sanctum, custom role-based middleware (`admin`, `salesrep`)
- **PDF Generation:** barryvdh/laravel-dompdf

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (for asset building via Vite)
- XAMPP (or any local server environment)

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd kedalla-distributors

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Configure your database in .env
# DB_DATABASE=your_database_name
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed

# Build frontend assets
npm run dev

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Project Structure

```
app/
├── Http/Controllers/    # AuthController, DashboardController, ProductController,
│                         ShopController, OrderController, DeliveryController,
│                         InvoiceController, ReportController, UserController,
│                         SalesRepController, NotificationController, ProfileController
├── Models/               # Product, Shop, Order, OrderItem, Delivery, Invoice,
│                         StockBatch, StockHistory, ActivityLog, SystemNotification, User
database/
├── migrations/           # Schema for all core tables
routes/
├── web.php               # Admin and Sales Rep route groups (role-middleware protected)
```

## Roles & Access Control

Access is controlled via two custom middleware groups:
- `admin` – full system access
- `salesrep` – scoped access to own orders, shops, and read-only views

## Author

Fathima Muwahfika — HNDIT Final Year Project, SLIATE Kandy
