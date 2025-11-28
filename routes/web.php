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
});

