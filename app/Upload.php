<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'id', 'name', 'description', 'type', 'uploaded_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'uploaded_at' => 'datetime'
        // 'd_previsional_paiement' => 'datetime:Y-m-d',
    ];

    public function documents()
    {
        return $this->morphToMany('App\Document', 'documentable');
    }
}
