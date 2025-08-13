<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp_User extends Model
{
    protected $connection = 'mysql';
    
    protected $guarded = [];

    public $timestamps = false;
}
