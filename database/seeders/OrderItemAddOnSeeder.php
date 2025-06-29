<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\AddOn;
use App\Models\OrderItemAddOn;
use Illuminate\Database\Seeder;

class OrderItemAddOnSeeder extends Seeder
{
    public function run(): void
    {
        $orderItems = OrderItem::all();

        foreach ($orderItems as $item) {
            // Ambil add-on yang sesuai dengan food_id dari item
            $addOns = AddOn::where('food_id', $item->foods_id)->get();

            if ($addOns->isEmpty()) {
                continue;
            }

            $addOnCount = rand(0, 2);
            $usedAddOns = $addOns->random(min($addOnCount, $addOns->count()));

            foreach ((is_iterable($usedAddOns) ? $usedAddOns : [$usedAddOns]) as $addOn) {
                $quantity = rand(1, 2);

                OrderItemAddOn::create([
                    'order_item_id' => $item->id,
                    'add_on_id'     => $addOn->id,
                    'quantity'      => $quantity,
                    'price'         => $addOn->price * $quantity,
                ]);
            }
        }
    }
}
