<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Echelon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'etat', 'engagement_id', 'user_id', 'n_engage', 'n_ordonnance', 'm_paye', 'date_paiement', 'comment', 'date_depot_ac', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'etat' => 'string',
        'date_paiement' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function engagement()
    {
        return $this->belongsTo('App\Engagement');
    }

    public function documents(){
        return $this->belongsToMany('App\Document');
    }
}
