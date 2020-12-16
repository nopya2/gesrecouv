<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $guarded = [];

    protected $hidden = ['id', 'created_at'];
}
