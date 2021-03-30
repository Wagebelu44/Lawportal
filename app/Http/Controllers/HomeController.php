<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Attendence;
use App\Userrole;
use App\User;
use App\Master;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$response = Http::get('http://bhashsms.com/api/sendmsg.php?user=shainelex&pass=123456&sender=SLALLP&phone=6290648226&text=Test SMS&priority=ndnd&stype=normal');

        $data = [];
        $data['attendences'] = [];
        $data['cases'] = [];
        $data['todos'] = [];
        $data['client_count'] = 0;
        $data['case_count'] = 0;
        $data['employee_count'] = 0;
        $data['todo_count'] = 0;
        $master_ids = [];
        $admin_id = 10;
        $user_role_id = get_usermeta(Auth::user()->id, '_userrole_id');
        $projects = User::find(Auth::user()->id)->todoassignees;

        $data['employee_count'] = User::join('usermetas', function ($join) {
                                $join->on('users.id', '=', 'usermetas.user_id')
                                    ->where('usermetas.meta_key', '_userrole_id')
                                    ->whereNotIn('usermetas.meta_value', [2, 3, 18]);
                            })
                            ->where([['users.active', 1], ['users.id', '!=', 29]])
                            ->count();
        $data['client_count'] = User::join('usermetas', function ($join) {
                                $join->on('users.id', '=', 'usermetas.user_id')
                                    ->where('usermetas.meta_key', '_userrole_id')
                                    ->where('usermetas.meta_value', 2);
                            })
                            ->where('users.active', 1)
                            ->count();

        foreach ($projects as $key => $project) {
            $master_ids[$key] = $project->master_id;
        }

        if($user_role_id == 10) {
            $attendences = Attendence::whereDate('logged_at', '=', date('Y-m-d'))->orderByDesc('logged_at')->get();
        }else {
            $attendences = Attendence::whereDate('logged_at', '>=', date('Y-m-d',strtotime("-5 days")))->where('user_id', Auth::user()->id)->orderByDesc('logged_at')->get();
        }

        if(count($attendences)) {
            foreach ($attendences as $key => $attendence) {
                $attendence_user = get_user($attendence->user_id);
                if($attendence_user) {
	                $profile_image = get_usermeta($attendence->user_id, '_profile_image');
	                $userrole_id = get_usermeta($attendence->user_id, '_userrole_id');
	                $role_name = '';
	                if($userrole_id) {
	                    $userrole = Userrole::select('name')->where('id', $userrole_id)->first();
	                    $role_name = isset($userrole->name) ? $userrole->name : '';
	                }

	                $data['attendences'][$key]['user_id'] = $attendence->user_id;
	                $data['attendences'][$key]['profile_image'] = $profile_image;
	                $data['attendences'][$key]['user_name'] = $attendence_user->name;
	                $data['attendences'][$key]['role_name'] = $role_name;
	                $data['attendences'][$key]['logged_at'] = date('M j, Y g:i A', strtotime($attendence->logged_at));
                	
                }
            }
        }

        if($user_role_id == 2) {
            $hearings = DB::table('masters')->where('master_type', 'hearing')
                        ->join('mastermetas', function ($join) {
                            $join->on('masters.id', '=', 'mastermetas.master_id');
                        })
                        ->orderByDesc('mastermetas.meta_value')
                        ->get();
        }else {
            $hearings = DB::table('masters')->where('master_type', 'hearing')
                        ->join('mastermetas', function ($join) {
                            $join->on('masters.id', '=', 'mastermetas.master_id')
                                ->where('mastermetas.meta_key', 'hearing_date')
                                ->where('mastermetas.meta_value', '>=', date('Y-m-d'));
                        })
                        ->orderByDesc('mastermetas.meta_value')
                        ->get();
        }
        $hearing_arr = [];
        $client_masters = DB::table('mastermetas')->select('master_id')->where([['meta_key', 'client_id'], ['meta_value', Auth::user()->id]])->get();

        $client_master_ids = [];
        foreach ($client_masters as $client_master) {
            array_push($client_master_ids, $client_master->master_id);
        }

        foreach ($hearings as $key => $hearing) {
            $hearing_arr[$hearing->master_parent_id] = $hearing->meta_value;
        }
        $i = 0;
        if($user_role_id == 10) {
            foreach ($hearing_arr as $master_id => $hearing) {
                $case_detail = DB::table('masters')->where([['master_type', 'case'], ['masters.id', $master_id], ['active', 1]])
                                ->join('mastermetas', function ($join) {
                                    $join->on('masters.id', '=', 'mastermetas.master_id');
                                })
                                ->first();
                if($case_detail) {
                    $data['cases'][$i]['id'] = $master_id;
                    $data['cases'][$i]['name'] = $case_detail->name;
                    $data['cases'][$i]['hearing_date'] = date('F d, Y', strtotime($hearing));
                    $data['cases'][$i]['court_name'] = '';
                    $court_id = get_mastermeta($master_id, 'court_id');
                    if($court_id) {
                        $court = Master::select('name')->where([['id', $court_id], ['master_type', 'court']])->first();
                        $data['cases'][$i]['court_name'] = $court->name;
                    }
                    $data['case_count']++;
                    $i++;
                }
            }
        }elseif($user_role_id == 2) {
            foreach ($hearing_arr as $master_id => $hearing) {
                if(in_array($master_id, $client_master_ids)) {
                    $case_detail = DB::table('masters')->where([['master_type', 'case'], ['masters.id', $master_id], ['active', 1]])
                                    ->join('mastermetas', function ($join) {
                                        $join->on('masters.id', '=', 'mastermetas.master_id')
                                            ->where('mastermetas.meta_key', 'case_status')
                                            ->where('mastermetas.meta_value', 'active');
                                    })
                                    ->first();
                    if($case_detail) {
                        $data['cases'][$i]['id'] = $master_id;
                        $data['cases'][$i]['name'] = $case_detail->name;
                        $data['cases'][$i]['hearing_date'] = date('F d, Y', strtotime($hearing));
                        $data['cases'][$i]['court_name'] = '';
                        $court_id = get_mastermeta($master_id, 'court_id');
                        if($court_id) {
                            $court = Master::select('name')->where([['id', $court_id], ['master_type', 'court']])->first();
                            $data['cases'][$i]['court_name'] = $court->name;
                        }
                        $data['case_count']++;
                        $i++;
                    }
                }
            }
        }else {
            foreach ($hearing_arr as $master_id => $hearing) {
                if(in_array($master_id, $master_ids)) {
                    $case_detail = DB::table('masters')->where([['master_type', 'case'], ['masters.id', $master_id], ['active', 1]])
                                    ->join('mastermetas', function ($join) {
                                        $join->on('masters.id', '=', 'mastermetas.master_id')
                                            ->where('mastermetas.meta_key', 'case_status')
                                            ->where('mastermetas.meta_value', 'active');
                                    })
                                    ->first();
                    if($case_detail) {
                        $data['cases'][$i]['id'] = $master_id;
                        $data['cases'][$i]['name'] = $case_detail->name;
                        $data['cases'][$i]['hearing_date'] = date('F d, Y', strtotime($hearing));
                        $data['cases'][$i]['court_name'] = '';
                        $court_id = get_mastermeta($master_id, 'court_id');
                        if($court_id) {
                            $court = Master::select('name')->where([['id', $court_id], ['master_type', 'court']])->first();
                            $data['cases'][$i]['court_name'] = $court->name;
                        }
                        $data['case_count']++;
                        $i++;
                    }
                }
            }
        }

        $todos_with_date = DB::table('masters')->where([['master_type', 'todo'], ['active', 1]])
                    ->join('mastermetas', function ($join) {
                        $join->on('masters.id', '=', 'mastermetas.master_id')
                            ->where('mastermetas.meta_key', 'due_date')
                            ->whereBetween('mastermetas.meta_value',[date('Y-m-d'), date('Y-m-d',strtotime("+7 days"))]);
                    })
                    ->orderByDesc('mastermetas.meta_value')
                    ->get();
        if($user_role_id == 10) {
            foreach ($todos_with_date as $key => $todo) {
                $todos_with_status = DB::table('masters')->where('masters.id', $todo->master_id)
                        ->join('mastermetas', function ($join) {
                            $join->on('masters.id', '=', 'mastermetas.master_id')
                                ->where('mastermetas.meta_key', 'is_completed')
                                ->where('mastermetas.meta_value', 0);
                        })
                        ->orderByDesc('mastermetas.meta_value')
                        ->first();

                $data['todos'][$key]['name'] = $todo->name;

                $data['todos'][$key]['priority'] = empty(get_mastermeta($todo->master_id, 'priority')) ? 'high' : get_mastermeta($todo->master_id, 'priority');
                $data['todos'][$key]['due_date'] = date('F d, Y', strtotime($todo->meta_value));

                $data['todo_count']++;
            }
        }else {
            foreach ($todos_with_date as $key => $todo) {
                if(in_array($todo->master_id, $master_ids)) {
                    $todos_with_status = DB::table('masters')->where('masters.id', $todo->master_id)
                            ->join('mastermetas', function ($join) {
                                $join->on('masters.id', '=', 'mastermetas.master_id')
                                    ->where('mastermetas.meta_key', 'is_completed')
                                    ->where('mastermetas.meta_value', 0);
                            })
                            ->orderByDesc('mastermetas.meta_value')
                            ->first();

                    $data['todos'][$key]['name'] = $todo->name;

                    $data['todos'][$key]['priority'] = empty(get_mastermeta($todo->master_id, 'priority')) ? 'high' : get_mastermeta($todo->master_id, 'priority');
                    $data['todos'][$key]['due_date'] = date('F d, Y', strtotime($todo->meta_value));
                }

                $data['todo_count']++;
            }
        }

        $data['holidays'] = DB::table('masters')->where([['master_type', 'holiday'], ['active', 1]])->join('mastermetas', function ($join) {
                        $join->on('masters.id', '=', 'mastermetas.master_id')
                            ->where('mastermetas.meta_key', 'holiday_date')
                            ->whereDate('mastermetas.meta_value', '>', date('Y-m-d'))
                            ->orderBy('mastermetas.meta_value', 'asc');
                    })
                    ->get();

        $activity_title = Auth::user()->name.' opened dashboard';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) {            
            return view('home', compact('data'));
        }else {
            return view('non_admin.home', compact('data'));
        }
    }
}
