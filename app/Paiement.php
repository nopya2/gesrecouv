<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'id', 'utilisateur_id', 'facture_id', 'mode_paiement', 'montant', 'date_paiement', 'commentaire', 'created_at', 'updated_at'
    ];

    public function facture()
    {
        return $this->belongsTo('App\Facture');
    }

    public function utilisateur()
    {
        return $this->belongsTo('App\User');
    }

    public function documents(){
        return $this->belongsToMany('App\Document');
    }
}
