<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $user2 = User::create([
            'name' => 'User2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
