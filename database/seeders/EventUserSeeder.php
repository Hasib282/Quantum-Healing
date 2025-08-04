<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Event_User_List;

class EventUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/event_user.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Event_User_List::create([
                "event_id"=>$item->event_id,
                "reg_no"=>$item->reg_no,
            ]);
        });
    }
}
