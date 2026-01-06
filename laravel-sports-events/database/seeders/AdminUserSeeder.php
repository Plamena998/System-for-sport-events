<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@sportevents.bg',
            'is_admin' => true,
            'password' => Hash::make('password'),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@sportevents.bg');
        $this->command->info('Password: password');
    }
}