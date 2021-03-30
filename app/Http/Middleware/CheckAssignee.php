<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Master;

use Closure;

class CheckAssignee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) {
            return $next($request);
        }else {
            if(in_array(Route::currentRouteName(), array('add.todo.comment', 'change.todo_status', 'mytodo', 'delete_todo_comment', 'update_todo_comment', 'add.incident.comment', 'change.incident_status', 'myincident', 'delete_incident_comment', 'update_incident_comment', ''))) {

                $id = \Request::segment(2);
                $master = Master::find($id);
                if($master->create_by == Auth::user()->id) {
                    return $next($request);
                }else {
                    $todoassignees = $master->todoassignees;
                    $assignee_id_arr = [];
                    foreach ($todoassignees as $todoassignee) {
                        array_push($assignee_id_arr, $todoassignee->user_id);
                    }

                    if(in_array(Auth::user()->id, $assignee_id_arr)) {
                        return $next($request);
                    }else {
                        return redirect('/')->with('permissionError', 'You are not allowed to access this url.');
                    }
                }

            }elseif(Route::currentRouteName() == 'attendence_logs') {
                $id = \Request::segment(2);
                if($id == Auth::user()->id) {
                    return $next($request);
                }else {
                    return redirect('/')->with('permissionError', 'You are not allowed to access this url.');
                }
            }elseif(Route::currentRouteName() == 'evaluation' || Route::currentRouteName() == 'evaluation_review' ) {
                $id = \Request::segment(2);
                $assignee_id = get_mastermeta($id, 'assignee_id');
                if($assignee_id == Auth::user()->id) {
                    return $next($request);
                }else {
                    return redirect('/')->with('permissionError', 'You are not allowed to access this url.');
                }
            }elseif(Route::currentRouteName() == 'master.edit') {
                $id = \Request::segment(2);
                $master = Master::find($id);
                if(in_array($master->master_type, array('case', 'todo', 'evaluation', 'incident'))) {
                    if($master->create_by == Auth::user()->id) {
                        return $next($request);
                    }else {
                        $todoassignees = $master->todoassignees;
                        $assignee_id_arr = [];
                        foreach ($todoassignees as $todoassignee) {
                            array_push($assignee_id_arr, $todoassignee->user_id);
                        }

                        if(in_array(Auth::user()->id, $assignee_id_arr)) {
                            return $next($request);
                        }else {
                            return redirect('/')->with('permissionError', 'You are not allowed to access this url.');
                        }
                    }
                }else {
                    return $next($request);
                }
            }else {
                return $next($request);
            }
  
        }
    }
}
