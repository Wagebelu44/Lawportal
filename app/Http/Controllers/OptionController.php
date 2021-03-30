<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Rules\CheckIfFavicon;
use Validator;
use App\Option;

class OptionController extends Controller
{
	public function index() {
		$user_role = get_usermeta(Auth::user()->id, '_userrole_id');

		if($user_role == 10) {
            return view('option.index');
        }else {
            return view('non_admin.option.index');
        }
	}

    public function update(Request $request) {
    	$data = Validator::make($request->all(), [
            'site_name' => ['required', 'string', 'max:255'],
            'site_logo' => ['mimes:jpeg,png','max:2048'],
            'site_favicon' => ['max:2048', new CheckIfFavicon],
            'site_email' => ['required', 'string', 'max:255'],
            'site_copyright' => ['required', 'string', 'max:255'],
            'office_start' => ['required', 'string', 'max:255'],
            'office_end' => ['required', 'string', 'max:255'],
        ])->validate();

        foreach ($data as $option_name => $option_value) {
        	if(!in_array($option_name, array('site_logo', 'site_favicon'))) {
	        	$option = Option::where('option_name', $option_name)->first();
	        	if($option) {
	        		$option->option_name = $option_name;
                    $option->option_value = $option_value;
	        		$option->save();
	        	}else {
	        		$option = new Option;
	        		$option->option_name = $option_name;
                    $option->option_value = $option_value;
	        		$option->save();
	        	}
        	}
        }

        if($request->hasFile('site_logo')) {
            $dir = 'public/'.date('Y')."/".date('m');
            Storage::makeDirectory($dir);
            $file = Storage::putFile($dir, $request->file('site_logo'));
            if(!empty($file)) {
                $file = ltrim($file, 'public/');

                $option = Option::where('option_name', 'site_logo')->first();
	        	if($option) {
                    $option->option_name = 'site_logo';
                    $option->option_value = $file;
	        		$option->save();
	        	}else {
	        		$option = new Option;
	        		$option->option_name = 'site_logo';
                    $option->option_value = $file;
	        		$option->save();
	        	}
            }
        }

        if($request->hasFile('site_favicon')) {
            $dir = 'public/'.date('Y')."/".date('m');
            Storage::makeDirectory($dir);
            $file = Storage::putFile($dir, $request->file('site_favicon'));
            if(!empty($file)) {
                $file = ltrim($file, 'public/');

                $option = Option::where('option_name', 'site_favicon')->first();
	        	if($option) {
                    $option->option_name = 'site_favicon';
                    $option->option_value = $file;
	        		$option->save();
	        	}else {
	        		$option = new Option;
	        		$option->option_name = 'site_favicon';
                    $option->option_value = $file;
	        		$option->save();
	        	}
            }
        }

        session()->flash("optionSuccessMsg", "Site settings has been updated");
        return redirect('settings');
    }
}
