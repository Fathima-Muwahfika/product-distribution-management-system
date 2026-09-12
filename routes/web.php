<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesRepController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

// ── Login / Logout ──
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── ADMIN ROUTES ──
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products / Inventory
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/stock-in', [ProductController::class, 'stockIn'])->name('products.stockIn');
    Route::get('/products/{product}/history', [ProductController::class, 'history'])->name('products.history');

    // Shops
    Route::resource('shops', ShopController::class);

    // Orders (Admin sees all)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Deliveries
    Route::resource('deliveries', DeliveryController::class);

    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'markAsPaid'])->name('invoices.pay');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::post('/invoices/bulk-pay', [InvoiceController::class, 'bulkPay'])->name('invoices.bulkPay');

    // Reports
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/deliveries', [ReportController::class, 'deliveries'])->name('reports.deliveries');
    Route::get('/reports/salesrep', [ReportController::class, 'salesRep'])->name('reports.salesrep');

    // User / Sales Rep Management
    Route::resource('users', UserController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    // Activity Log
    Route::get('/activity-log', [DashboardController::class, 'activityLog'])->name('activity.log');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ── SALES REP ROUTES ──
Route::middleware(['auth', 'salesrep'])->group(function () {

    // Sales Rep Dashboard
    Route::get('/salesrep/dashboard', [SalesRepController::class, 'dashboard'])->name('salesrep.dashboard');

    // View Products (read only)
    Route::get('/salesrep/products', [ProductController::class, 'salesRepIndex'])->name('salesrep.products');

    // Shops (Sales Rep can view + create)
    Route::get('/salesrep/shops', [ShopController::class, 'salesRepIndex'])->name('salesrep.shops');
    Route::get('/salesrep/shops/create', [ShopController::class, 'salesRepCreate'])->name('salesrep.shops.create');
    Route::post('/salesrep/shops/store', [ShopController::class, 'salesRepStore'])->name('salesrep.shops.store');

    // Orders (Sales Rep creates & views own orders only)
    Route::get('/salesrep/orders', [OrderController::class, 'salesRepIndex'])->name('salesrep.orders');
    Route::get('/salesrep/orders/create', [OrderController::class, 'salesRepCreate'])->name('salesrep.orders.create');
    Route::post('/salesrep/orders/store', [OrderController::class, 'salesRepStore'])->name('salesrep.orders.store');
    Route::get('/salesrep/orders/{order}', [OrderController::class, 'salesRepShow'])->name('salesrep.orders.show');
    Route::delete('/salesrep/orders/{order}', [OrderController::class, 'salesRepDestroy'])->name('salesrep.orders.destroy');

    // View Deliveries (read only)
    Route::get('/salesrep/deliveries', [DeliveryController::class, 'salesRepIndex'])->name('salesrep.deliveries');

    // Sales Rep Profile
    Route::get('/salesrep/profile', [ProfileController::class, 'index'])->name('salesrep.profile');
    Route::post('/salesrep/profile/update', [ProfileController::class, 'update'])->name('salesrep.profile.update');
    Route::post('/salesrep/profile/password', [ProfileController::class, 'updatePassword'])->name('salesrep.profile.password');
});