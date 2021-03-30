<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Attendence;
use App\Logged_detail;
use App\Userrole;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use App\User;

class AttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
    }

    public function index()
    {
        
    	$data = [];
        $data['attendence'] = [];
        $data['user_id'] = isset($_GET['user_id']) && !empty($_GET['user_id']) ? $_GET['user_id'] : 0;
        
        $data['attendence_date_range'] = isset($_GET['attendence_date_range']) ? $_GET['attendence_date_range'] : '';
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');

        $activity_title = Auth::user()->name.' opened attendence';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        if(!empty($data['attendence_date_range'])) {
            $attendence_date_range = explode('-', $data['attendence_date_range']);
            $start_date = date('Y-m-d H:i:s', strtotime($attendence_date_range[0]));
            $end_date = date('Y-m-d H:i:s', strtotime($attendence_date_range[1]));

        	if($user_role == 10) {
                if($data['user_id'] > 0) {
                    if($start_date == $end_date) {
                        $attendences = Attendence::where('user_id', $data['user_id'])->whereDate('logged_at', $start_date)->get();
                    }else {
                        $attendences = Attendence::where('user_id', $data['user_id'])->whereBetween('logged_at', [$start_date, $end_date])->get();
                    }

                }else {
                    if($start_date == $end_date) {
                        $attendences = Attendence::whereDate('logged_at', $start_date)->get();
                    }else {
                        $attendences = Attendence::whereBetween('logged_at', [$start_date, $end_date])->get();
                    }
                }
            }else {
                if($start_date == $end_date) {
                    $attendences = Attendence::where('user_id', Auth::user()->id)->where('logged_at', $start_date)->get();
                }else {
                    $attendences = Attendence::where('user_id', Auth::user()->id)->whereBetween('logged_at', [$start_date, $end_date])->get();
                }
            }

        	foreach ($attendences as $key => $attendence) {
    			$attendence_user = get_user($attendence->user_id);
        		$profile_image = get_usermeta($attendence->user_id, '_profile_image');
    			$userrole_id = get_usermeta($attendence->user_id, '_userrole_id');
    			$role_name = '';
    			if($userrole_id) {
    				$userrole = Userrole::select('name')->where('id', $userrole_id)->first();
    				$role_name = isset($userrole->name) ? $userrole->name : '';
    			}

        		$data['attendence'][$key]['id'] = $attendence->id;
                $data['attendence'][$key]['user_id'] = $attendence->user_id;
        		$data['attendence'][$key]['profile_image'] = $profile_image;
        		$data['attendence'][$key]['user_name'] = isset($attendence_user->name) ? $attendence_user->name : '';
        		$data['attendence'][$key]['role_name'] = $role_name;
        		$data['attendence'][$key]['user_ip'] = $attendence->user_ip;
        		$data['attendence'][$key]['city'] = $attendence->city;
        		$data['attendence'][$key]['region'] = $attendence->region;
        		$data['attendence'][$key]['country'] = $attendence->country;
        		$data['attendence'][$key]['postal'] = $attendence->postal;
        		$data['attendence'][$key]['latitude'] = $attendence->latitude;
        		$data['attendence'][$key]['longitude'] = $attendence->longitude;
                $data['attendence'][$key]['note'] = $attendence->note;

                $dd = new DeviceDetector($attendence->user_agent);
                $dd->parse();
                $dd->isBot();            

                if ( !$dd->isBot() ){
                    $clientInfo = $dd->getClient();
                    $osInfo     = $dd->getOs();
                    $device     = $dd->getDeviceName();

                    if( $osInfo['platform'] != '' ){
                        $os = $osInfo['name'].'('.$osInfo['platform'].')';
                    }
                    else{
                        $os = $osInfo['name'];
                    }

                    if( $clientInfo['version'] != '' ){
                        $browser = $clientInfo['name'].'('.$clientInfo['version'].')';
                    }
                    else{
                        $browser = $clientInfo['name'];
                    }

                    $data['attendence'][$key]['os'] = $os;
    	    		$data['attendence'][$key]['browser'] = $browser;
    	    		$data['attendence'][$key]['device'] = $device;
                } 
        		
        		$data['attendence'][$key]['logged_at'] = date('M j, Y g:i A', strtotime($attendence->logged_at));
                $data['attendence'][$key]['logged_out_at'] = $attendence->logged_out_at;
        	}
        }

        
        if($user_role == 10) { 
            $data['employees'] = User::select('users.id as id', 'users.name as name')
                ->join('usermetas', function ($join) {
                    $join->on('users.id', '=', 'usermetas.user_id')
                        ->where('usermetas.meta_key', '_userrole_id')
                        ->whereNotIn('usermetas.meta_value', [2, 3]);
                })
                ->orderBy('users.name')
                ->get();

            return view('attendence.index', compact('data'));
        }else {
            return view('non_admin.attendence.index', compact('data'));
        }
    }

    public function get_single_attendence($id) {
        $log_date = isset($_GET['log_date']) ? $_GET['log_date'] : '';
        if(empty($_GET['log_date'])) {
            $query = Logged_detail::select('logged_at','logged_out_at')->where('user_id', $id);
        }else {
            $query = Logged_detail::select('logged_at','logged_out_at')->where('user_id', $id)->whereDate('logged_at', '=', date('Y-m-d', strtotime($log_date)));
        }
        return datatables()->eloquent($query)->toJson();
    }

    public function create()
    {
        $data = [];
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        $data['employees'] = User::select('users.id as id', 'users.name as name')
                ->join('usermetas', function ($join) {
                    $join->on('users.id', '=', 'usermetas.user_id')
                        ->where('usermetas.meta_key', '_userrole_id')
                        ->whereNotIn('usermetas.meta_value', [2, 3, 10]);
                })
                ->orderBy('users.name')
                ->get();

        $activity_title = Auth::user()->name.' opened create attendence';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        if($user_role == 10) { 
            return view('attendence.create', compact("data"));
        }else {
            return view('non_admin.attendence.create', compact("data"));
        }
        
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'logged_at' => ['required', 'string'],
            'logged_out_at' => ['required', 'string']
        ])->validate();

        $data = $request->all();

        $attendence = new Attendence;
        $attendence->user_id = $data['user_id'];
        $attendence->logged_at = date('Y-m-d H:i:s', strtotime($data['logged_at']));
        $attendence->logged_out_at = date('Y-m-d H:i:s', strtotime($data['logged_out_at']));
        $attendence->note = $data['note'];
        $is_saved = $attendence->save();
        if($is_saved) {
            $user = User::find($data['user_id']);
            $activity_title = Auth::user()->name.' created an attendence for '.$user->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);

            session()->flash("attendenceSuccessMsg", "Attendence has been created successfully");
        }else {
            session()->flash("attendenceErrorMsg", "Some error occurs.Please try again.");
        }
        
        return redirect('user_attendence');
    }

    public function edit($id)
    {
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        $data['attendence_id'] = $id;
        $attendence = Attendence::find($id);
        $user = User::find($attendence->user_id);
        $activity_title = Auth::user()->name.' open approve attendence for '.$user->name;
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        if($user_role == 10) { 
           return view('attendence.edit', compact("data"));
        }else {
            return view('non_admin.attendence.edit', compact("data"));
        }
        
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'logged_out_at' => ['required', 'string']
        ])->validate();

        $data = $request->all();

        $attendence = Attendence::find($id);
        $attendence->logged_at = date('Y-m-d H:i:s', strtotime($attendence->logged_at));;
        $attendence->logged_out_at = date('Y-m-d H:i:s', strtotime($data['logged_out_at']));
        $attendence->note = $data['note'];
        $is_saved = $attendence->save();
        if($is_saved) {
            $user = User::find($attendence->user_id);
            $activity_title = Auth::user()->name.' approved an attendence for '.$user->name;
            update_masterlogs(Auth::user()->id, 0, $activity_title);
            session()->flash("attendenceSuccessMsg", "Attendence has been updated successfully");
        }else {
            session()->flash("attendenceErrorMsg", "Some error occurs.Please try again.");
        }

        return redirect('user_attendence');
    }
}
