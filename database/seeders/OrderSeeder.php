<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $payments = Payment::all();

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $payment = $payments->random();

            $totalPrice = fake()->numberBetween(30000, 150000);

            // Diskon dihapus, jadi tidak ada diskon
            $discountAmount = 0;
            $finalPrice = $totalPrice;

            Order::create([
                'user_id'           => $user->id,
                'order_number'      => Order::generateOrderNumber(),
                'status'            => fake()->randomElement(['pending', 'preparing', 'completed', 'cancelled']),
                'total_price'       => $totalPrice,
                'payment_method_id' => $payment->id,
                'final_price'       => $finalPrice,
                'ordered_at'        => Carbon::now()->subDays(rand(0, 10)),
            ]);
        }
    }
}
