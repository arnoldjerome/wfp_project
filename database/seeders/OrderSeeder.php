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
            $discount = fake()->boolean(40) ? $discounts->random() : null;

            $totalPrice = fake()->numberBetween(30000, 150000);

            $discountAmount = 0;
            if ($discount) {
                if ($discount->type === 'percentage') {
                    $discountAmount = round($totalPrice * $discount->value / 100, 2);
                } elseif ($discount->type === 'fixed') {
                    $discountAmount = $discount->value;
                }
            }

            $finalPrice = $totalPrice - $discountAmount;

            Order::create([
                'user_id'           => $user->id,
                'order_number'      => Order::generateOrderNumber(),
                'status'            => fake()->randomElement(['pending', 'preparing', 'completed', 'cancelled']),
                'payment_status'    => fake()->randomElement(['waiting', 'paid', 'failed']),
                'total_price'       => $totalPrice,
                'discount_id'       => $discount?->id,
                'discount_amount'   => $discountAmount,
                'final_price'       => $finalPrice,
                'payment_method_id' => $payment->id,
                'ordered_at'        => Carbon::now()->subDays(rand(0, 10)),
            ]);
        }
    }
}
