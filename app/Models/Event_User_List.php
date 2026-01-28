<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_User_List extends Model
{
    protected $guarded = [];
    
    public $timestamps = false;

    public function events(){
        return $this->belongsTo(Event::class,'event_id','id');
    }

    public function participants(){
        return $this->hasmany(User_Info::class,'reg_no','reg_no');
    }
    
    public function participant(){
        return $this->belongsTo(User_Info::class,'reg_no','reg_no');
    }
}
