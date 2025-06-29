<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Session::get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('menu')->with('error', 'Keranjang anda masih kosong');
        }
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
            'order_type' => 'required|in:dinein,takeaway'
        ]);

        $orderType = $request->order_type ?? 'dinein';
        $takeawayFee = ($orderType === 'takeaway') ? 3000 : 0;

        $user = Auth::user();

        $orderData = [
            'name' => $user->name,
            'email' => $user->email,
            'payment_method' => $request->payment_method,
            'notes' => 'Please deliver between 10AM - 12PM',
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
            'order_date' => now()->format('Y-m-d'),
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
