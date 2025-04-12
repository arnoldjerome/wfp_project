<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Food;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10000, 40000);
        $quantity = $this->faker->numberBetween(1, 3);

        return [
            'order_id' => Order::inRandomOrder()->first()?->id ?? Order::factory(),
            'food_id' => Food::inRandomOrder()->first()?->id ?? Food::factory(),
            'quantity' => $quantity,
            'price' => $price,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
