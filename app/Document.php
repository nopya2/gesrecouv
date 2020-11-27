<?php

namespace App;

use App\Providers\Functions;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'filename', 'size'
    ];

    protected $guarded = [];

    public function uploads()
    {
        return $this->morphedByMany('App\Upload', 'documentable');
    }

    public function getSizeAttribute($value){
        return Functions::formatSizeUnits($value);
    }
}
