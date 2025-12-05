<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\RestockConfirmationController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

// Landing and Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Dashboard and Management)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inventory Routes
    Route::resource('inventory', InventoryController::class);

    // Product Routes
    Route::resource('products', ProductController::class);

    // Category Routes
    Route::resource('categories', CategoryController::class);

    // Supplier Routes
    Route::resource('suppliers', SupplierController::class);

    // Transaction Routes
    Route::resource('transactions', TransactionController::class);

    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/inventory/pdf', [ReportController::class, 'inventoryPdf'])->name('reports.inventory.pdf');
    Route::get('/reports/supplier', [ReportController::class, 'supplier'])->name('reports.supplier');

    // Admin Settings Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });

    // Quality Control (Defect) Routes
    Route::resource('/defects', QualityController::class);
    Route::post('/defects/{defect}/approve', [QualityController::class, 'approve'])->name('defects.approve');
    Route::post('/defects/{defect}/reject', [QualityController::class, 'reject'])->name('defects.reject');

    // Warehouse Routes
    Route::resource('warehouses', WarehouseController::class);

    // Alert Routes
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts/{alert}/read', [AlertController::class, 'markAsRead'])->name('alerts.read');
    Route::post('/alerts/mark-all-read', [AlertController::class, 'markAllAsRead'])->name('alerts.mark-all-read');
    Route::get('/alerts/unread-count', [AlertController::class, 'unreadCount'])->name('alerts.unread-count');

    // Restock Confirmation Routes
    Route::resource('restock', RestockConfirmationController::class);
    Route::post('/restock/{restockConfirmation}/approve', [RestockConfirmationController::class, 'approve'])->name('restock.approve');
    Route::post('/restock/{restockConfirmation}/complete', [RestockConfirmationController::class, 'complete'])->name('restock.complete');
    Route::post('/restock/{restockConfirmation}/reject', [RestockConfirmationController::class, 'reject'])->name('restock.reject');

    // Pending Messages Routes (Admin only)
    Route::prefix('pending')->name('pending.')->group(function () {
        Route::get('/', [PendingController::class, 'index'])->name('index');
        Route::get('/{pending}', [PendingController::class, 'show'])->name('show');
        Route::get('/count', [PendingController::class, 'count'])->name('count');
    });

    // POS Routes
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::get('/products', [PosController::class, 'getProducts'])->name('products');
        Route::get('/stock/{productId}', [PosController::class, 'getStock'])->name('stock');
        Route::post('/sale', [PosController::class, 'processSale'])->name('sale');
    });
});

