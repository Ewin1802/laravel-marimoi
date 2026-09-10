<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'abing@admin.com'],
            [
                'name' => 'Abing Pontoh',
                'email' => 'abing@admin.com',
                'phone_number' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]

        );
        User::updateOrCreate(
            ['email' => 'e@admin.com'],
            [
                'name' => 'Ewin Kasir',
                'email' => 'e@admin.com',
                'phone_number' => '081234567898',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]

        );
    }
}
