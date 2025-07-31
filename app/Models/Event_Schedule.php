<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_Schedule extends Model
{
    protected $guarded = [];
    
    public $timestamps = false;

    public function event(){
        return $this->belongsTo(Event::class,'event_id','id');
    }
}
