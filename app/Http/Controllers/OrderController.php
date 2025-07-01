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
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $orders = Order::with(['user', 'paymentMethod', 'items.food', 'items.addOns.addOn'])->paginate(5);
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

        try {
            // Loop until a unique order number is generated
            do {
                $orderNumber = Order::generateOrderNumber();
            } while (Order::withTrashed()->where('order_number', $orderNumber)->exists());

            $validated['order_number'] = $orderNumber;

            Order::create($validated);

            return response()->json(['status' => 'success', 'message' => 'Order created!']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
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
            'food_id' => 'nullable',
            'status' => 'required',
            'payment_method_id' => 'required',
            'discount_id' => 'nullable',
            'discount_amount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'final_price' => 'required|numeric',
            'ordered_at' => 'required|date',
        ]);

        $order->update($validated);
        $order->user->notify(new OrderStatusUpdated($order));
        return response()->json(['message' => 'Order updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Order $order)
    {
        $order->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Order deleted successfully.']);
        }

        return redirect()->route('order.index')->with('success', 'Order deleted.');
    }
}
