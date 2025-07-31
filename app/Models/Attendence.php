<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function events(){
        return $this->belongsTo(Event::class,'event_id','id');
    }
    
    public function users(){
        return $this->belongsTo(User_Info::class,'reg_no','reg_no');
    }

    public function participants(){
        return $this->hasmany(User_Info::class,'reg_no','reg_no');
    }
}
