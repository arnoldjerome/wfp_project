<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'name' => 'Nasi Merah dengan Ayam Panggang Kecap & Tumis Kangkung',
                'nutrition_fact' => "Kalori: 400-550 kkal\nProtein: 30-40 gram\nLemak: 15-25 gram\nKarbohidrat: 50-70 gram\nSerat: 5-8 gram",
                'description' => "Nikmati hidangan sehat dan lezat dengan Nasi Merah yang kaya serat, dipadukan dengan Ayam Panggang",
                'price' => 35000,
                'category_id' => 1
            ],
            [
                'name' => 'Nasi Hitam dan Tumis Ca Kailan',
                'nutrition_fact' => "Kalori: 400-550 kkal\nProtein: 30-40 gram\nLemak: 15-25 gram\nKarbohidrat: 50-70 gram\nSerat: 5-8 gram",
                'description' => "Nikmati hidangan sehat dan lezat dengan Nasi Hitam yang kaya serat.",
                'price' => 30000,
                'category_id' => 1
            ]
        ]);
    }
}
