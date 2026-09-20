<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.page');
Route::view('/categories', 'erp.categories')->name('categories');
Route::view('/menu-items', 'erp.menu-items')->name('menu-items');
Route::view('/tables', 'erp.tables')->name('tables');
Route::view('/orders', 'erp.orders')->name('orders');
