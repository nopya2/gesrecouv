<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    protected $fillable = [
        'id', 'n_chap', 'l_chap', 'nature'
    ];
}
