<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Citra Ayu',
                'email' => 'citra@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Dina Kusuma',
                'email' => 'dina@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Eko Nugroho',
                'email' => 'eko@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 16,
                'name' => 'Tralala',
                'email' => '123@mail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
