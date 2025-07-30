<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\User_Info;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/User_Info.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            User_Info::create([
                'sl' => $item->sl,
                'qr_url' => $item->qr_url,
                'u_id' => $item->u_id,
                'reg_no' => $item->reg_no,
                'name' => $item->name,
                'phone' => $item->Phone,
                'duplicate' => $item->duplicate,
                'gender' => $item->gender,
                'age' => $item->age,
                'dob' => $item->dob,
                'occupation' => $item->occupation,
                'qt_status' => $item->qt_status,
                'quantum' => $item->quantum,
                'quantier' => $item->quantier,
                'ardentier' => $item->ardentier,
                'branch' => $item->branch,
                'job_status' => $item->job_status,
                'psyche_certificate' => $item->psyche_certificate,
                'sp' => $item->sp,
                'group' => $item->group,
                'call' => $item->call,
                'sms' => $item->sms,
                'color' => $item->color,
                'barcode' => $item->barcode,
                'new_barcode' => $item->new_barcode,
                'new_barcode_sl' => $item->new_bcode_sl,
                'barcode_delivery' => $item->bcode_delivery,
                'first_attend' => $item->first_attend,
                'last_attend' => $item->last_attend,
                'status' => $item->status,
                'image' => $item->image,
            ]);
        });
    }
}
