<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'id', 'slug', 'name', 'description'
    ];

    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }
}
