<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $payments = Payment::all();
        $discounts = Discount::all();

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $payment = $payments->random();
            $discount = rand(0, 1) ? $discounts->random() : null;

            $totalPrice = fake()->numberBetween(30000, 150000);
            $discountAmount = $discount ? ($totalPrice * $discount->percentage / 100) : 0;
            $finalPrice = $totalPrice - $discountAmount;

            Order::create([
                'user_id'           => $user->id,
                'order_number'      => Order::generateOrderNumber(),
                'status'            => fake()->randomElement(['pending', 'preparing', 'completed', 'cancelled']),  // Fixed status values
                'total_price'       => $totalPrice,
                'payment_method_id' => $payment->id,
                'payment_status'    => fake()->randomElement(['waiting', 'paid', 'failed']),
                'discount_id'       => $discount?->id,
                'discount_amount'   => $discountAmount,
                'final_price'       => $finalPrice,
                'ordered_at'        => Carbon::now()->subDays(rand(0, 10)),
            ]);
        }
    }

}
