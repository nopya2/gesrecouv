<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'filename'
    ];

    public function uploads()
    {
        return $this->morphedByMany('App\Upload', 'documentable');
    }
}
