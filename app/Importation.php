<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importation extends Model
{
    protected $fillable = [
        'id', 'filename'
    ];
}
