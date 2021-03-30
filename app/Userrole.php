<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userrole extends Model
{
    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    public function userform()
    {
        return $this->hasMany('App\Userform');
    }

    public function permission_role()
    {
        return $this->hasMany('App\Permission_role');
    }
}
