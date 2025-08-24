<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Auth Seeders
            RoleSeeder::class,
            // BranchSeeder::class,
            EventSeeder::class,
            LoginUserSeeder::class,
            // UserSeeder::class,
            // EventUserSeeder::class,
        ]);
    }
}
