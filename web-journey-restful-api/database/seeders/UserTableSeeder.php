<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['name' => 'Shawon', 'email' => 'shawon@gmail.com', 'password' => '123456'],
            ['name' => 'SRS', 'email' => 'srs@gmail.com', 'password' => '123456'],

            ['name' => 'Shahriar', 'email' => 'shahriar@gmail.com', 'password' => '123456'],
            ['name' => 'Ovi', 'email' => 'ovi@gmail.com', 'password' => '123456'],
            ['name' => 'Oli', 'email' => 'oli@gmail.com', 'password' => '123456'],
            ['name' => 'Kabbo', 'email' => 'kabbo@gmail.com', 'password' => '123456'],
            ['name' => 'Sayan', 'email' => 'sayan@gmail.com', 'password' => '123456'],

            ['name' => 'Raksi', 'email' => 'rakhi@gmail.com', 'password' => '123456'],
            ['name' => 'Rozi', 'email' => 'rozi@gmail.com', 'password' => '123456'],
            ['name' => 'Ranu', 'email' => 'ranu@gmail.com', 'password' => '123456'],
            ['name' => 'Smrity', 'email' => 'smrity@gmail.com', 'password' => '123456'],
        ];

        User::insert($users);
    }
}
