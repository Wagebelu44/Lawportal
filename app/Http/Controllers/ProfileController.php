<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Usermeta;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$user = User::find(Auth::user()->id);
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        $activity_title = Auth::user()->name.' opened profile';
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        $dir_name = get_usermeta(Auth::user()->id, 'dir_name');
        if(empty($dir_name)) {
            $email = $user->email;
            $dir_name = trim($email); 
            $dir_name_arr = explode('@', $dir_name);
            $dir_name = $dir_name_arr[0].'_'.date('Ymdhis');
            update_usermeta(Auth::user()->id, 'dir_name', $dir_name);
            $folder_name = 'User Documents';
            $dir = '/';
            $recursive = false; // Get subdirectories also?
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

            $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $folder_name)
                ->first(); // There could be duplicate directory names!

            $sub_contents = collect(Storage::disk('google')->listContents($dir['path'], $recursive));

            $sub_dir = $sub_contents->where('type', '=', 'dir')
                ->where('filename', '=', $dir_name)
                ->first(); // There could be duplicate directory names!

            if ( ! $sub_dir) {
                Storage::disk('google')->makeDirectory($dir['path'].'/'.$dir_name);
            }
        }
        if($user_role == 10) {
            return view('profile.index', compact('user', $user));
        }else {
            return view('non_admin.profile.index', compact('user', $user));
        }
    }
    public function update(Request $request)
    {
    	$id = Auth::user()->id;
        if(!empty($data['password'])) {
            $data = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile' => ['required', 'string', 'max:10', 'min:10'],
                'address' => ['max:255'],
                'password' => ['required', 'string', 'min:8'],
                'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ],
                'attachment_id' => ['array' ]
            ])->validate();
        }else {
            $data = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile' => ['required', 'string', 'max:10', 'min:10'],
                'address' => ['max:255'],
                'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ],
                'attachment_id' => ['array' ]
            ])->validate();
        }

        $email_user = User::where('email', trim($data['email']))->first();
        if($email_user) {
            $email_user_data = $email_user->toArray();
            if($email_user_data['id'] != $id) {
                session()->flash("profileErrorMsg", "Email already exists.");
                return redirect('profile');
            }
        }

        $username = User::where('username', trim($data['username']))->first();
        if($username) {
            $username_data = $username->toArray();
            if($username_data['id'] != $id) {
                session()->flash("profileErrorMsg", "Username already exists.");
                return redirect('profile');
            }
        }

        $user = User::find($id);
        $user->name = trim($data['name']);
        $user->email = trim($data['email']);
        if(!empty($data['password'])) {
            $user->password = $data['password'];
        }
        
        $is_user_updated = $user->save();

        if($is_user_updated) {
            update_usermeta($id, 'mobile', $data['mobile']);
            update_usermeta($id, 'address', empty($data['address']) ? '' : $data['address']);
            update_usermeta($id, 'updated_by', $id);
            update_usermeta($id, 'id_proof', isset($data['attachment_id']) ? $data['attachment_id'] : []);
            if($request->hasFile('profile_image')) {

                $dir = 'public/'.date('Y')."/".date('m');
                Storage::makeDirectory($dir);
                $file = Storage::putFile($dir, $request->file('profile_image'));
                if(!empty($file)) {
                    $file = ltrim($file, 'public/');

                    $is_saved = update_usermeta($id, '_profile_image', $file);

                    if($is_saved) {
                        $activity_title = Auth::user()->name.' updated profile';
                        update_masterlogs(Auth::user()->id, 0, $activity_title);
                      session()->flash("profileSuccessMsg", "Your profile has been updated successfully");  
                    }else {
                        session()->flash("profileErrorMsg", "Your profile has been updated.But profile image can not be uploaded.");
                    }
                }else {
                    session()->flash("profileErrorMsg", "Your profile has been updated.But profile image can not be uploaded.");
                }
            }else {
                session()->flash("profileSuccessMsg", "Your profile has been updated successfully");
            }  
        }else {
            session()->flash("profileErrorMsg", "Your profile can not be updated.Please try again.");
        }

        return redirect('profile');
    }

    public function change_image(Request $request) {
        $data = Validator::make($request->all(), [
            'profile_image' => ['required', 'mimes:jpeg,jpg,png,gif','max:2048' ]
        ])->validate();

        if($request->hasFile('profile_image')) {

            $dir = 'public/'.date('Y')."/".date('m');
            Storage::makeDirectory($dir);
            $file = Storage::putFile($dir, $request->file('profile_image'));
            if(!empty($file)) {
                $file = ltrim($file, 'public/');
                $activity_title = Auth::user()->name.' updated profile image';
                update_masterlogs(Auth::user()->id, 0, $activity_title);
                update_usermeta(Auth::user()->id, '_profile_image', $file);
            }
        }
    }
}
