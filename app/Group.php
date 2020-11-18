<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission')
            ->withTimestamps();
    }

    public function getHasPermissionAttribute($permissionId = 0){
        return $this->permissions->contains($permissionId);
    }

    public function hasPermission($module, $action){
        if($this->permissions()
            ->where('slug', $action)
            ->whereHas('module', function ($query) use ($module){
                $query->where('slug', $module);
            })->first()){

            return true;
        }
        return false;

    }

}
