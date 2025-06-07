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
        // Main Admin
        Admin::updateOrCreate(
            ['email' => 'admin@ecom12.com'],
            [
                'name' => 'Jonathan Blake',
                'role' => 'admin',
                'mobile' => '9876543210',
                'password' => Hash::make('admin2024'),
                'status' => 1,
            ]
        );

        // Sub Admin 1
        Admin::updateOrCreate(
            ['email' => 'subadmin1@ecom12.com'],
            [
                'name' => 'Sophia Lee',
                'role' => 'subadmin',
                'mobile' => '9811122233',
                'password' => Hash::make('admin2024'),
                'status' => 1,
            ]
        );

        // Sub Admin 2
        Admin::updateOrCreate(
            ['email' => 'subadmin2@ecom12.com'],
            [
                'name' => 'David Chen',
                'role' => 'subadmin',
                'mobile' => '9822233344',
                'password' => Hash::make('admin2024'),
                'status' => 1,
            ]
        );
    }
}
