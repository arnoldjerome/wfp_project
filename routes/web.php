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
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

// ========== FRONTEND ROUTES ========== //

// Route untuk halaman utama
Route::get('/', fn() => view('frontend.customer.home'))->name('home');

// Route untuk menu
Route::get('/menu', fn() => view('frontend.customer.catalog'))->name('menu');

// Route untuk halaman kustomisasi item
Route::get('/customize/{name}', function ($name) {
    return view('frontend.customer.customize', compact('name'));
})->name('customize.page');

// Route untuk menambahkan item ke cart
Route::post('/customize/{name}', [CartController::class, 'addToCart'])->name('customize.add');

// Route untuk sebelum order
Route::get('/before_order', fn() => view('before_order'));

// Route untuk tipe menu
Route::get('/menu/{type}', fn($type) => view('menu', compact('type')));

// ========== MASTER DATA ========== //

// Route untuk resource food (CRUD)
Route::resource("food", FoodController::class);

// Route untuk resource category (CRUD)
Route::resource("category", CategoryController::class);

// Route untuk menampilkan total food
Route::get('/totalfood', [CategoryController::class, 'index'])->name('category.index');

// Route untuk resource user (CRUD)
Route::resource("user", UserController::class);

// Route untuk resource order (CRUD)
Route::resource("order", OrderController::class);

// Route untuk laporan
Route::get("report", [ReportController::class, 'index'])->name('report.index');

// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// ========== CART (SEMENTARA TANPA DATABASE) ========== //

// Route untuk menampilkan isi cart
Route::get('/cart', function () {
    $cartItems = Session::get('cart', []);
    $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    return view('frontend.customer.cart', compact('cartItems', 'totalPrice'));
})->name('cart.index');

// Route untuk menambah item ke cart
Route::post('/cart/add', function (Request $request) {
    $cart = Session::get('cart', []);
    $found = false;

    // Cek apakah item sudah ada di cart, jika ada, tambahkan quantity
    foreach ($cart as &$item) {
        if ($item['name'] === $request->name) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Jika item belum ada, tambahkan item baru ke cart
    if (!$found) {
        $cart[] = [
            'name' => $request->name,
            'price' => (float) $request->price,
            'quantity' => 1,
        ];
    }

    // Simpan cart di session
    Session::put('cart', $cart);
    return back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
})->name('cart.add');

// Route untuk AJAX update quantity
Route::post('/cart/update', function (Request $request) {
    $cart = Session::get('cart', []);
    
    // Update jumlah item
    foreach ($cart as &$item) {
        if ($item['name'] === $request->name) {
            $item['quantity'] = max(1, (int) $request->quantity); // Pastikan qty tidak kurang dari 1
            break;
        }
    }

    // Simpan cart di session
    Session::put('cart', $cart);
    $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    return response()->json([
        'success' => true,
        'cart' => $cart,
        'totalPrice' => $totalPrice,
    ]);
})->name('cart.update');

// Route untuk mengosongkan cart
Route::post('/cart/clear', function () {
    Session::forget('cart');
    return redirect()->route('menu')->with('success', 'Keranjang berhasil dikosongkan.');
})->name('cart.clear');

// ========== CHECKOUT ========== //

// Route untuk menampilkan halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Route untuk menyimpan data checkout (POST)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Route untuk menampilkan invoice
Route::get('/invoice', [CheckoutController::class, 'invoice'])->name('invoice.show');

// ========== CART (DENGAN DATABASE) ========== //

// Update item di cart (menggunakan PUT)
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// Menghapus item dari cart (menggunakan DELETE)
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
