<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'id' => 1,
                'name' => 'Udang Mentega',
                'nutrition_fact' => 'Protein: 20',
                'description' => 'Udang dengan saus mentega yang lezat',
                'img_url' => '/assets/images/foods/udangsausmentega.jpeg',
                'price' => 30000.00,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Spring Roll',
                'nutrition_fact' => 'Kalori: 150, Karbohidrat: 20, Protein: 3, Lemak: 5',
                'description' => 'Lumpia sayur goreng renyah dengan saus asam manis',
                'img_url' => '/assets/images/foods/springroll.jpg',
                'price' => 15000.00,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Caesar Salad',
                'nutrition_fact' => 'Kalori: 200, Karbohidrat: 25, Protein: 2, Lemak: 4',
                'description' => 'Campuran selada, ayam panggang, crouton, dan saus caesar',
                'img_url' => '/assets/images/foods/caesarsalad.jpg',
                'price' => 17000.00,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Nasi Hainam',
                'nutrition_fact' => 'Karbohidrat: 50, Protein: 20',
                'description' => 'Nasi dengan ayam hainam',
                'img_url' => '/assets/images/foods/nasihainam.jpg',
                'price' => 40000.00,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Nasi Ayam Taliwang',
                'nutrition_fact' => 'Karbohidrat: 50, Protein: 20',
                'description' => 'Nasi merah dengan ayam bakar pedas khas Lombok',
                'img_url' => '/assets/images/foods/ayamtaliwang.jpg',
                'price' => 35000.00,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'name' => 'Nasi Bebek Goreng Bumbu Hitam',
                'nutrition_fact' => 'Karbohidrat: 50, Protein: 20',
                'description' => 'Nasi dengan bebek goreng dan sambal bumbu hitam khas madura',
                'img_url' => '/assets/images/foods/bebekhitam.jpg',
                'price' => 40000.00,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'name' => 'Puding Coklat',
                'nutrition_fact' => 'Kalori: 250, Karbohidrat: 30, Protein: 4, Lemak: 1',
                'description' => 'Puding lembut rasa coklat vanila',
                'img_url' => '/assets/images/foods/puddingcoklat.jpg',
                'price' => 18000.00,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'name' => 'Es Krim Vanila',
                'nutrition_fact' => 'Kalori: 220, Karbohidrat: 32, Protein: 3, Lemak: 3',
                'description' => 'Es krim rasa vanilla dengan topping choco chips',
                'img_url' => '/assets/images/foods/eskrimvanilla.jpg',
                'price' => 20000.00,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'name' => 'Kue Lapis Legit',
                'nutrition_fact' => 'Kalori: 280, Karbohidrat: 40, Protein: 4, Lemak: 7',
                'description' => 'Kue lapis berlapis dengan rasa manis dan aroma rempah',
                'img_url' => '/assets/images/foods/lapislegit.png',
                'price' => 20000.00,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'name' => 'Roti Bakar Coklat Keju',
                'nutrition_fact' => 'Kalori: 350, Karbohidrat: 45, Protein: 5, Lemak: 10',
                'description' => 'Roti bakar dengan topping coklat dan keju',
                'img_url' => '/assets/images/foods/rotibakar.jpeg',
                'price' => 20000.00,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'name' => 'Kentang Goreng',
                'nutrition_fact' => 'Kalori: 250, Karbohidrat: 30, Protein: 2, Lemak: 6',
                'description' => 'Kentang goreng renyah dengan saus tomat',
                'img_url' => '/assets/images/foods/kentanggoreng.jpg',
                'price' => 17000.00,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'name' => 'Tahu Crispy',
                'nutrition_fact' => 'Kalori: 250, Karbohidrat: 20, Protein: 8, Lemak: 1',
                'description' => 'Tahu goreng renyah dengan bumbu pedas',
                'img_url' => '/assets/images/foods/tahucrispy.jpg',
                'price' => 15000.00,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
