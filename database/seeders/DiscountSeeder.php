<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('discounts')->insert([
            [
                'code' => 'HEALTHY10',
                'type' => 'percentage',
                'value' => 10,
                'min_order' => 50000,
                'expires_at' => now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'CASHBACK20K',
                'type' => 'fixed',
                'value' => 20000,
                'min_order' => 100000,
                'expires_at' => now()->addWeeks(2),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
