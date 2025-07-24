<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Login_User;

class LoginUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 'SA000000001',
                'name' => 'Hasibur Rahaman',
                'email' => 'hasiburrahman81098@gmail.com',
                'phone' => '01314353560',
                'role' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000002',
                'name' => 'Shafiuzzaman Thakur',
                'email' => 'shafiuzzamanthakur@gmail.com',
                'phone' => '01713867116',
                'role' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000003',
                'name' => 'Samin Rahman',
                'email' => 'samin1105009@gmail.com',
                'phone' => '01858162015',
                'role' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000004',
                'name' => 'Md. Assaduzzaman',
                'email' => 'azshifat07@gmail.com',
                'phone' => '01828908967',
                'role' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000005',
                'name' => 'Tanvir Hossain',
                'email' => 'tanvirvai@gmail.com',
                'phone' => '01886703996',
                'role' => 1,
                'password' => Hash::make('12345')
            ],
        ];

        Login_User::insert($data);
    }
}
