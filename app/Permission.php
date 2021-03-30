<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'name', 'active', 'permission_perent_id'
    ];

    public function permission_role()
    {
        return $this->hasMany('App\Permission_role');
    }

    public function route_permission()
    {
        return $this->hasMany('App\Route_permission');
    }

    public function permission_parent()
    {
        return $this->belongsTo('App\Permission_parent');
    }
}
