<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'id', 'slug', 'name', 'description'
    ];

    public function module()
    {
        return $this->belongsTo('App\Module');
    }
}
