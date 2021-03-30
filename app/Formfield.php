<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formfield extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'field_name'
    ];

    public function userform()
    {
        return $this->hasMany('App\Userform');
    }
}
