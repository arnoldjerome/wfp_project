<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Food;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        $foods = Food::all();

        foreach ($orders as $order) {
            $itemsCount = rand(1, 3);

            for ($i = 0; $i < $itemsCount; $i++) {
                $food = $foods->random();
                $qty = rand(1, 2);
                $price = $food->price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'foods_id' => $food->id,
                    'quantity' => $qty,
                    'price'    => $price,
                    'note'     => fake()->optional()->sentence(),
                ]);
            }
        }
    }
}
