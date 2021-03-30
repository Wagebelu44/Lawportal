<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Master;
use App\Mastermeta;

class AdvtController extends Controller
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
        $advts = Master::where([['active', 1], ['master_type', 'advt']])->orderBy("id", "desc")->get();
        return view('advt.index', compact("advts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advt.create');
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ]
        ])->validate();

        $master = new Master;
        $master->name = trim($data['name']);
        $master->master_type = 'advt';
        $master->create_by = Auth::user()->id;
        $is_saved = $master->save();

        if($is_saved) {

            update_mastermeta($master->id, 'email', trim($data['email']));
            if($request->hasFile('profile_image')) {

                $dir = 'public/'.date('Y')."/".date('m');
                Storage::makeDirectory($dir);
                $file = Storage::putFile($dir, $request->file('profile_image'));
                if(!empty($file)) {
                    $file = ltrim($file, 'public/');

                    $is_saved = update_mastermeta($master->id, '_profile_image', $file);

                    if($is_saved) {
                      session()->flash("advtSuccessMsg", "ADVT has been created successfully");  
                    }else {
                        session()->flash("advtErrorMsg", "ADVT has been created.But profile image can not be uploaded.");
                    }
                }else {
                    session()->flash("advtErrorMsg", "ADVT has been created.But profile image can not be uploaded.");
                }
            }else {
                session()->flash("advtSuccessMsg", "ADVT has been created successfully");
            }  
        }else {
            session()->flash("advtErrorMsg", "ADVT can not be created.Please try again.");
        }

        return redirect('advt/create');
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
        $advt = Master::find($id);
        return view('advt.edit', compact('advt', $advt));
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_image' => ['mimes:jpeg,jpg,png,gif','max:2048' ]
        ])->validate();

        $master = Master::find($id);
        $master->name = trim($data['name']);
        $master->master_type = 'advt';
        $master->create_by = Auth::user()->id;
        $is_saved = $master->save();

        if($is_saved) {

            update_mastermeta($id, 'email', trim($data['email']));
            if($request->hasFile('profile_image')) {

                $dir = 'public/'.date('Y')."/".date('m');
                Storage::makeDirectory($dir);
                $file = Storage::putFile($dir, $request->file('profile_image'));
                if(!empty($file)) {
                    $file = ltrim($file, 'public/');

                    $is_saved = update_mastermeta($id, '_profile_image', $file);

                    if($is_saved) {
                      session()->flash("advtSuccessMsg", "ADVT has been updated successfully");  
                    }else {
                        session()->flash("creErrorMsg", "ADVT has been updated.But profile image can not be uploaded.");
                    }
                }else {
                    session()->flash("creErrorMsg", "ADVT has been updated.But profile image can not be uploaded.");
                }
            }else {
                session()->flash("advtSuccessMsg", "ADVT has been updated successfully");
            }  
        }else {
            session()->flash("advtErrorMsg", "ADVT can not be updated.Please try again.");
        }

        update_masterlogs(Auth::user()->id, $id);

        return redirect('advt/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $master = Master::find($id);
        $master->active = 0;
        $is_saved = $master->save();

        if($is_saved) {
            session()->flash("advtDelSuccessMsg", "ADVT has been deleted successfully");  
        }else {
            session()->flash("advtDelErrorMsg", "ADVT can not be deleted.Please try again.");
        }

        return redirect('advt');
    }
}
