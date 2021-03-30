<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = [
        'name', 'email', 'active',
    ];

    public function mastermetas()
    {
        return $this->hasMany('App\Mastermeta');
    }

    public function todoassignees()
    {
        return $this->hasMany('App\Todoassignees');
    }

    public function objectives()
    {
        return $this->hasMany('App\Objective');
    }

    public function getNameAttribute($value) {
        return ucwords($value);
    }
}
