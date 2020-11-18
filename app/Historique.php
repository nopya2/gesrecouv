<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = [
        'id', 'body'
    ];

    protected $casts = [
        'body' => 'array',
    ];
}
