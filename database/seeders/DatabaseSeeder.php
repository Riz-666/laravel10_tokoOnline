<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admininstrator',
            'email' => 'admin@admin.com',
            'role' => '1',
            'status' => 1,
            'hp' => '083894417833',
            'password' => bcrypt('admin1'),
        ]);
        User::create([
            'nama' => 'Riz',
            'email' => 'its.rize@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081290093650',
            'password' => bcrypt('riz666'),
        ]);
    }
}
