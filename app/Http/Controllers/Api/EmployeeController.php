<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class EmployeeController extends Controller
{
	public function index() {
		$response['employees'] = User::select('users.id as id', 'users.name as name')
                ->join('usermetas', function ($join) {
                    $join->on('users.id', '=', 'usermetas.user_id')
                        ->where('usermetas.meta_key', '_userrole_id')
                        ->whereNotIn('usermetas.meta_value', [2, 3]);
                })
                ->orderBy('users.name')
                ->get();	

        return response($response, 201);	
	}
}