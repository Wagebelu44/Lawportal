<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route_permission extends Model
{
    public $timestamps = false;

    public function permission()
    {
        return $this->belongsTo('App\Permission');
    }
}
