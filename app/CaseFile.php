<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'case_id', 'file_id'
    ];
}
