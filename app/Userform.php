<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userform extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'userrole_id', 'formfield_id'
    ];

    public function formfield()
    {
        return $this->belongsTo('App\Formfield');
    }

    public function userrole()
    {
        return $this->belongsTo('App\Userrole');
    }
}
