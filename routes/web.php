<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;


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

Route::resource("food", FoodController::class);

Route::resource('listmakanan', FoodController::class );

Route::get('/totalfood', [CategoryController::class,"totalFoods"]);

Route::resource('category', CategoryController::class );
