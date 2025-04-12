<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            ['name' => 'Cash'],
            ['name' => 'QRIS'],
            ['name' => 'Credit Card'],
            ['name' => 'E-Wallet'],
        ]);
    }
}
