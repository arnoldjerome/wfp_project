<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $mostOrderedFood = DB::table('orders')
            ->join('foods', 'orders.food_id', '=', 'foods.id')
            ->select('foods.name', DB::raw('COUNT(orders.id) as total_ordered'))
            ->groupBy('foods.name')
            ->orderByDesc('total_ordered')
            ->first();


            $leastOrderedFood = DB::table('foods')
            ->leftJoin('orders', 'foods.id', '=', 'orders.food_id')
            ->select('foods.name', DB::raw('COUNT(orders.id) as total_ordered'))
            ->groupBy('foods.id', 'foods.name')
            ->orderBy('total_ordered')
            ->first();


        $topCustomer = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->groupBy('users.name')
            ->orderByDesc('total_orders')
            ->first();

        $mostUsedPaymentMethod = DB::table('orders')
            ->join('payments', 'orders.payment_method_id', '=', 'payments.id')
            ->select('payments.name as payment', DB::raw('COUNT(orders.id) as total'))
            ->groupBy('payments.name')
            ->orderByDesc('total')
            ->first();

        $totalOrderAmount = DB::table('orders')
            ->where('status', 'completed')
            ->sum('final_price');

        return view('report.index', compact(
            'mostOrderedFood',
            'leastOrderedFood',
            'topCustomer',
            'mostUsedPaymentMethod',
            'totalOrderAmount'
        ));
    }

}
