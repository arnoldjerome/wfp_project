<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Food;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        $foods = Food::all();

        foreach ($orders as $order) {
            // Setiap order, tambahkan 1-3 item makanan acak
            $selectedFoods = $foods->random(rand(1, 3));
            
            foreach ($selectedFoods as $food) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'foods_id' => $food->id,
                    'quantity' => rand(1, 3),
                    'price' => $food->price, //kolom price food
                ]);
            }
        }
    }
}


