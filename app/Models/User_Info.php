<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Info extends Model
{
    protected $connection = 'mysql';
    
    protected $guarded = [];

    public $timestamps = false;
}


