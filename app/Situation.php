<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'provider', 'created_at', 'updated_at'
    ];
}
