<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logged_detail extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Logged_detail');
    }
}
