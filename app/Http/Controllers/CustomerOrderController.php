<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(
            'items.food',
            'items.addOns.addOn'
        )->where('user_id', Auth::id())->orderBy('ordered_at', 'desc')->get();
        $notifications = Auth::user()->notifications;

        return view('frontend.customer.orders', compact('orders', 'notifications'));
    }

    public function show($id)
    {
        $order = Order::with(['items.food', 'items.addOns.addOn'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend.customer.order-detail', compact('order'));
    }
}
