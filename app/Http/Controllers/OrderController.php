<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Discount;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;
use App\Models\Food;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $orders = Order::with(['user', 'paymentMethod', 'food'])->get();
        $users = User::all();
        $payments = Payment::all();
        $statuses = OrderStatus::options();
        $foods = Food::all();

        return view("order.index", compact('orders', 'users', 'payments', 'statuses', 'foods'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $payments = Payment::all();
        $foods = Food::all();

        return view('order.index', compact('users', 'payments', 'foods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'food_id' => 'required',
            'status' => 'required',
            'payment_method_id' => 'required',
            'discount_id' => 'nullable',
            'discount_amount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'final_price' => 'required|numeric',
            'ordered_at' => 'required|date',
        ]);

        $validated['order_number'] = Order::generateOrderNumber();
        Order::create($validated);

        return response()->json(['status' => 'success', 'message' => 'Order created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $users = User::all();
        $payments = Payment::all();
        $discounts = Discount::all();

        return view('order.index', compact('order', 'users', 'payments', 'discounts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'food_id' => 'required',
            'status' => 'required',
            'payment_method_id' => 'required',
            'discount_id' => 'nullable',
            'discount_amount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'final_price' => 'required|numeric',
            'ordered_at' => 'required|date',
        ]);

        $order->update($validated);
        return response()->json(['message' => 'Order updated successfully.']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order deleted.');
    }
}
