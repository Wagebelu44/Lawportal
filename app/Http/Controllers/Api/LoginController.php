<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class LoginController extends Controller
{
    public function index(Request $request) {
    	$user_data = [];
    	$data = Validator::make($request->all(), [
	            'username' => ['required', 'string'],
	            'password' => ['required', 'string'],
	            'device_name' => ['required', 'string'],
	        ])->validate();

		$user = User::where('username', $request->username)->first();

	    if (! $user || ! Hash::check($request->password, $user->password)) {
	        return response([
	            'message' => 'The provided credentials are incorrect.',
	        ], 200);
	    }
	    $user_data['id'] = $user->id;
	    $user_data['username'] = $user->username;
	    $user_data['email'] = $user->email;
	    $user_data['name'] = $user->name;
	    $user_data['mobile'] = get_usermeta($user->id, 'mobile') == null ? '' : get_usermeta($user->id, 'mobile');
	    $user_data['address'] = get_usermeta($user->id, 'address') == null ? '' : get_usermeta($user->id, 'address');
	    $user_data['dir_name'] = get_usermeta($user->id, 'dir_name') == null ? '' : get_usermeta($user->id, 'dir_name');
	    $profile_image = get_usermeta($user->id, '_profile_image');

	    if($profile_image == null) {
	    	$user_data['profile_image'] = asset('/public/images/default-user.jpg');
	    }else {
	    	$user_data['profile_image'] = url('public/storage/' . $profile_image);
	    }

	    $token = $user->createToken($request->device_name)->plainTextToken;

	    $response = [
	    	'user' => $user_data,
	    	'token' => $token
	    ];

		return response($response, 201);	    
    }

    public function logout(Request $request) {
    	$response = [];
    	$data = Validator::make($request->all(), [
	            'user_id' => ['required', 'string']
	        ])->validate();

    	$user_id = (int) $data['user_id'];
    	$user = User::where('id', $user_id)->first();
    	$user->tokens()->delete();
    	
    	$response['success'] = '1';

    	return response($response, 201);
    }
}
