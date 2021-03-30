<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Attendence');
    }

    public function getLoggedAtAttribute($value) {
        return  date('M j, Y g:i A', strtotime($value));;
    }

    public function getLoggedOutAtAttribute($value) {

        return  empty($value) ? '' : date('M j, Y g:i A', strtotime($value));;
    }
} 

