<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'utilisateur_id', 'raison_sociale', 'nif', 'bp', 'adresse', 'ville', 'pays', 'tel', 'responsable', 'tel_responsable', 'email', 'type', 'created_at',
        'updated_at'
    ];

    public function utilisateur()
    {
        return $this->belongsTo('App\User');
    }

}
