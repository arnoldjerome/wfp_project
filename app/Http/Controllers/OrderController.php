<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;
use App\Models\Food;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'paymentMethod', 'items.food', 'items.addOns.addOn'])->paginate(5);
        $users = User::all();
        $payments = Payment::all();
        $statuses = OrderStatus::options();
        $foods = Food::all();

        return view("order.index", compact('orders', 'users', 'payments', 'statuses', 'foods'));
    }

    public function create()
    {
        $users = User::all();
        $payments = Payment::all();
        $foods = Food::all();

        return view('order.index', compact('users', 'payments', 'foods'));
    }

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

    public function show(Order $order)
    {
        $users = User::all();
        $payments = Payment::all();

        return view('order.index', compact('order', 'users', 'payments'));
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->user_id = $request->user_id;
            $order->payment_method_id = $request->payment_method_id;
            $order->status = $request->status;
            $order->total_price = $request->total_price;
            $order->final_price = $request->final_price;
            $order->ordered_at = $request->ordered_at;
            $order->save();

            // Kirim notifikasi ke user (jika user tidak null dan pakai Notifiable)
            if ($order->user && method_exists($order->user, 'notify')) {
                $order->user->notify(new OrderStatusUpdated($order));
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(Request $request, Order $order)
    {
        $order->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Order deleted successfully.']);
        }

        return redirect()->route('order.index')->with('success', 'Order deleted.');
    }
}
