<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_role extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'permission_id', 'userrole_id'
    ];

    public function permission()
    {
        return $this->belongsTo('App\Permission');
    }

    public function userrole()
    {
        return $this->belongsTo('App\Userrole');
    }
}
