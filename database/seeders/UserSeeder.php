<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // User Admin
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'phone' => '081239837912',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'role' => 'admin',
            ],
            [
                'name' => 'Amalia',
                'email' => 'amalia@gmail.com',
                'password' => Hash::make('amalia123'),
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'role' => 'admin',
            ],

            // User Customer
            [
                'name' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('user1'),
                'phone' => '082396778345',
                'address' => 'Jl. Customer No. 2, Gunung Kidul',
                'role' => 'customer',
            ],
            [
                'name' => 'user2',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('user2'),
                'phone' => '083955678497',
                'address' => 'Jl. Customer No. 2, Sleman',
                'role' => 'customer',
            ],
            [
                'name' => 'user3',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('user3'),
                'phone' => '08230938497',
                'address' => 'Jl. Customer No. 2, Jogja',
                'role' => 'customer',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
