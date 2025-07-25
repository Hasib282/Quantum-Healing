<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/branch.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Branch::create([
                "branch"=>$item->name,
                "short"=>$item->short,
            ]);
        });
    }
}
