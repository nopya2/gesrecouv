<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bejc extends Model
{
    protected $fillable = [
        'id', 'chapitre_id', 'm_ordonnance', 'created_at', 'user_id', 'nature'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function chapitre()
    {
        return $this->belongsTo('App\Chapitre');
    }

    public function items()
    {
        return $this->hasMany('App\BejcItem');
    }

    public function echelons(){
        return $this->belongsToMany('App\Echelon');
    }
}
