<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('foods')->insert([
            // 1-2: Appetizer
            [
                'name' => 'Salad Buah Yogurt',
                'nutrition_fact' => "Kalori: 200 kkal\nProtein: 5g\nLemak: 3g\nKarbohidrat: 40g\nSerat: 3g",
                'description' => "Campuran buah segar dan yogurt rendah lemak, cocok untuk pembuka.",
                'price' => 18000,
                'category_id' => 1
            ],
            [
                'name' => 'Soup Tomat Basil Organik',
                'nutrition_fact' => "Kalori: 150 kkal\nProtein: 4g\nLemak: 2g\nKarbohidrat: 25g\nSerat: 4g",
                'description' => "Sup tomat segar dengan daun basil dan sedikit minyak zaitun.",
                'price' => 17000,
                'category_id' => 1
            ],

            // 3-7: Main Course
            [
                'name' => 'Nasi Merah Ayam Panggang & Tumis Kangkung',
                'nutrition_fact' => "Kalori: 500 kkal\nProtein: 35g\nLemak: 20g\nKarbohidrat: 60g\nSerat: 6g",
                'description' => "Nasi merah dengan ayam panggang kecap dan tumis kangkung.",
                'price' => 35000,
                'category_id' => 2
            ],
            [
                'name' => 'Nasi Hitam Tumis Ca Kailan',
                'nutrition_fact' => "Kalori: 450 kkal\nProtein: 30g\nLemak: 15g\nKarbohidrat: 55g\nSerat: 5g",
                'description' => "Nasi hitam dengan sayuran kailan segar dan tumisan sehat.",
                'price' => 30000,
                'category_id' => 2
            ],
            [
                'name' => 'Sup Ayam Jahe dan Sayuran Organik',
                'nutrition_fact' => "Kalori: 400 kkal\nProtein: 28g\nLemak: 8g\nKarbohidrat: 30g\nSerat: 4g",
                'description' => "Hangat dan menyegarkan dengan ayam dan sayur organik.",
                'price' => 28000,
                'category_id' => 2
            ],
            [
                'name' => 'Tumis Tofu Brokoli & Nasi Merah',
                'nutrition_fact' => "Kalori: 420 kkal\nProtein: 22g\nLemak: 10g\nKarbohidrat: 50g\nSerat: 6g",
                'description' => "Menu vegetarian kaya protein dan serat.",
                'price' => 29000,
                'category_id' => 2
            ],
            [
                'name' => 'Ikan Panggang Lemon & Salad Hijau',
                'nutrition_fact' => "Kalori: 480 kkal\nProtein: 30g\nLemak: 15g\nKarbohidrat: 25g\nSerat: 6g",
                'description' => "Ikan segar panggang disajikan dengan lemon dan sayuran.",
                'price' => 38000,
                'category_id' => 2
            ],

            // 8-9: Snack
            [
                'name' => 'Wrap Sayur & Hummus',
                'nutrition_fact' => "Kalori: 350 kkal\nProtein: 10g\nLemak: 15g\nKarbohidrat: 40g\nSerat: 7g",
                'description' => "Wrap gandum isi hummus dan sayur segar.",
                'price' => 27000,
                'category_id' => 3
            ],
            [
                'name' => 'Kroket Kentang Sayur Oven',
                'nutrition_fact' => "Kalori: 200 kkal\nProtein: 5g\nLemak: 6g\nKarbohidrat: 30g\nSerat: 3g",
                'description' => "Camilan sehat tanpa goreng, cocok untuk sore hari.",
                'price' => 16000,
                'category_id' => 3
            ],

            // 10-11: Dessert
            [
                'name' => 'Oatmeal Pisang & Chia Seed',
                'nutrition_fact' => "Kalori: 400 kkal\nProtein: 10g\nLemak: 12g\nKarbohidrat: 50g\nSerat: 6g",
                'description' => "Oat lembut dengan topping pisang dan biji chia.",
                'price' => 25000,
                'category_id' => 4
            ],
            [
                'name' => 'Puding Chia Susu Almond',
                'nutrition_fact' => "Kalori: 220 kkal\nProtein: 6g\nLemak: 10g\nKarbohidrat: 20g\nSerat: 4g",
                'description' => "Puding ringan dari chia dan susu almond.",
                'price' => 20000,
                'category_id' => 4
            ],

            // 12-13: Coffee
            [
                'name' => 'Espresso Single Origin Arabika',
                'nutrition_fact' => "Kalori: 10 kkal\nProtein: 0g\nLemak: 0g\nKarbohidrat: 2g\nSerat: 0g",
                'description' => "Espresso dari biji kopi arabika pilihan.",
                'price' => 18000,
                'category_id' => 5
            ],
            [
                'name' => 'Cold Brew Lemon Shot',
                'nutrition_fact' => "Kalori: 20 kkal\nProtein: 0g\nLemak: 0g\nKarbohidrat: 3g\nSerat: 0g",
                'description' => "Kopi cold brew segar dengan perasan lemon.",
                'price' => 22000,
                'category_id' => 5
            ],

            // 14-15: Non Coffee
            [
                'name' => 'Matcha Latte Almond Milk',
                'nutrition_fact' => "Kalori: 90 kkal\nProtein: 2g\nLemak: 3g\nKarbohidrat: 12g\nSerat: 1g",
                'description' => "Minuman hijau sehat dengan susu almond.",
                'price' => 25000,
                'category_id' => 6
            ],
            [
                'name' => 'Cocoa Oat Milk Hot Drink',
                'nutrition_fact' => "Kalori: 120 kkal\nProtein: 3g\nLemak: 4g\nKarbohidrat: 15g\nSerat: 2g",
                'description' => "Coklat panas dengan susu oat, cocok untuk cuaca dingin.",
                'price' => 23000,
                'category_id' => 6
            ],

            // 16-20: Healthy Juice
            [
                'name' => 'Detox Juice: Kale, Lemon, Apple',
                'nutrition_fact' => "Kalori: 90 kkal\nProtein: 1g\nLemak: 0g\nKarbohidrat: 18g\nSerat: 2g",
                'description' => "Jus segar untuk detoks dan energi.",
                'price' => 20000,
                'category_id' => 7
            ],
            [
                'name' => 'Jus Bit & Wortel',
                'nutrition_fact' => "Kalori: 100 kkal\nProtein: 2g\nLemak: 0g\nKarbohidrat: 20g\nSerat: 3g",
                'description' => "Campuran sehat yang bantu lancarkan metabolisme.",
                'price' => 20000,
                'category_id' => 7
            ],
            [
                'name' => 'Smoothie Bowl Berry & Granola',
                'nutrition_fact' => "Kalori: 300 kkal\nProtein: 8g\nLemak: 10g\nKarbohidrat: 35g\nSerat: 5g",
                'description' => "Kaya antioksidan dari buah beri segar dan granola.",
                'price' => 26000,
                'category_id' => 7
            ],
            [
                'name' => 'Green Juice: Bayam, Timun, Nanas',
                'nutrition_fact' => "Kalori: 85 kkal\nProtein: 1g\nLemak: 0g\nKarbohidrat: 17g\nSerat: 2g",
                'description' => "Segar dan kaya nutrisi dari sayur dan buah tropis.",
                'price' => 21000,
                'category_id' => 7
            ],
            [
                'name' => 'Jus Jeruk & Wortel Cold Press',
                'nutrition_fact' => "Kalori: 95 kkal\nProtein: 2g\nLemak: 0g\nKarbohidrat: 18g\nSerat: 2g",
                'description' => "Cold pressed juice jeruk dan wortel, kaya vitamin C.",
                'price' => 21000,
                'category_id' => 7
            ]
        ]);
    }
}
