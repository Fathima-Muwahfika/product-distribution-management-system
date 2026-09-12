# Kedalla Distributors – Product Distribution Management System

A Laravel-based web application built to manage product distribution operations, including stock batch tracking, category management, and sales representative order handling.

## About the Project

This is a final-year HNDIT project developed to digitize and streamline the workflow of a product distribution business — from inventory intake to sales rep ordering.

## Features

- **Stock Batch Tracking** – Track inventory by batch for better traceability
- **Auto-Generated Product Codes** – Automatic, consistent product code generation
- **Dynamic Category Management** – Add, edit, and organize product categories on the fly
- **Sales Rep Order Interface** – Dedicated interface for sales representatives to place and manage orders

## Tech Stack

- **Backend:** Laravel (PHP)
- **Database:** MySQL
- **Frontend:** Bootstrap

## Getting Started

### Prerequisites
- PHP >= 8.x
- Composer
- MySQL
- XAMPP (or any local server environment)

### Installation

```bash
# Clone the repository
git clone https://github.com/your-username/product-distribution-management-system.git

# Navigate into the project
cd product-distribution-management-system

# Install dependencies
composer install

# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env, then run migrations
php artisan migrate

# Start the development server
php artisan serve
```

## Author

Fathima Muwahfika – HNDIT Final Year Student, SLIATE Kandy

## License

This project was developed for academic purposes as part of an HNDIT final-year project.
