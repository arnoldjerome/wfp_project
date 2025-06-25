<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        return view('frontend.customer.checkout', compact('cartItems', 'totalPrice'));
    }

    public function store(Request $request)
    {
        // Validasi hanya payment_method
        $request->validate([
            'payment_method' => 'required|in:cash,card',
        ]);

        // Dummy billing info (nanti bisa diganti pakai Auth::user())
        $orderData = [
            'first_name'      => 'John',
            'last_name'       => 'Doe',
            'email'           => 'johndoe@example.com',
            'phone'           => '081234567890',
            'address'         => 'Jalan Raya No. 123',
            'city'            => 'Denpasar',
            'postal_code'     => '80111',
            'payment_method'  => $request->payment_method,
            'notes'           => 'Please deliver between 10AM - 12PM',
        ];

        // Status berdasarkan metode pembayaran
        $status = $request->payment_method === 'card'
            ? 'Waiting for Payment'
            : 'Processing';

        // Ambil cart & total
        $cart = Session::get('cart', []);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Simpan ke session
        Session::put('last_order', [
            'customer' => $orderData,
            'items'    => $cart,
            'total'    => $totalPrice,
            'status'   => $status,
            'time'     => now()->toDateTimeString(),
        ]);

        // Kosongkan cart
        Session::forget('cart');

        // Redirect ke invoice
        return redirect()->route('invoice.show');
    }

    public function invoice()
    {
        $order = Session::get('last_order');

        if (!$order) {
            return redirect()->route('menu')->with('error', 'No invoice found.');
        }

        return view('frontend.customer.invoice', compact('order'));
    }
}
