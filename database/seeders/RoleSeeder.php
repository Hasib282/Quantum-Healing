<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/role.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Role::create([
                "name"=>$item->name,
            ]);
        });
    }
}
