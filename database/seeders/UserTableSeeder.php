<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'User 1', 
            'email'    => 'user1@gmail.com',
            'mobile'   => '01111111111',
            'password' => bcrypt('12345678'),
            'photo'    => 'avatar.jpg',
            'status'   => 1,
        ]);



        User::create([
            'name'     => 'User 2', 
            'email'    => 'user2@gmail.com',
            'mobile'   => '02222222222',
            'password' => bcrypt('12345678'),
            'photo'    => 'avatar.jpg',
            'status'   => 1,
        ]);



        User::create([
            'name'     => 'User 3', 
            'email'    => 'user3@gmail.com',
            'mobile'   => '03333333333',
            'password' => bcrypt('12345678'),
            'photo'    => 'avatar.jpg',
            'status'   => 1,
        ]);
    }
}
