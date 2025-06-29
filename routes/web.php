<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Models\Food;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== FRONTEND ROUTES ========== //
// Halaman utama redirect jika belum logged in
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    if (Gate::allows('access-admin')) {
        return redirect()->route('dashboard.index');
    }

    if (Gate::allows('access-customer')) {
        return redirect()->route('customer.home');
    }

    abort(403, 'Unauthorized');
})->name('root');


Route::get('/home', function () {
    return view('frontend.customer.home');
})->name('customer.home')
  ->middleware(['auth', 'can:access-customer']);

// hanya admin
// ========== MASTER DATA (CRUD) ========== //

Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::resource('food', FoodController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('user', UserController::class);
    Route::resource('order', OrderController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');
    Route::get('/totalfood', [CategoryController::class, 'index'])
        ->name('category.index');
    Route::get('/report', [ReportController::class, 'index'])
        ->name('report.index');
});

// hanya customer
Route::middleware(['auth', 'can:access-customer'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');

    // Halaman kustomisasi menu (hanya jika ada add-on)
    Route::get('/customize/{name}', function ($name) {
        $food = Food::where('name', $name)->first();
        if (!$food) {
            return redirect()->route('menu')->with('error', 'Menu tidak ditemukan.');
        }
        $addons = \DB::table('add_ons')->where('food_id', $food->id)->get();
        if ($addons->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Menu ini tidak memiliki add-on.');
        }
        return view('frontend.customer.customize', compact('name', 'addons'));
    })->name('customize.page');

    Route::post('/customize/{name}', [CartController::class, 'addToCart'])->name('customize.add');

    Route::post('/set-order-type', function (Request $request) {
        $orderType = $request->input('order_type', 'dinein');
        return redirect()->route('menu')->withCookie(cookie('order_type', $orderType, 60));
    })->name('order.type.set');

    // ========== CART (TANPA DATABASE) ========== //

    Route::get('/cart', function () {
        $cartItems = Session::get('cart', []);
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('frontend.customer.cart', compact('cartItems', 'totalPrice'));
    })->name('cart.index');

    Route::post('/cart/add', function (Request $request) {
        $cart = Session::get('cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ($item['name'] === $request->name) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'name' => $request->name,
                'price' => (float) $request->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);
        return back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    })->name('cart.add');

    Route::post('/cart/update', function (Request $request) {
        $cart = Session::get('cart', []);
        foreach ($cart as &$item) {
            if ($item['name'] === $request->name) {
                $item['quantity'] = max(1, (int) $request->quantity);
                break;
            }
        }

        Session::put('cart', $cart);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    })->name('cart.update');

    Route::post('/cart/clear', function () {
        Session::forget('cart');
        return redirect()->route('menu')->with('success', 'Keranjang berhasil dikosongkan.');
    })->name('cart.clear');

    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // ========== CHECKOUT ==========   

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/invoice', [CheckoutController::class, 'invoice'])->name('invoice.show');
});


Auth::routes();
