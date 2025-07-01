<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AddOnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('add_ons')->insert([
            [
                'id' => 1,
                'food_id' => 1,
                'name' => 'Extra Udang',
                'price' => 15000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'food_id' => 1,
                'name' => 'Extra Nasi',
                'price' => 5000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'food_id' => 4,
                'name' => 'Ayam Extra',
                'price' => 8000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'food_id' => 5,
                'name' => 'Jukut Goreng',
                'price' => 4000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'food_id' => 7,
                'name' => 'Coklat Leleh',
                'price' => 2500.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'food_id' => 7,
                'name' => 'Whipped Cream',
                'price' => 3500.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'food_id' => 8,
                'name' => 'Choco Chips',
                'price' => 2000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'food_id' => 9,
                'name' => 'Keju Parut',
                'price' => 3000.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
