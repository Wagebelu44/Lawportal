<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todoassignees extends Model
{
    public $timestamps = false;

    public function master()
    {
        return $this->belongsTo('App\Master');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
