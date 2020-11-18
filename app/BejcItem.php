<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BejcItem extends Model
{
    protected $fillable = [
        'id', 'engagement_id', 'n_ordonnance', 'm_ordonnance', 'created_at', 'user_id'
    ];

    public function engagement()
    {
        return $this->belongsTo('App\Engagement');
    }

    public function bordereau()
    {
        return $this->belongsTo('App\Bejc');
    }
}
