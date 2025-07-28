<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    
    public $timestamps = false;

    public function eventparticipants()
    {
        return $this->hasMany(Event_User_List::class, 'event_id', 'id'); // assuming foreign key is event_id
    }

    public function users()
    {
        return $this->belongsToMany(User_Info::class, 'event__user__lists', 'event_id', 'reg_no', 'id', 'reg_no');
    }
}
