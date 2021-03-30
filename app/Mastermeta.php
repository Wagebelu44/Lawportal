<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mastermeta extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'master_id', 'meta_key', 'meta_value'
    ];

    public function master()
    {
        return $this->belongsTo('App\Master');
    }
}
