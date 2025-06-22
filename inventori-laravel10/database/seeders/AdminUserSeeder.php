<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'balaihiperkesplg@gmail.com',
            'password' => Hash::make('hiperkesplg'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kepala',
            'email' => 'kepalahiperkesplg@gmail.com',
            'password' => Hash::make('kepalasplg'),
            'role' => 'kepala',
        ]);

    }
}
