<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'apiIndex']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('menu-items', MenuItemController::class);
Route::apiResource('tables', TableController::class);
Route::apiResource('orders', OrderController::class);
