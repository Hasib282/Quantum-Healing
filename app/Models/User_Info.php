<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Info extends Model
{
    protected $connection = 'mysql';
    
    protected $guarded = [];

    public $timestamps = false;

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event__user__lists', 'reg_no', 'event_id', 'reg_no', 'id');
    }


    public function branchs(){
        return $this->belongsTo(Branch::class,'branch','id');
    }
}


