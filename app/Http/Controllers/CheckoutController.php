<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Session::get('cart', []);
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $orderType = $request->cookie('order_type', 'dinein');
        $takeawayFee = 3000;
        $finalTotal = $totalPrice;

        if ($orderType === 'takeaway') {
            $finalTotal += $takeawayFee;
        }

        return view('frontend.customer.checkout', compact(
            'cartItems',
            'totalPrice',
            'orderType',
            'takeawayFee',
            'finalTotal'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card',
        ]);

        $orderType = $request->order_type ?? 'dinein';
        $takeawayFee = ($orderType === 'takeaway') ? 3000 : 0;

        // Dummy billing data
        $orderData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '081234567890',
            'address' => 'Jalan Raya No. 123',
            'city' => 'Denpasar',
            'postal_code' => '80111',
            'payment_method' => $request->payment_method,
            'notes' => 'Please deliver between 10AM - 12PM',
            'order_type' => $orderType,
        ];

        $status = $request->payment_method === 'card'
            ? 'Waiting for Payment'
            : 'Processing';

        $cart = Session::get('cart', []);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $finalTotal = $totalPrice + $takeawayFee;

        Session::put('last_order', [
            'customer' => $orderData,
            'items' => $cart,
            'total' => $totalPrice,
            'takeaway_fee' => $takeawayFee,
            'final_total' => $finalTotal,
            'order_type' => $orderType, // ← INI TAMBAHAN PENTING
            'status' => $status,
            'time' => now()->toDateTimeString(),
        ]);


        Session::forget('cart');

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
