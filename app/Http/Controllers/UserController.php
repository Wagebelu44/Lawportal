<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Usermeta;
use App\Userrole;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $userrole_id = isset($_GET['userrole_id']) ? $_GET['userrole_id'] : 0;
        $data['userrole_id'] = $userrole_id;
        if ($userrole_id > 0) {
            $data['userrole'] = Userrole::find($userrole_id);
            $data['users'] = User::select('users.id as id','name', 'username', 'email', 'active', 'created_at')->where('active', 1)
                            ->join('usermetas', function ($join) use ($userrole_id) {
                                $join->on('users.id', '=', 'usermetas.user_id')
                                    ->where('usermetas.meta_key', '_userrole_id')
                                    ->where('usermetas.meta_value', $userrole_id);
                            })
                            ->orderBy("users.id", "desc")->get();
        }else {
            $data['users'] = User::select('users.id as id', 'users.name as name', 'users.username as username', 'users.email as email', 'users.active as active', 'users.created_at as created_at')
                            ->join('usermetas', function ($join) {
                                $join->on('users.id', '=', 'usermetas.user_id')
                                    ->where('usermetas.meta_key', '_userrole_id')
                                    ->whereNotIn('usermetas.meta_value', [2, 3, 18]);
                            })
                            ->where('users.active', 1)
                            ->orderBy("users.id", "desc")->get();
        }
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($userrole_id > 0) {
            $userrole = Userrole::find($userrole_id);
            $activity_title = Auth::user()->name.' opened '.$userrole->name;
        }else {
            $activity_title = Auth::user()->name.' opened employee';
        }
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        if($user_role == 10) { 
            return view('user.index', compact("data"));
        }else {
            return view('non_admin.user.index', compact("data"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['userrole_id'] = isset($_GET['userrole_id']) ? $_GET['userrole_id'] : 0;
        $data['userroles'] = Userrole::select('id', 'name')->where('active', 1)->orderBy("name", "desc")->get();
        if($data['userrole_id'] > 0) {
            $userrole = Userrole::find($data['userrole_id']);
            $activity_title = Auth::user()->name.' opened create '.$userrole->name;
        }else {
            $activity_title = Auth::user()->name.' opened create employee';
        }
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
            return view('user.create', compact('data'));
        }else {
            return view('non_admin.user.create', compact('data'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:10', 'min:10'],
            'address' => ['max:255'],
            'userrole_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8'],
            'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ],
            'attachment_id' => ['array' ]
        ])->validate();

        $is_userrole = Userrole::find($data['userrole_id']);

        if($is_userrole) {
            $user_data = User::create([
                        'name' => trim($data['name']),
                        'username' => trim($data['username']),
                        'email' => trim($data['email']),
                        'password' => Hash::make($data['password']),
                    ])->toArray();

            if(count($user_data) && isset($user_data['id'])) {

                $dir_name = trim($data['email']); 
                $dir_name_arr = explode('@', $dir_name);
                $dir_name = $dir_name_arr[0].'_'.date('Ymdhis');
                update_usermeta($user_data['id'], 'dir_name', $dir_name);
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

                update_usermeta($user_data['id'], 'mobile', $data['mobile']);
                update_usermeta($user_data['id'], 'address', empty($data['address']) ? '' : $data['address']);
                update_usermeta($user_data['id'], 'created_by', Auth::user()->id);
                update_usermeta($user_data['id'], '_userrole_id', $data['userrole_id']);
                update_usermeta($user_data['id'], 'id_proof', isset($data['attachment_id']) ? $data['attachment_id'] : []);
                if($request->hasFile('profile_image')) {

                    $dir = 'public/'.date('Y')."/".date('m');
                    Storage::makeDirectory($dir);
                    $file = Storage::putFile($dir, $request->file('profile_image'));
                    if(!empty($file)) {
                        $file = ltrim($file, 'public/');

                        $is_saved = update_usermeta($user_data['id'], '_profile_image', $file);

                        if($is_saved) {

                            $activity_title = Auth::user()->name.' created '.$user_data['name'];
                            update_masterlogs(Auth::user()->id, 0, $activity_title);
                          session()->flash("userSuccessMsg", "User has been created successfully");  
                        }else {
                            session()->flash("userErrorMsg", "User has been created.But profile image can not be uploaded.");
                        }
                    }else {
                        session()->flash("userErrorMsg", "User has been created.But profile image can not be uploaded.");
                    }
                }else {
                    session()->flash("userSuccessMsg", "User has been created successfully");
                }  
            }else {
                session()->flash("userErrorMsg", "User can not be created.Please try again.");
            }
        }else {
            session()->flash("userErrorMsg", "User Role is invalid.");
        }

        return redirect('user/'.$user_data['id'].'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['user'] = User::find($id);
        $data['userrole_id'] = get_usermeta($id, '_userrole_id') == null ? 0 : get_usermeta($id, '_userrole_id');
        $data['userroles'] = Userrole::select('id', 'name')->where('active', 1)->orderBy("name", "desc")->get();
        $activity_title = Auth::user()->name.' opened edit '.$data['user']->name;
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');

        $dir_name = get_usermeta($id, 'dir_name');
        if(empty($dir_name)) {
            $email = $data['user']->email;
            $dir_name = trim($email); 
            $dir_name_arr = explode('@', $dir_name);
            $dir_name = $dir_name_arr[0].'_'.date('Ymdhis');
            update_usermeta($id, 'dir_name', $dir_name);
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
            return view('user.edit', compact('data'));
        }else {
            return view('non_admin.user.edit', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        if(!empty($data['password'])) {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile' => ['required', 'string', 'max:10', 'min:10'],
                'address' => ['max:255'],
                'userrole_id' => ['required', 'integer'],
                'password' => ['required', 'string', 'min:8'],
                'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ],
                'attachment_id' => ['array' ]
            ])->validate();
        }else {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile' => ['required', 'string', 'max:10', 'min:10'],
                'address' => ['max:255'],
                'userrole_id' => ['required', 'integer'],
                'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ],
                'attachment_id' => ['array' ]
            ])->validate();
        }
     
        $email_user = User::where('email', trim($data['email']))->first();
        if($email_user) {
            $email_user_data = $email_user->toArray();
            if($email_user_data['id'] != $id) {
                session()->flash("userErrorMsg", "Email already exists.");
                return redirect('user/'.$id.'/edit');
            }
        }

        $username = User::where('username', trim($data['username']))->first();
        if($username) {
            $username_data = $username->toArray();
            if($username_data['id'] != $id) {
                session()->flash("userErrorMsg", "Username already exists.");
                return redirect('user/'.$id.'/edit');
            }
        }

        $is_userrole = Userrole::find($data['userrole_id']);

        if($is_userrole) {
            $user = User::find($id);
            $user->name = trim($data['name']);
            $user->username = trim($data['username']);
            $user->email = trim($data['email']);
            if(!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            
            $is_user_updated = $user->save();

            if($is_user_updated) {
                update_usermeta($id, 'mobile', $data['mobile']);
                update_usermeta($id, 'address', empty($data['address']) ? '' : $data['address']);
                update_usermeta($id, 'updated_by', Auth::user()->id);
                update_usermeta($id, '_userrole_id', $data['userrole_id']);
                update_usermeta($id, 'id_proof', isset($data['attachment_id']) ? $data['attachment_id'] : []);
                if($request->hasFile('profile_image')) {

                    $dir = 'public/'.date('Y')."/".date('m');
                    Storage::makeDirectory($dir);
                    $file = Storage::putFile($dir, $request->file('profile_image'));
                    if(!empty($file)) {
                        $file = ltrim($file, 'public/');

                        $is_saved = update_usermeta($id, '_profile_image', $file);

                        if($is_saved) {
                            $activity_title = Auth::user()->name.' updated '.$user->name;
                            update_masterlogs(Auth::user()->id, 0, $activity_title);
                          session()->flash("userSuccessMsg", "User has been updated successfully");  
                        }else {
                            session()->flash("userErrorMsg", "User has been updated.But profile image can not be uploaded.");
                        }
                    }else {
                        session()->flash("userErrorMsg", "User has been updated.But profile image can not be uploaded.");
                    }
                }else {
                    session()->flash("userSuccessMsg", "User has been updated successfully");
                }  
            }else {
                session()->flash("userErrorMsg", "User can not be updated.Please try again.");
            }
        }else {
            session()->flash("userErrorMsg", "User Role is invalid.");
        }

        return redirect('user/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->active = 0;
        $is_saved = $user->save();

        if($is_saved) {
            $activity_title = Auth::user()->name.' deleted '.$user->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);
            update_usermeta($id, 'updated_by', Auth::user()->id);
            session()->flash("userDelSuccessMsg", "User has been deleted successfully");  
        }else {
            session()->flash("userDelErrorMsg", "User can not be deleted.Please try again.");
        }

        return redirect('user');

    }
}
