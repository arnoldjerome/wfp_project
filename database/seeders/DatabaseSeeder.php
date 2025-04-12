<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            FoodSeeder::class,
            PaymentSeeder::class,
            DiscountSeeder::class,
            UserSeeder::class,
            FoodSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }   
}
