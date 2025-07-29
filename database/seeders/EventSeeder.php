<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/event.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Event::create([
                "name"=>$item->name,
                "all"=>$item->all,
            ]);
        });
    }
}
