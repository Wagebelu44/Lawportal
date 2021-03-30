<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'master_id', 'objective', 'weightage','employee_comment','reviewer_comment','score'
    ];

    public function master()
    {
        return $this->belongsTo('App\Master');
    }
}
