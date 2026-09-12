<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        DB::table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@kedalla.com',
            'role'       => 'admin',
            'phone'      => '077-3737422',
            'area'       => 'Handessa',
            'status'     => 'Active',
            'password'   => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sales Rep
        DB::table('users')->insert([
            'name'       => 'Mohamed Musharrif',
            'email'      => 'rep@kedalla.com',
            'role'       => 'salesrep',
            'phone'      => '071-1234567',
            'area'       => 'Kandy',
            'status'     => 'Active',
            'password'   => Hash::make('rep123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}