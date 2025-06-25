<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.customer.home');
})->name('home');

Route::get('/menu', function () {
    return view('frontend.customer.catalog'); // Atau sesuaikan dengan struktur foldermu
})->name('menu');


Route::get('/before_order', function () {
    return view('before_order');
});

Route::get('/menu/{type}', function ($type) {
    return view('menu', compact('type'));
});

// Master
Route::resource("food", FoodController::class);

Route::resource("category", CategoryController::class);

Route::get('/totalfood', [CategoryController::class, 'index'])->name('category.index');

Route::resource("user", UserController::class);

Route::resource("order", OrderController::class);

Route::get("report", [ReportController::class, 'index'])->name('report.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
