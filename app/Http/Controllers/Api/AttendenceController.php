<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Attendence;
use App\Userrole;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use Validator;

class AttendenceController extends Controller
{
	public function index(Request $request) {
		$data = Validator::make($request->all(), [
	            'start_date' => ['required', 'date_format:Y-m-d'],
	            'end_date' => ['required', 'date_format:Y-m-d'],
	            'employee_id' => ['integer'],
	            'user_id' => ['required', 'integer'],
	        ])->validate();

		$response = [];

		$user_role = get_usermeta($data['user_id'], '_userrole_id');

		$user = User::find($data['user_id']);

		$activity_title = $user->name.' opened attendence';
        update_masterlogs($data['user_id'], 0, $activity_title);

        $start_date = date('Y-m-d H:i:s', strtotime($data['start_date']));
        $end_date = date('Y-m-d H:i:s', strtotime($data['end_date']));

    	if($user_role == 10) {
            if($data['employee_id'] > 0) {
                if($start_date == $end_date) {
                    $attendences = Attendence::where('user_id', $data['employee_id'])->whereDate('logged_at', $start_date)->get();
                }else {
                    $attendences = Attendence::where('user_id', $data['employee_id'])->whereBetween('logged_at', [$start_date, $end_date])->get();
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
                $attendences = Attendence::where('user_id', $data['user_id'])->where('logged_at', $start_date)->get();
            }else {
                $attendences = Attendence::where('user_id', $data['user_id'])->whereBetween('logged_at', [$start_date, $end_date])->get();
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

    		$response['attendence'][$key]['id'] = $attendence->id;
            $response['attendence'][$key]['user_id'] = $attendence->user_id;
		    if($profile_image == null) {
		    	$response['attendence'][$key]['profile_image'] = asset('/public/images/default-user.jpg');
		    }else {
		    	$response['attendence'][$key]['profile_image'] = url('public/storage/' . $profile_image);
		    }
    		$response['attendence'][$key]['user_name'] = isset($attendence_user->name) ? $attendence_user->name : '';
    		$response['attendence'][$key]['role_name'] = $role_name;
    		$response['attendence'][$key]['user_ip'] = $attendence->user_ip;
    		$response['attendence'][$key]['city'] = $attendence->city;
    		$response['attendence'][$key]['region'] = $attendence->region;
    		$response['attendence'][$key]['country'] = $attendence->country;
    		$response['attendence'][$key]['postal'] = $attendence->postal;
    		$response['attendence'][$key]['latitude'] = $attendence->latitude;
    		$response['attendence'][$key]['longitude'] = $attendence->longitude;
            $response['attendence'][$key]['note'] = $attendence->note;

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

                $response['attendence'][$key]['os'] = $os;
	    		$response['attendence'][$key]['browser'] = $browser;
	    		$response['attendence'][$key]['device'] = $device;
            } 
    		
    		$response['attendence'][$key]['logged_at'] = date('M j, Y g:i A', strtotime($attendence->logged_at));
            $response['attendence'][$key]['logged_out_at'] = $attendence->logged_out_at;
    	}

    	return response($response, 201);
	}
}