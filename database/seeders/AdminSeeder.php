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
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
