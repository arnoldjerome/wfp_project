<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $orders = DB::table('orders as o')
        ->join('payments as p',"p.id","=","o.payment_method_id")
        ->join('users as u',"u.id","=","o.user_id")
        ->leftJoin('discounts as d',"d.id","=","o.discount_id")
        ->select("o.id", "u.name as user", "o.order_number", "o.status", "p.name as payment", "o.payment_status",
         "d.code as discount", "o.discount_amount", "o.total_price", "o.final_price", "o.ordered_at")
        ->get();

        return view("order.index", ["datas" => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
