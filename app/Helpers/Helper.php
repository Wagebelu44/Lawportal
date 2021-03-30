<?php
use Illuminate\Http\Request;

if (!function_exists('get_user')) {
    function get_user($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();

        if($user) {
            return $user;
        }else {
            return '';
        }

    }
}

if (!function_exists('get_usermeta')) {
	function get_usermeta($user_id, $meta_key)
    {
    	$usermetas = DB::table('usermetas')->select('meta_value')->where([['user_id', $user_id], ['meta_key', $meta_key]])->first();

    	if($usermetas) {
    		return $usermetas->meta_value;
    	}else {
    		return null;
    	}

    }
}

if (!function_exists('update_usermeta')) {
	function update_usermeta($user_id, $meta_key, $meta_value)
    {
        if(is_array($meta_value)) {
            $meta_value = serialize($meta_value);
        }
    	$usermetas = DB::table('usermetas')->select('meta_value')->where([['user_id', $user_id], ['meta_key', $meta_key]])->first();

    	if($usermetas) {
    		$affected = DB::table('usermetas')
              ->where([['user_id', $user_id], ['meta_key', $meta_key]])
              ->update(['meta_value' => $meta_value]);
            if($affected) {
            	return true;
            }else {
            	false;
            }
    	}else {
    		$id = DB::table('usermetas')->insertGetId(
				    ['user_id' => $user_id,'meta_key' => $meta_key, 'meta_value' => $meta_value]
				);
    		if($id) {
            	return true;
            }else {
            	false;
            }
    	}

    }
}

if (!function_exists('get_master')) {
    function get_master($master_id)
    {
        if($master_id != null &&  $master_id > 0) {
            $masters = DB::table('masters')->where('id', $master_id)->first();

            if($masters) {
                return $masters;
            }else {
                return null;
            }

        }else {
            return null;
        }

    }
}

if (!function_exists('get_mastermeta')) {
    function get_mastermeta($master_id, $meta_key)
    {
        $mastermetas = DB::table('mastermetas')->select('meta_value')->where([['master_id', $master_id], ['meta_key', $meta_key]])->first();

        if($mastermetas) {
            return $mastermetas->meta_value;
        }else {
            return null;
        }

    }
}

if (!function_exists('update_mastermeta')) {
    function update_mastermeta($master_id, $meta_key, $meta_value)
    {
        if(is_array($meta_value)) {
            $meta_value = serialize($meta_value);
        }
        $mastermetas = DB::table('mastermetas')->select('meta_value')->where([['master_id', $master_id], ['meta_key', $meta_key]])->first();

        if($mastermetas) {
            $affected = DB::table('mastermetas')
              ->where([['master_id', $master_id], ['meta_key', $meta_key]])
              ->update(['meta_value' => $meta_value]);
            if($affected) {
                return true;
            }else {
                false;
            }
        }else {
            $id = DB::table('mastermetas')->insertGetId(
                    ['master_id' => $master_id,'meta_key' => $meta_key, 'meta_value' => $meta_value]
                );
            if($id) {
                return true;
            }else {
                false;
            }
        }

    }
}

if (!function_exists('get_masterlogs')) {
    function get_masterlogs($master_id)
    {
        $masterlogs = DB::table('masters')->select('create_by', 'created_at')->where([['master_parent_id', $master_id], ['active', 1], ['master_type', 'revision']])->orderBy('id', 'desc')->get()->toArray();

        if($masterlogs) {
            return $masterlogs;
        }else {
            return [];
        }
    }
}

if (!function_exists('update_masterlogs')) {
    function update_masterlogs($user_id, $master_id, $title)
    {
        $id = DB::table('masters')->insertGetId(
                ['name' => $title,'master_type' => 'revision', 'create_by' => $user_id, 'master_parent_id' => $master_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            );
        if($id) {
            return true;
        }else {
            false;
        }
    }
}

if (!function_exists('get_case_hearing_logs')) {
    function get_case_hearing_logs($master_id)
    {
        $hearings = DB::table('masters')->select('create_by', 'created_at', 'id')->where([['master_parent_id', $master_id], ['active', 1], ['master_type', 'hearing']])->orderBy('id', 'desc')->get()->toArray();

        $hearing_arr = [];
        if(count($hearings)) {
            foreach ($hearings as $key => $hearing) {
                $hearing_date = get_mastermeta($hearing->id, 'hearing_date');
                if($hearing_date != null) {
                    $hearing_arr[$key]['hearing_date'] = $hearing_date;
                    $hearing_arr[$key]['created_at'] = $hearing->created_at;
                    $hearing_arr[$key]['create_by'] = $hearing->create_by;
                }
            }
        }
        if($hearing_arr) {
            return $hearing_arr;
        }else {
            return [];
        }
    }
}

if (!function_exists('update_case_hearings')) {
    function update_case_hearings($user_id, $master_id, $hearing_date)
    {
        $master_id = DB::table('masters')->insertGetId(
                ['name' => 'case_hearing','master_type' => 'hearing', 'create_by' => $user_id, 'master_parent_id' => $master_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            );

        $hearing_date = date('Y-m-d', strtotime($hearing_date));

        $is_affected = update_mastermeta($master_id, 'hearing_date', $hearing_date);

        if($is_affected) {
            return true;
        }else {
            false;
        }
    }
}

if (!function_exists('get_master_slugs')) {
    function get_master_slugs()
    {
        return array(
                    'revision' => 'Activity',
                    'court' => 'Court',
                    'state' => 'State',
                    'case_category' => 'Case Category',
                    'case' => 'Case',
                    'todo' => 'Todo',
                    'holiday' => 'Holiday',
                    'evaluation' => 'Assessment',
                    'incident' => 'Admin Work',
                    'file_manager' => 'File Manager',
                    'file_location' => 'Location',
                    'judgement' => 'Judgement',
                    'contact' => 'Contact',
                );
    }
}

if (!function_exists('check_permission')) {
    function check_permission($user_id, $permission, $master_type = '')
    {
        $userrole_id = get_usermeta( $user_id, '_userrole_id' );
        if(is_int($permission)) {
            $count = DB::table('permission_roles')->where([['userrole_id', $userrole_id], ['permission_id', $permission]])->count();
            return $count ? true : false;

        }else {
            if(in_array($permission, array('master.edit', 'master.update', 'master.destroy'))) {
                $id = \Request::segment(2);
             
                if($id > 0) {
                    $master = DB::table('masters')->select('master_type')->where('id', $id)->first();
                    $master_type = $master->master_type;
                }
            }

            $route_name_cnt = DB::table('route_permissions')->where('route_name', $permission)->count();
            if($route_name_cnt) {
                if(empty($master_type)) {
                    $count = DB::table('permission_roles')
                            ->join('route_permissions', 'route_permissions.permission_id', '=', 'permission_roles.permission_id')
                            ->where([['userrole_id', $userrole_id], ['route_name', $permission]])
                            ->count();
                }else {
                    $count = DB::table('permission_roles')
                            ->join('route_permissions', 'route_permissions.permission_id', '=', 'permission_roles.permission_id')
                            ->where([['userrole_id', $userrole_id], ['route_name', $permission], ['master_type', $master_type]])
                            ->count();
                }
                
                return $count ? true : false;
            }else {
                return true;
            }
        }
        
    }
}

if (!function_exists('get_option')) {
    function get_option($option_name)
    {
        $options = DB::table('options')->select('option_value')->where('option_name', $option_name)->first();

        if($options) {
            return $options->option_value;
        }else {
            return '';
        }

    }
}


