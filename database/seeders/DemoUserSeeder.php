<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
                'name'=> 'admin',
                'email' => 'admin@rental.com',
                'password'=> Hash::make('admin123'),
                'role' => 'admin',
                'tools'=> [],

        ]);




    }
}
