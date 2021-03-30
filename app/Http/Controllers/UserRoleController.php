<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Userrole;
use App\Userform;
use App\Formfield;
use App\Permission;
use App\Permission_role;
use App\Permission_parent;

class UserRoleController extends Controller
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
        $userroles = Userrole::where('active', 1)->orderBy("id", "desc")->get();
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        $activity_title = Auth::user()->name.' opened user role';
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        if($user_role == 10) {
            return view('userrole.index', compact("userroles"));
        }else {
            return view('non_admin.userrole.index', compact("userroles"));
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
        $data['formfields'] = Formfield::where('active', 1)->orderBy("id", "desc")->get();
       
        $data['permission_parents'] = Permission_parent::select('id', 'name')->where('active', 1)->get();

        $activity_title = Auth::user()->name.' opened create user role';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) {
            return view('userrole.create', compact("data"));
        }else {
            return view('non_admin.userrole.create', compact("data"));
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
            'permission_id' => ['array'],
            'formfield' => ['array'],
        ])->validate();

        $userrole = new Userrole;
        $userrole->name = trim($data['name']);
        $userrole->created_by = Auth::user()->id;
        $userrole->updated_by = Auth::user()->id;
        $is_saved = $userrole->save();

        if($is_saved) {
            if(isset($data['permission_id']) && count($data['permission_id'])) {
                foreach ($data['permission_id'] as $permission_id) {
                    $permission_role = new Permission_role;
                    $permission_role->permission_id = $permission_id;
                    $permission_role->userrole_id = $userrole->id;
                    $permission_role->save();
                }
            }

            if(isset($data['formfield']) && count($data['formfield'])) {
                foreach ($data['formfield'] as $formfield) {
                    $is_field_exist = Formfield::where('id', $formfield)->first();

                    if($is_field_exist) {
                        $userform = new Userform;
                        $userform->userrole_id = $userrole->id;
                        $userform->formfield_id = $formfield;
                        $userform->save();
                    }
                }
            }

            $activity_title = Auth::user()->name.' created '.$userrole->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);
            session()->flash("userroleSuccessMsg", "User Role has been created successfully.");
        }else {
            session()->flash("userroleErrorMsg", "User Role can not be created.Please try again.");
        }

        return redirect('userrole/'.$userrole->id.'/edit');
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
        $data['formfields'] = Formfield::where('active', 1)->orderBy("id", "desc")->get();
        $data['userrole'] = Userrole::find($id);
        $data['userform'] = Userrole::find($id)->userform;
        $data['permission_parents'] = Permission_parent::select('id', 'name')->where('active', 1)->get();
        $data['permission_roles'] = Userrole::find($id)->permission_role;
        $activity_title = Auth::user()->name.' opened edit '.$data['userrole']->name;
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) {
            return view('userrole.edit', compact('data'));
        }else {
            return view('non_admin.userrole.edit', compact('data'));
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
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'permission_id' => ['array'],
            'formfield' => ['array'],
        ])->validate();

        $userrole = Userrole::find($id);
        $userrole->name = trim($data['name']);
        $userrole->updated_by = Auth::user()->id;
        $is_saved = $userrole->save();

        if($is_saved) {
            Permission_role::where('userrole_id', $id)->delete();
            if(isset($data['permission_id']) && count($data['permission_id'])) {
                foreach ($data['permission_id'] as $permission_id) {
                    $permission_role = new Permission_role;
                    $permission_role->permission_id = $permission_id;
                    $permission_role->userrole_id = $id;
                    $permission_role->save();
                }
            }
            Userform::where('userrole_id', $id)->delete();

            if(isset($data['formfield']) && count($data['formfield'])) {
                foreach ($data['formfield'] as $formfield) {
                    $is_field_exist = Formfield::where('id', $formfield)->first();

                    if($is_field_exist) {
                        $userform = new Userform;
                        $userform->userrole_id = $userrole->id;
                        $userform->formfield_id = $formfield;
                        $userform->save();
                    }
                }
            }
            $activity_title = Auth::user()->name.' updated '.$userrole->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);

            session()->flash("userroleSuccessMsg", "User Role has been updated successfully.");
        }else {
            session()->flash("userroleErrorMsg", "User Role can not be updated.Please try again.");
        }

        return redirect('userrole/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userrole = Userrole::find($id);
        $userrole->active = 0;
        $userrole->updated_by = Auth::user()->id;
        $is_saved = $userrole->save();

        if($is_saved) {
            $activity_title = Auth::user()->name.' deleted '.$userrole->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);
            session()->flash("userroleDelSuccessMsg", "User Role has been deleted successfully");  
        }else {
            session()->flash("userroleDelErrorMsg", "User Role can not be deleted.Please try again.");
        }

        return redirect('userrole');
    }
}
