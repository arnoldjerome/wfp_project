<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $totalPrice = $this->faker->randomFloat(2, 50000, 150000);
        $discount = Discount::inRandomOrder()->first();
        $discountAmount = 0;

        if ($discount && $totalPrice >= $discount->min_order) {
            $discountAmount = $discount->type === 'percentage'
                ? $totalPrice * ($discount->value / 100)
                : $discount->value;
        }

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'order_number' => strtoupper(Str::random(10)),
            'status' => $this->faker->randomElement(['pending', 'preparing', 'completed', 'cancelled']),
            'total_price' => $totalPrice,
            'payment_method_id' => Payment::inRandomOrder()->first()?->id ?? Payment::factory(),
            'payment_status' => $this->faker->randomElement(['waiting', 'approved', 'declined']),
            'discount_id' => $discount?->id,
            'discount_amount' => $discountAmount,
            'final_price' => $totalPrice - $discountAmount,
            'ordered_at' => now()
        ];
    }
}
