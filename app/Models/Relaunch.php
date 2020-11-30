<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relaunch extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_relaunch' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function facture()
    {
        return $this->belongsTo('App\Facture');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
