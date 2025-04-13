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

Route::get("/category", [CategoryController::class, "totalFoods"]);

Route::get('/totalfood', [CategoryController::class,"totalFoods"]);

Route::resource("user", UserController::class);

Route::resource("order", OrderController::class);

// Report

Route::get('/Report_A', [ReportController::class,"reportA"]);