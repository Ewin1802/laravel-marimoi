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
                'phone_number' => '082195348802',
                'password' => Hash::make('passmarimoi2609'),
                'role' => 'admin',
            ]
        );
        User::updateOrCreate(
            ['email' => 'e@admin.com'],
            [
                'name' => 'Ewin Kasir',
                'email' => 'e@admin.com',
                'phone_number' => '081234567898',
                'password' => Hash::make('password1413'),
                'role' => 'admin',
            ]
        );
    }
}
