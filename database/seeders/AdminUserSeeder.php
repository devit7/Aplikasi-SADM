<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin_123'),
            'role' => 'admin'
        ]);
    }
}
