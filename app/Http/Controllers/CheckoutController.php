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
use Illuminate\Support\Str;

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

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total_price' => $totalPrice,
            'final_price' => $finalTotal,
            'payment_method_id' => ($request->payment_method === 'cash') ? 1 : 2,
            'ordered_at' => now(),
        ]);

        foreach ($cart as $item) {
            $foodId = DB::table('foods')->where('name', $item['name'])->value('id');

            if (!$foodId) {
                Log::error("Food ID not found for item name: {$item['name']}");
                continue; // Skip item jika tidak ditemukan
            }

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $foodId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => $item['notes'] ?? null,
            ]);

            // Tambahkan add-ons di sini, DI DALAM loop item
            if (!empty($item['addons'])) {
                foreach ($item['addons'] as $addOnName) {
                    $addOn = DB::table('add_ons')->where('name', $addOnName)->first();

                    if (!$addOn) {
                        Log::error("Add-on not found: {$addOnName}");
                        continue;
                    }

                    DB::table('order_item_add_on')->insert([
                        'order_item_id' => $orderItem->id,
                        'add_on_id' => $addOn->id,
                        'price' => $addOn->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        foreach ($cart as &$item) {
            if (!empty($item['addons'])) {
                $item['addons'] = collect($item['addons'])->map(function ($addOnName) {
                    $addOn = DB::table('add_ons')->where('name', $addOnName)->first();

                    return $addOn
                        ? ['name' => $addOn->name, 'price' => $addOn->price]
                        : ['name' => $addOnName, 'price' => 0];
                })->toArray();
            }
        }

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

        return redirect()->route('invoice.show')->with('success', 'Pesanan berhasil dibuat!');
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
