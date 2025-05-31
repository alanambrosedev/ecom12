<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(['email' => 'admin@ecom12.com'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'mobile' => '7012756684',
                'password' => Hash::make('admin2024'),
                'status' => 1,

            ]);
    }
}
