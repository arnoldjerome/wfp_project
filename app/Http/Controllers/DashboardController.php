<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;

class DashboardController extends Controller
{


public function index()
{
    $today = Carbon::today();

    // Revenue Hari Ini
    $todayRevenue = Order::whereDate('ordered_at', $today)
        ->where('status', 'completed')
        ->sum('final_price');

    // Total Order Hari Ini
    $todayOrders = Order::whereDate('ordered_at', $today)->count();
    $availableToPayout = Order::where('status', 'completed')->sum('final_price');

    // Funnel
    $salesFunnel = [
        'add_to_cart' => Order::where('status', 'cart')->count(),
        'checkout' => Order::whereIn('status', ['pending', 'paid'])->count(),
        'purchase' => Order::where('status', 'completed')->count(),
    ];

    // Orders 7 Hari Terakhir
    $past7Days = collect(range(0, 6))->map(function ($i) {
        return Carbon::today()->subDays($i)->format('Y-m-d');
    })->reverse();

    $ordersPerDay = $past7Days->mapWithKeys(function ($date) {
        $count = Order::whereDate('ordered_at', $date)->count();
        return [$date => $count];
    });

    // Metode pembayaran (Pie Chart)
    $paymentMethods = DB::table('orders')
        ->join('payments', 'orders.payment_method_id', '=', 'payments.id')
        ->select('payments.name', DB::raw('COUNT(*) as total'))
        ->groupBy('payments.name')
        ->get();

    return view('dashboard.index', compact(
        'todayRevenue',
        'todayOrders',
        'ordersPerDay',
        'paymentMethods',
        'availableToPayout',
        'salesFunnel'
    ));
}

}
