<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_parent extends Model
{
    public $timestamps = false;

    public function permission()
    {
        return $this->hasMany('App\Permission');
    }
}
