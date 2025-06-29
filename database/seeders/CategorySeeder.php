<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Appetizer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Main Course', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Dessert', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
