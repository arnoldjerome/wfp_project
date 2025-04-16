<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/before_order', function () {
    return view('before_order');
});

Route::get('/menu/{type}', function ($type) {
    return view('menu', compact('type'));
});

Route::get('/admin/categories', function () {
    return view('admin.categories');
});

Route::get('/admin/order', function () {
    return view('admin.order');
});

Route::get('/admin/members', function () {
    return view('admin.members');
});

// Master
Route::resource("food", FoodController::class);

Route::resource("category", CategoryController::class);

Route::get('/totalfood', [CategoryController::class, 'index'])->name('category.index');

Route::resource("user", UserController::class);

Route::resource("order", OrderController::class);

Route::get("report", [ReportController::class, 'index'])->name('report.index');