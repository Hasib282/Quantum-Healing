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
}
