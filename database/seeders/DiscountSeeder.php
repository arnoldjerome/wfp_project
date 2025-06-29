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
                'id' => 1,
                'code' => 'HEMAT10',
                'type' => 'percentage',
                'value' => 10.00,
                'min_order' => 50000,
                'expires_at' => '2025-05-31 16:59:59',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'code' => 'KODE50K',
                'type' => 'fixed',
                'value' => 50000.00,
                'min_order' => 150000,
                'expires_at' => '2025-06-15 16:59:59',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'code' => 'ONGKIRGRATIS',
                'type' => null,
                'value' => 0.00,
                'min_order' => 30000,
                'expires_at' => '2025-05-10 16:59:59',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'code' => 'RAMADHAN15',
                'type' => 'percentage',
                'value' => 15.00,
                'min_order' => 100000,
                'expires_at' => '2025-04-30 16:59:59',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
