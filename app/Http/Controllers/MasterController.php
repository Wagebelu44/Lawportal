<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Notifications\TodoCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Master;
use App\Mastermeta;
use App\Usermeta;
use App\User;
use App\Userrole;
use App\Userform;
use App\Formfield;
use App\Todoassignees;
use App\CaseFile;
use App\Objective;
use App\Mail\SendMail;

class MasterController extends Controller
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
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        $masters = get_master_slugs();
        $data = array();
        $data['master_type'] = 'court';
        if(isset($_GET['master_type']) && !empty($_GET['master_type'])) {
           $data['master_type'] = trim($_GET['master_type']); 
        }
        
        if(in_array($data['master_type'], array('case', 'todo', 'evaluation', 'incident'))) {
          if($user_role == 10) { 
            $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']]])->orderBy("created_at", "desc")->get();
          }else {
            $data['masters'] = [];
            $todoassignees = Todoassignees::select('master_id')->where('user_id', Auth::user()->id)->orderBy("master_id", "desc")->get();
            if(count($todoassignees)) {
                foreach ($todoassignees as $todoassignee) {
                    $master = Master::where([['id', $todoassignee->master_id], ['active', 1], ['master_type', $data['master_type']]])->first();
                    if($master) {
                      array_push($data['masters'], $master);
                    }
                }
            }
            $created_master = Master::where([['active', 1], ['master_type', $data['master_type']], ['create_by', Auth::user()->id]])->orderBy("created_at", "desc")->get();
            if(count($created_master)) {
              array_push($data['masters'], $created_master);
            }

          }
        } elseif($data['master_type'] == 'revision') {
          $data['user_id'] = isset($_GET['user_id']) && !empty($_GET['user_id']) ? $_GET['user_id'] : 0;
        
          $data['activity_date_range'] = isset($_GET['activity_date_range']) ? $_GET['activity_date_range'] : '';
          $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
 
          if($user_role == 10) { 
            $data['employees'] = User::select('users.id as id', 'users.name as name')
                  ->join('usermetas', function ($join) {
                      $join->on('users.id', '=', 'usermetas.user_id')
                          ->where('usermetas.meta_key', '_userrole_id')
                          ->whereNotIn('usermetas.meta_value', [2, 3]);
                  })
                  ->where([['users.active', 1], ['users.id', '!=', 29]])
                  ->orderBy('users.name')
                  ->get();
          }

          if(!empty($data['activity_date_range'])) {
            $activity_date_range = explode('-', $data['activity_date_range']);
            $start_date = date('Y-m-d H:i:s', strtotime($activity_date_range[0]));
            $end_date = date('Y-m-d H:i:s', strtotime($activity_date_range[1]));

            if($user_role == 10) { 
              if($data['user_id'] > 0) {
                if($start_date == $end_date) {
                  $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['create_by', $data['user_id']]])->whereDate('created_at', $start_date)->orderBy("created_at", "desc")->get();
                }else {
                  $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['create_by', $data['user_id']]])->whereBetween('created_at', [$start_date, $end_date])->orderBy("created_at", "desc")->get();
                }
              }else {
                if($start_date == $end_date) {
                  $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']]])->whereDate('created_at', $start_date)->orderBy("created_at", "desc")->get();
                }else {
                  $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']]])->whereBetween('created_at', [$start_date, $end_date])->orderBy("created_at", "desc")->get();
                }
                
              }

            }else {
              if($start_date == $end_date) {
                $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['create_by', Auth::user()->id]])->whereDate('created_at', $start_date)->orderBy("created_at", "desc")->get();
              }else {
                $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['create_by', Auth::user()->id]])->whereBetween('created_at', [$start_date, $end_date])->orderBy("created_at", "desc")->get();
              }
            }
          }
          
        }else {
          $data['masters'] = Master::where([['active', 1], ['master_type', $data['master_type']]])->orderBy("created_at", "desc")->get();
        }

        $activity_title = Auth::user()->name.' opened '.$masters[trim($data['master_type'])];
        update_masterlogs(Auth::user()->id, 0, $activity_title);
        
        if($user_role == 10) { 
          return view('master.index', compact("data"));
        }else {
          return view('non_admin.master.index', compact("data"));
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
        $data['master_type'] = 'court';
        $masters = get_master_slugs();
        if(isset($_GET['master_type']) && !empty($_GET['master_type'])) {
           $data['master_type'] = trim($_GET['master_type']); 
           $has_sub_master_arr = array('court', 'state', 'case_category');

           if(in_array($data['master_type'], $has_sub_master_arr)) {
              $data['parents'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['master_parent_id', 0]])->orderBy("name", "asc")->get();
           }

           if($data['master_type'] == 'case' || $data['master_type'] == 'todo' || $data['master_type'] == 'evaluation' || $data['master_type'] == 'incident') {
                $data['employees'] = [];
                $i = 0;
                $userroles = Userrole::select('id')->get();
                foreach ($userroles as $userrole) {
                    $userforms = Userform::select('formfield_id')->where('userrole_id', $userrole->id)->get();
                    if($userforms) {
                        $formfield_id_arr = [];
                        foreach ($userforms as $userform) {
                            array_push($formfield_id_arr, $userform->formfield_id);
                        }

                        if(!in_array(5, $formfield_id_arr) && !in_array(6, $formfield_id_arr)) {
                            $usermetas = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $userrole->id]])->get();
                            foreach ($usermetas as $usermeta) {
                            
                               $user = User::select('id', 'name')->where([['id', $usermeta->user_id], ['active', 1], ['users.id', '!=', 29]])->first();
                               if($user) {
                                 $profile_image = get_usermeta($usermeta->user_id, '_profile_image');
                                 $data['employees'][$i]['id'] = $user->id;
                                 $data['employees'][$i]['name'] = $user->name;
                                 $data['employees'][$i]['profile_image'] = $profile_image;
                                 $i++;
                               }
                            }

                        }
                    }else {
                        $usermetas = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $userrole->id]])->get();
                        foreach ($usermetas as $usermeta) {
                           $user = User::select('id', 'name')->where([['id', $usermeta->user_id], ['active', 1], ['users.id', '!=', 29]])->first();
                           if($user) {
                             $profile_image = get_usermeta($usermeta->user_id, '_profile_image');
                             $data['employees'][$i]['id'] = $user->id;
                             $data['employees'][$i]['name'] = $user->name;
                             $data['employees'][$i]['profile_image'] = $profile_image;
                             $i++;
                           }
                        }
                    }
                  
                }
           }

           if($data['master_type'] == 'case') {
               $client_userforms = Formfield::find(5)->userform;
               $data['clients'] = [];
               $data['opponents'] = [];
               foreach ($client_userforms as $client_userform) {
                   $users = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $client_userform->userrole_id]])->get();
                
                   foreach ($users as $user) {
                       $clients = User::select('id', 'name')->where([['id', $user->user_id], ['active', 1]])->get();
                       if(count($clients)) {
                        array_push($data['clients'], $clients->toArray());
                       }
                   }
               }

               $opponent_userforms = Formfield::find(6)->userform;

               foreach ($opponent_userforms as $opponent_userform) {
                   $users = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $opponent_userform->userrole_id]])->get();
                   foreach ($users as $user) {
                       $opponents = User::select('id', 'name')->where([['id', $user->user_id], ['active', 1]])->get();
                       if(count($opponents)) {
                          array_push($data['opponents'], $opponents->toArray());
                       }
                   }
               }

               $data['courts'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'court'], ['active', 1]])->get();
               $data['files'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'file_manager'], ['active', 1]])->get();
               $data['subcourts'] = [];
               $data['case_categories'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'case_category'], ['active', 1]])->get();
               $data['case_subcategories'] = [];

           }

           if($data['master_type'] == 'file_manager') {
              $data['file_locations'] = Master::select('id', 'name')->where([['master_type', 'file_location'], ['active', 1]])->get();
            }
        }

        $activity_title = Auth::user()->name.' opened create '.$masters[trim($data['master_type'])];
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
          return view('master.create', compact("data"));
        }else {
          return view('non_admin.master.create', compact("data"));
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
            'holiday_date' => ['required_if:master_type,holiday', 'date_format:d-m-Y'],
            'master_type' => ['required', 'string', 'max:255'],
            'master_parent_id' => ['integer'],
            'client_id' => ['required_if:master_type,case', 'integer'],
            'opponent' => ['required_if:master_type,case', 'string'],
            'court_id' => ['required_if:master_type,case', 'integer'], 
            'subcourt_id' => ['integer'],
            'case_category_id' => ['required_if:master_type,case', 'integer'],
            'case_subcategory_id' => ['integer'],
            'hearing_date' => ['date_format:d-m-Y'],
            'case_status' => ['required_if:master_type,case', 'in:active,suspended,closed'],
            'case_number' => ['required_if:master_type,case,file_manager,judgement', 'string'],
            'file_id' => ['array'],
            'case_description' => ['string'],
            'attachment_id' => ['array'],
            'employee_id' => ['required_if:master_type,todo,case,incident,evaluation', 'array'],
            'due_date' => ['required_if:master_type,todo,incident', 'date_format:d-m-Y'],
            'todo_description' => ['required_if:master_type,todo', 'string'],
            'todo_status' => ['in:1,0'],
            'todo_priority' => ['required_if:master_type,todo', 'in:high,medium,low'],
            'incident_description' => ['required_if:master_type,incident', 'string'],
            'incident_status' => ['in:1,0'],
            'incident_priority' => ['required_if:master_type,incident', 'in:high,medium,low'],
            'assignee_id' => ['required_if:master_type,evaluation', 'integer'],
            'deadline' => ['required_if:master_type,evaluation', 'date_format:d-m-Y'],
            'objective' => ['required_if:master_type,evaluation', 'array'],
            'weightage' => ['required_if:master_type,evaluation', 'array'],
            'file_number' => ['required_if:master_type,file_manager', 'string'],
            'file_matter' => ['required_if:master_type,file_manager', 'string'],
            'file_location_id' => ['required_if:master_type,file_manager', 'integer'],
            'last_update_date' => ['required_if:master_type,file_manager', 'date_format:d-m-Y'],
            'judgement_description' => ['string'],
            'email' => ['required_if:master_type,contact', 'string', 'email', 'max:255'],
            'additional_email' => ['string', 'email', 'max:255'],
            'mobile' => ['required_if:master_type,contact', 'string', 'max:10', 'min:10'],
            'additional_mobile' => ['string', 'max:10', 'min:10'],
            'dob' => ['required_if:master_type,contact', 'date_format:d-m-Y'],
            'anniversary' => ['required_if:master_type,contact', 'date_format:d-m-Y'],
            'comment' => ['string'],
            
        ])->validate();

        $masters = get_master_slugs();
        if(!isset($masters[trim($data['master_type'])])) {
            session()->flash("masterErrorMsg", "Invalid master type.");
            return redirect('master/create?master_type='.trim($data['master_type']));
        }

        $master = new Master;
        $master->name = trim($data['name']);
        $master->master_type = trim($data['master_type']);
        $master->master_parent_id = isset($data['master_parent_id']) ? $data['master_parent_id'] : 0;
        $master->create_by = Auth::user()->id;
        $is_saved = $master->save();

        if($is_saved) {
            if($data['master_type'] == 'case') {
                $dir_name = str_replace(' ', '_', strtolower($data['name'])).'_'.date('Ymdhis'); 
                update_mastermeta($master->id, 'dir_name', $dir_name);
                $folder_name = 'Case Documents';
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
                update_mastermeta($master->id, 'case_number', $data['case_number']);
                update_mastermeta($master->id, 'client_id', $data['client_id']);
                $opponent_email = str_replace(' ', '_', $data['opponent']).date('his');
                $opponent = User::create([
                        'name' => trim($data['opponent']),
                        'username' => trim($data['opponent']),
                        'email' => $opponent_email.'@email.com',
                        'password' => Hash::make('1234'),
                        'active' => 0,
                ])->toArray();

                update_mastermeta($master->id, 'opponent_id', $opponent['id']);
                update_mastermeta($master->id, 'court_id', $data['court_id']);
                update_mastermeta($master->id, 'subcourt_id', isset($data['subcourt_id']) ? $data['subcourt_id'] : 0);
                update_mastermeta($master->id, 'case_category_id', $data['case_category_id']);
                update_mastermeta($master->id, 'case_subcategory_id', isset($data['case_subcategory_id']) ? $data['case_subcategory_id'] : 0);
                update_mastermeta($master->id, 'case_desc', isset($data['case_description']) ? $data['case_description'] : '');
                update_mastermeta($master->id, 'case_doc', isset($data['attachment_id']) ? $data['attachment_id'] : []);
                update_mastermeta($master->id, 'case_status', isset($data['case_status']) ? $data['case_status'] : 'active');
                if(isset($data['hearing_date'])) {
                  update_case_hearings(Auth::user()->id, $master->id, $data['hearing_date']);
                }

                foreach ($data['employee_id'] as $employee_id) {
                    $todoassignees = new Todoassignees;
                    $todoassignees->master_id = $master->id;
                    $todoassignees->user_id = $employee_id;

                    $todoassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' assigned you a case.', 'body' => $data['name'], 'link' => url("/master/".$master->id.'/edit')]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }

                if(isset($data['file_id']) && count($data['file_id'])) {
                  foreach ($data['file_id'] as $file_id) {
                    $casefile = new CaseFile;

                    $casefile->case_id = $master->id;
                    $casefile->file_id = $file_id;

                    $casefile->save();

                  }
                }
            }
            if($data['master_type'] == 'todo') {
                foreach ($data['employee_id'] as $employee_id) {
                    $todoassignees = new Todoassignees;
                    $todoassignees->master_id = $master->id;
                    $todoassignees->user_id = $employee_id;

                    $todoassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' assigned you a todo.', 'body' => $data['name'], 'link' => url("/my_todo/".$master->id)]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }
                update_mastermeta($master->id, 'todo_description', $data['todo_description']);
                update_mastermeta($master->id, 'due_date', date('Y-m-d', strtotime($data['due_date'])));
                update_mastermeta($master->id, 'is_completed', 0);
                
                update_mastermeta($master->id, 'todo_priority', $data['todo_priority']);
                
            }

            if($data['master_type'] == 'incident') {
                foreach ($data['employee_id'] as $employee_id) {
                    $incidentassignees = new Todoassignees;
                    $incidentassignees->master_id = $master->id;
                    $incidentassignees->user_id = $employee_id;

                    $incidentassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' assigned you a incident.', 'body' => $data['name'], 'link' => url("/my_incident/".$master->id)]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }
                update_mastermeta($master->id, 'incident_description', $data['incident_description']);
                update_mastermeta($master->id, 'due_date', date('Y-m-d', strtotime($data['due_date'])));
                update_mastermeta($master->id, 'is_completed', 0);
                update_mastermeta($master->id, 'incident_priority', $data['incident_priority']);
                
            }

            if($data['master_type'] == 'evaluation') {
              update_mastermeta($master->id, 'deadline', date('Y-m-d', strtotime($data['deadline'])));
              
              update_mastermeta($master->id, 'assignee_id', $data['assignee_id']);
              $letter = collect(['title' => Auth::user()->name.' assigned you in an assessment.', 'body' => $data['name'], 'link' => url("/evaluation/".$master->id)]);
              $user = User::find($data['assignee_id']);
              Notification::send($user, new TodoCreated($letter));

              update_mastermeta($master->id, 'is_assignee_accept', 0);

              foreach ($data['employee_id'] as $employee_id) {
                  $incidentassignees = new Todoassignees;
                  $incidentassignees->master_id = $master->id;
                  $incidentassignees->user_id = $employee_id;

                  $incidentassignees->save();

                  if($employee_id != Auth::user()->id) {
                    $user = User::find($employee_id);
                    $letter = collect(['title' => Auth::user()->name.' assigned you as a reviewer in an assessment.', 'body' => $data['name'], 'link' => url("/evaluation/".$master->id)]);
                    Notification::send($user, new TodoCreated($letter));
                  }
              }
              if(isset($data['objective']) && count($data['objective'])) {
                foreach ($data['objective'] as $key => $obj) {
                  $objective = new Objective;
                  $objective->master_id = $master->id;
                  $objective->objective = $obj;
                  $objective->weightage = $data['weightage'][$key];
                  $objective->save();
                }
              }

            }

            if($data['master_type'] == 'holiday') {
              update_mastermeta($master->id, 'holiday_date', date('Y-m-d', strtotime($data['holiday_date'])));
            }

            if($data['master_type'] == 'file_manager') {
              update_mastermeta($master->id, 'file_number', $data['file_number']);
              update_mastermeta($master->id, 'case_number', $data['case_number']);
              update_mastermeta($master->id, 'file_matter', $data['file_matter']);
              update_mastermeta($master->id, 'file_location_id', $data['file_location_id']);
              update_mastermeta($master->id, 'last_update_date', date('Y-m-d', strtotime($data['last_update_date'])));
            }

            if($data['master_type'] == 'judgement') {
              $dir_name = str_replace(' ', '_', strtolower($data['name'])).'_'.date('Ymdhis'); 
              update_mastermeta($master->id, 'dir_name', $dir_name);
              $folder_name = 'Judgement Documents';
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
              update_mastermeta($master->id, 'case_number', $data['case_number']);
              update_mastermeta($master->id, 'judgement_description', $data['judgement_description']);
            }
            
            if($data['master_type'] == 'contact') {
              update_mastermeta($master->id, 'email', $data['email']);
              update_mastermeta($master->id, 'additional_email', $data['additional_email']);
              update_mastermeta($master->id, 'mobile', $data['mobile']);
              update_mastermeta($master->id, 'additional_mobile', $data['additional_mobile']);
              update_mastermeta($master->id, 'dob', date('Y-m-d', strtotime($data['dob'])));
              update_mastermeta($master->id, 'anniversary', date('Y-m-d', strtotime($data['anniversary'])));
              update_mastermeta($master->id, 'comment', $data['comment']);
            }

            $activity_title = Auth::user()->name.' created a '.$masters[trim($data['master_type'])].' "'.trim($data['name']).'"';
            update_masterlogs(Auth::user()->id, $master->id, $activity_title);

            session()->flash("masterSuccessMsg", $masters[trim($data['master_type'])]." has been created successfully");
            return redirect('master/'.$master->id.'/edit');
        }else {
            session()->flash("masterErrorMsg", $masters[trim($data['master_type'])]." can not be created.Please try again.");
            return redirect('master/create');
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = [];
      $masters = get_master_slugs();
      $data['master'] = Master::find($id);
      $data['master_type'] = $data['master']->master_type;
      $data['name'] = $data['master']->name;

      if($data['master_type'] == 'case') {
        $data['client_id'] = get_mastermeta($id, 'client_id');
        $data['opponent_id'] = get_mastermeta($id, 'opponent_id');
        $data['court_id'] = get_mastermeta($id, 'court_id');
        $data['subcourt_id'] = get_mastermeta($id, 'subcourt_id');
        $data['case_category_id'] = get_mastermeta($id, 'case_category_id');
        $data['case_subcategory_id'] = get_mastermeta($id, 'case_subcategory_id');
        $data['case_desc'] = get_mastermeta($id, 'case_desc');
        $data['case_doc'] = get_mastermeta($id, 'case_doc');
        $data['case_doc'] = empty($data['case_doc']) ? [] : unserialize($data['case_doc']);
        $data['case_status'] = get_mastermeta($id, 'case_status');
        $data['hearing_date'] = '';
        $data['todoassignees'] = $data['master']->todoassignees;
        $hearing = Master::select('id')->where([['master_parent_id', $id], ['master_type', 'hearing']])->orderByDesc('id')->first();

        if(isset($hearing->id)) {
          $data['hearing_date'] = date('d-m-Y', strtotime(get_mastermeta($hearing->id, 'hearing_date')));
        }
      

       $data['courts'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'court'], ['active', 1]])->get();
       if($data['subcourt_id'] == 0 || $data['subcourt_id'] == '') {
          $data['subcourts'] = [];
       }else {
        $data['subcourts'] = Master::select('id', 'name')->where([['master_parent_id', $data['court_id']], ['master_type', 'court'], ['active', 1]])->get();
       }
       $data['case_categories'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'case_category'], ['active', 1]])->get();
       if($data['case_subcategory_id'] == 0 || $data['case_subcategory_id'] == '') {
          $data['case_subcategories'] = [];
       }else {
        $data['case_subcategories'] = Master::select('id', 'name')->where([['master_parent_id', $data['case_category_id']], ['master_type', 'case_category'], ['active', 1]])->get();
       }

        $assignees = $data['master']->todoassignees;
        $data['assignees'] = [];

        foreach ($assignees as $assignee) {
            array_push($data['assignees'], $assignee->user_id);
        }

        $data['casefiles'] = DB::table('case_files')->select('name')
                              ->join('masters', function ($join) {
                                    $join->on('case_files.file_id', '=', 'masters.id');
                                })
                              ->where('case_id', $id)
                              ->get();
      }

      $activity_title = Auth::user()->name.' opened view '.$masters[trim($data['master_type'])];
      update_masterlogs(Auth::user()->id, $id, $activity_title);

      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      if($user_role == 10) { 
        return view('master.show', compact('data'));
      }else {
        return view('non_admin.master.show', compact('data'));
      }
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
        $masters = get_master_slugs();
        $data['edit_id'] = $id;
        $data['master'] = Master::find($id);
        $data['master_type'] = $data['master']->master_type;
        $data['master_parent_id'] = $data['master']->master_parent_id;
        $has_sub_master_arr = array('court', 'state', 'case_category');

        if(in_array($data['master_type'], $has_sub_master_arr)) {
          $data['parents'] = Master::where([['active', 1], ['master_type', $data['master_type']], ['master_parent_id', 0]])->orderBy("name", "asc")->get();
        }

        if($data['master_type'] == 'case' || $data['master_type'] == 'todo' || $data['master_type'] == 'evaluation' || $data['master_type'] == 'incident') {
            $data['employees'] = [];
            $i = 0;
            $userroles = Userrole::select('id')->get();
            foreach ($userroles as $userrole) {
                $userforms = Userform::select('formfield_id')->where('userrole_id', $userrole->id)->get();
                if($userforms) {
                    $formfield_id_arr = [];
                    foreach ($userforms as $userform) {
                        array_push($formfield_id_arr, $userform->formfield_id);
                    }

                    if(!in_array(5, $formfield_id_arr) && !in_array(6, $formfield_id_arr)) {
                        $usermetas = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $userrole->id]])->get();
                        foreach ($usermetas as $usermeta) {
                           $user = User::select('id', 'name')->where([['id', $usermeta->user_id], ['active', 1], ['users.id', '!=', 29]])->first();
                           if($user) {
                             $profile_image = get_usermeta($usermeta->user_id, '_profile_image');
                             $data['employees'][$i]['id'] = $user->id;
                             $data['employees'][$i]['name'] = $user->name;
                             $data['employees'][$i]['profile_image'] = $profile_image;
                             $i++;
                           }
                        }

                    }
                }else {
                    $usermetas = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $userrole->id]])->get();
                    foreach ($usermetas as $usermeta) {
                       $user = User::select('id', 'name')->where([['id', $usermeta->user_id], ['active', 1], ['users.id', '!=', 29]])->first();
                       if($user) {
                         $profile_image = get_usermeta($usermeta->user_id, '_profile_image');
                         $data['employees'][$i]['id'] = $user->id;
                         $data['employees'][$i]['name'] = $user->name;
                         $data['employees'][$i]['profile_image'] = $profile_image;
                         $i++;
                       }
                    }
                }
              
            }
        }
        if($data['master_type'] == 'case') {
            $data['case_number'] = get_mastermeta($id, 'case_number');
            $data['client_id'] = get_mastermeta($id, 'client_id');
            $data['opponent_id'] = get_mastermeta($id, 'opponent_id');
            $opponent = User::find($data['opponent_id']);
            $data['opponent'] = isset($opponent->name) ? $opponent->name : '';
            $data['court_id'] = get_mastermeta($id, 'court_id');
            $data['subcourt_id'] = get_mastermeta($id, 'subcourt_id');
            $data['case_category_id'] = get_mastermeta($id, 'case_category_id');
            $data['case_subcategory_id'] = get_mastermeta($id, 'case_subcategory_id');
            $data['case_desc'] = get_mastermeta($id, 'case_desc');
            $data['case_doc'] = get_mastermeta($id, 'case_doc');
            $data['case_doc'] = empty($data['case_doc']) ? [] : unserialize($data['case_doc']);
            $data['case_status'] = get_mastermeta($id, 'case_status');
            $data['hearing_date'] = '';
            $hearing = Master::select('id')->where([['master_parent_id', $id], ['master_type', 'hearing']])->orderByDesc('id')->first();

            if(isset($hearing->id)) {
              $data['hearing_date'] = date('d-m-Y', strtotime(get_mastermeta($hearing->id, 'hearing_date')));
            }
            $client_userforms = Formfield::find(5)->userform;
             $data['clients'] = [];
             $data['opponents'] = [];
             foreach ($client_userforms as $client_userform) {
                 $users = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $client_userform->userrole_id]])->get();
              
                 foreach ($users as $user) {
                     $clients = User::select('id', 'name')->where([['id', $user->user_id], ['active', 1]])->get();
                     if(count($clients)) {
                      array_push($data['clients'], $clients->toArray());
                     }
                 }
             }

             $opponent_userforms = Formfield::find(6)->userform;

             foreach ($opponent_userforms as $opponent_userform) {
                 $users = Usermeta::select('user_id')->where([['meta_key', '_userrole_id'], ['meta_value', $opponent_userform->userrole_id]])->get();
                 foreach ($users as $user) {
                     $opponents = User::select('id', 'name')->where([['id', $user->user_id], ['active', 1]])->get();
                     if(count($opponents)) {
                        array_push($data['opponents'], $opponents->toArray());
                     }
                 }
             }

           $data['courts'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'court'], ['active', 1]])->get();
           if($data['subcourt_id'] == 0 || $data['subcourt_id'] == '') {
              $data['subcourts'] = [];
           }else {
            $data['subcourts'] = Master::select('id', 'name')->where([['master_parent_id', $data['court_id']], ['master_type', 'court'], ['active', 1]])->get();
           }
           $data['case_categories'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'case_category'], ['active', 1]])->get();
           if($data['case_subcategory_id'] == 0 || $data['case_subcategory_id'] == '') {
              $data['case_subcategories'] = [];
           }else {
            $data['case_subcategories'] = Master::select('id', 'name')->where([['master_parent_id', $data['case_category_id']], ['master_type', 'case_category'], ['active', 1]])->get();
           }

            $assignees = $data['master']->todoassignees;
            $data['assignees'] = [];

            foreach ($assignees as $assignee) {
                array_push($data['assignees'], $assignee->user_id);
            }

            $data['casefiles'] = [];
            $casefiles = CaseFile::where('case_id', $id)->get();
            foreach ($casefiles as $casefile) {
              array_push($data['casefiles'], $casefile->file_id);
            }
            $data['files'] = Master::select('id', 'name')->where([['master_parent_id', 0], ['master_type', 'file_manager'], ['active', 1]])->get();

            $dir_name = get_mastermeta($id, 'dir_name');
            if(empty($dir_name)) {
              $dir_name = str_replace(' ', '_', strtolower($data['name'])).'_'.date('Ymdhis'); 
              update_mastermeta($id, 'dir_name', $dir_name);
              $folder_name = 'Case Documents';
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


       }elseif($data['master_type'] == 'todo') {
            $data['due_date'] = get_mastermeta($id, 'due_date');
            $data['due_date'] = date('d-m-Y', strtotime($data['due_date']));
            $data['todo_description'] = get_mastermeta($id, 'todo_description');
            $data['is_completed'] = get_mastermeta($id, 'is_completed');
            $data['todo_priority'] = get_mastermeta($id, 'todo_priority');
            $assignees = $data['master']->todoassignees;
            $data['assignees'] = [];

            foreach ($assignees as $assignee) {
                array_push($data['assignees'], $assignee->user_id);
            }
       }elseif($data['master_type'] == 'incident') {
            $data['due_date'] = get_mastermeta($id, 'due_date');
            $data['due_date'] = date('d-m-Y', strtotime($data['due_date']));
            $data['incident_description'] = get_mastermeta($id, 'incident_description');
            $data['is_completed'] = get_mastermeta($id, 'is_completed');
            $data['incident_priority'] = get_mastermeta($id, 'incident_priority');
            $assignees = $data['master']->todoassignees;
            $data['assignees'] = [];

            foreach ($assignees as $assignee) {
                array_push($data['assignees'], $assignee->user_id);
            }
       }

       if($data['master_type'] == 'evaluation') {
          $data['deadline'] = date('d-m-Y', strtotime(get_mastermeta($id, 'deadline')));
          $data['assignee_id'] = get_mastermeta($id, 'assignee_id');
          $assignees = $data['master']->todoassignees;
          $data['objectives'] = $data['master']->objectives;
          $data['assignees'] = [];

          foreach ($assignees as $assignee) {
              array_push($data['assignees'], $assignee->user_id);
          }
        }

       if($data['master_type'] == 'holiday') {
        $data['holiday_date'] = date('d-m-Y', strtotime(get_mastermeta($id, 'holiday_date')));
       }

       if($data['master_type'] == 'file_manager') {
          $data['file_locations'] = Master::select('id', 'name')->where([['master_type', 'file_location'], ['active', 1]])->get();

          $data['file_number'] = get_mastermeta($id, 'file_number');
          $data['case_number'] = get_mastermeta($id, 'case_number');
          $data['file_matter'] = get_mastermeta($id, 'file_matter');
          $data['file_location_id'] = get_mastermeta($id, 'file_location_id');
          $data['last_update_date'] = get_mastermeta($id, 'last_update_date');
          $data['last_update_date'] = date('d-m-Y', strtotime($data['last_update_date']));
          
        }

        if($data['master_type'] == 'judgement') {
          $data['case_number'] = get_mastermeta($id, 'case_number' );
          $data['judgement_description'] = get_mastermeta($id, 'judgement_description' );
        }

        if($data['master_type'] == 'contact') {
          $data['email'] = get_mastermeta($id, 'email');
          $data['additional_email'] = get_mastermeta($id, 'additional_email');
          $data['mobile'] = get_mastermeta($id, 'mobile');
          $data['additional_mobile'] = get_mastermeta($id, 'additional_mobile');
          $data['dob'] = get_mastermeta($id, 'dob');
          $data['dob'] = date('d-m-Y', strtotime($data['dob']));
          $data['anniversary'] = get_mastermeta($id, 'anniversary');
          $data['anniversary'] = date('d-m-Y', strtotime($data['anniversary']));
          $data['comment'] = get_mastermeta($id, 'comment');
        }

        $activity_title = Auth::user()->name.' opened edit '.$masters[trim($data['master_type'])];
        update_masterlogs(Auth::user()->id, $id, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
          return view('master.edit', compact('data'));
        }else {
          return view('non_admin.master.edit', compact('data'));
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
            'holiday_date' => ['required_if:master_type,holiday', 'date_format:d-m-Y'],
            'master_parent_id' => ['integer'],
            'client_id' => ['required_if:master_type,case', 'integer'],
            'opponent' => ['required_if:master_type,case', 'string'],
            'opponent_id' => ['required_if:master_type,case', 'integer'],
            'court_id' => ['required_if:master_type,case', 'integer'], 
            'subcourt_id' => ['integer'],
            'case_category_id' => ['required_if:master_type,case', 'integer'],
            'case_number' => ['required_if:master_type,case,file_manager,judgement', 'string'],
            'file_id' => ['array'],
            'case_subcategory_id' => ['integer'],
            'hearing_date' => ['date_format:d-m-Y'],
            'case_status' => ['required_if:master_type,case', 'in:active,suspended,closed'],
            'case_description' => ['string'],
            'attachment_id' => ['array'],
            'employee_id' => ['required_if:master_type,todo,case,incident', 'array'],
            'due_date' => ['required_if:master_type,todo,incident', 'date_format:d-m-Y'],
            'todo_description' => ['required_if:master_type,todo', 'string'],
            'todo_status' => ['required_if:master_type,todo', 'in:1,0'],
            'todo_priority' => ['required_if:master_type,todo', 'in:high,medium,low'],
            'incident_description' => ['required_if:master_type,incident', 'string'],
            'incident_status' => ['required_if:master_type,incident', 'in:1,0,2,3'],
            'incident_priority' => ['required_if:master_type,incident', 'in:high,medium,low'],
            'assignee_id' => ['required_if:master_type,evaluation', 'integer'],
            'deadline' => ['required_if:master_type,evaluation', 'date_format:d-m-Y'],
            'reviewer_comment' => ['array'],
            'score' => ['array'],
            'file_number' => ['required_if:master_type,file_manager', 'string'],
            'file_matter' => ['required_if:master_type,file_manager', 'string'],
            'file_location_id' => ['required_if:master_type,file_manager', 'integer'],
            'last_update_date' => ['required_if:master_type,file_manager', 'date_format:d-m-Y'],
            'judgement_description' => ['string'],
            'email' => ['required_if:master_type,contact', 'string', 'email', 'max:255'],
            'additional_email' => ['string', 'email', 'max:255'],
            'mobile' => ['required_if:master_type,contact', 'string', 'max:10', 'min:10'],
            'additional_mobile' => ['string', 'max:10', 'min:10'],
            'dob' => ['required_if:master_type,contact', 'date_format:d-m-Y'],
            'anniversary' => ['required_if:master_type,contact', 'date_format:d-m-Y'],
            'comment' => ['string'],
        ])->validate();

        $masters = get_master_slugs();

        $master = Master::find($id);
        $master->name = trim($data['name']);
        $master->master_parent_id = isset($data['master_parent_id']) ? $data['master_parent_id'] : 0;
        $is_saved = $master->save();

        if($is_saved) {
            if($master->master_type == 'case') {
            	update_mastermeta($id, 'case_number', $data['case_number']);
                update_mastermeta($id, 'client_id', $data['client_id']);

                $opponent = User::find($data['opponent_id']);
                $opponent->name = $data['opponent'];
                $opponent->save();

                update_mastermeta($id, 'court_id', $data['court_id']);
                update_mastermeta($id, 'subcourt_id', isset($data['subcourt_id']) ? $data['subcourt_id'] : 0);
                update_mastermeta($id, 'case_category_id', $data['case_category_id']);
                update_mastermeta($id, 'case_subcategory_id', isset($data['case_subcategory_id']) ? $data['case_subcategory_id'] : 0);
                update_mastermeta($id, 'case_desc', isset($data['case_description']) ? $data['case_description'] : '');
                update_mastermeta($id, 'case_doc', isset($data['attachment_id']) ? $data['attachment_id'] : []);
                update_mastermeta($id, 'case_status', isset($data['case_status']) ? $data['case_status'] : 'active');
                if(isset($data['hearing_date'])) {
                  update_case_hearings(Auth::user()->id, $master->id, $data['hearing_date']);
                }

                $deletedRows = Todoassignees::where('master_id', $id)->delete();
                foreach ($data['employee_id'] as $employee_id) {
                    $todoassignees = new Todoassignees;
                    $todoassignees->master_id = $id;
                    $todoassignees->user_id = $employee_id;
                    $todoassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' updated your assigned case.', 'body' => $data['name'], 'link' => url("/master/".$master->id.'/edit')]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }

              CaseFile::where('case_id', $id)->delete();
              if(isset($data['file_id']) && count($data['file_id'])) {
                foreach ($data['file_id'] as $file_id) {
                  $casefile = new CaseFile;

                  $casefile->case_id = $master->id;
                  $casefile->file_id = $file_id;

                  $casefile->save();

                }
              }
            }
            if($master->master_type == 'todo') {
                $deletedRows = Todoassignees::where('master_id', $id)->delete();
                foreach ($data['employee_id'] as $employee_id) {
                    $todoassignees = new Todoassignees;
                    $todoassignees->master_id = $id;
                    $todoassignees->user_id = $employee_id;
                    $todoassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' updated your assigned todo.', 'body' => $data['name'], 'link' => url("/my_todo/".$master->id)]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }

                update_mastermeta($id, 'todo_description', $data['todo_description']);
                update_mastermeta($id, 'due_date', date('Y-m-d', strtotime($data['due_date'])));
                update_mastermeta($id, 'is_completed', $data['todo_status']);
                if($data['todo_status'] == 1) {
                  update_mastermeta($id, 'closed_on', date('Y-m-d H:i:s'));
                  update_mastermeta($id, 'closed_by', Auth::user()->id);
                }
                update_mastermeta($id, 'todo_priority', $data['todo_priority']);
            }

            if($master->master_type == 'incident') {
                $deletedRows = Todoassignees::where('master_id', $id)->delete();
                foreach ($data['employee_id'] as $employee_id) {
                    $incidentassignees = new Todoassignees;
                    $incidentassignees->master_id = $id;
                    $incidentassignees->user_id = $employee_id;
                    $incidentassignees->save();

                    if($employee_id != Auth::user()->id) {
                      $user = User::find($employee_id);
                      $letter = collect(['title' => Auth::user()->name.' updated your assigned incident.', 'body' => $data['name'], 'link' => url("/my_incident/".$master->id)]);
                      Notification::send($user, new TodoCreated($letter));
                    }
                }

                update_mastermeta($id, 'incident_description', $data['incident_description']);
                update_mastermeta($id, 'due_date', date('Y-m-d', strtotime($data['due_date'])));
                update_mastermeta($id, 'is_completed', $data['incident_status']);
                if($data['incident_status'] == 1) {
                  update_mastermeta($id, 'closed_on', date('Y-m-d H:i:s'));
                  update_mastermeta($id, 'closed_by', Auth::user()->id);
                }
                update_mastermeta($id, 'incident_priority', $data['incident_priority']);
            }

            if($master->master_type == 'evaluation') {
              update_mastermeta($id, 'deadline', date('Y-m-d', strtotime($data['deadline'])));
              update_mastermeta($id, 'assignee_id', $data['assignee_id']);
              $letter = collect(['title' => Auth::user()->name.' updated your assigned assessment.', 'body' => $data['name'], 'link' => url("/evaluation/".$master->id)]);
              $user = User::find($data['assignee_id']);
              Notification::send($user, new TodoCreated($letter));

              $deletedRows = Todoassignees::where('master_id', $id)->delete();
              foreach ($data['employee_id'] as $employee_id) {
                  $incidentassignees = new Todoassignees;
                  $incidentassignees->master_id = $master->id;
                  $incidentassignees->user_id = $employee_id;

                  $incidentassignees->save();

                  if($employee_id != Auth::user()->id) {
                    $user = User::find($employee_id);
                    $letter = collect(['title' => Auth::user()->name.' updated your to be reviewed assessment.', 'body' => $data['name'], 'link' => url("/evaluation/".$master->id)]);
                    Notification::send($user, new TodoCreated($letter));
                  }
              }
              if(isset($data['reviewer_comment']) && count($data['reviewer_comment'])) {
                foreach ($data['reviewer_comment'] as $key => $reviewer_comment) {
                  $objective = Objective::find($key);
                  $objective->reviewer_comment = isset($data['reviewer_comment'][$key]) ? $data['reviewer_comment'][$key] : '';
                  $objective->score = isset($data['score'][$key]) ? $data['score'][$key] : '';
                  $objective->save();
                }
              }

            }

            if($master->master_type == 'holiday') {
              update_mastermeta($id, 'holiday_date', date('Y-m-d', strtotime($data['holiday_date'])));
            }

            if($master->master_type == 'file_manager') {
              update_mastermeta($id, 'file_number', $data['file_number']);
              update_mastermeta($id, 'case_number', $data['case_number']);
              update_mastermeta($id, 'file_matter', $data['file_matter']);
              update_mastermeta($id, 'file_location_id', $data['file_location_id']);
              update_mastermeta($id, 'last_update_date', date('Y-m-d', strtotime($data['last_update_date'])));
            }

            if($master->master_type == 'judgement') {
              update_mastermeta($id, 'case_number', $data['case_number']);
              update_mastermeta($id, 'judgement_description', $data['judgement_description']);
            }

            if($master->master_type == 'contact') {
              update_mastermeta($id, 'email', $data['email']);
              update_mastermeta($id, 'additional_email', $data['additional_email']);
              update_mastermeta($id, 'mobile', $data['mobile']);
              update_mastermeta($id, 'additional_mobile', $data['additional_mobile']);
              update_mastermeta($id, 'dob', date('Y-m-d', strtotime($data['dob'])));
              update_mastermeta($id, 'anniversary', date('Y-m-d', strtotime($data['anniversary'])));
              update_mastermeta($id, 'comment', $data['comment']);
            }

            $activity_title = Auth::user()->name.' updated '.$masters[$master->master_type].' "'.trim($data['name']).'"';
            update_masterlogs(Auth::user()->id, $id, $activity_title);

            session()->flash("masterSuccessMsg", $masters[$master->master_type]." has been updated successfully");
        }else {
            session()->flash("masterErrorMsg", $masters[$master->master_type]." can not be updated.Please try again.");
        }

        return redirect('master/'.$id.'/edit');
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
        $masters = get_master_slugs();
        if($is_saved) {
            $activity_title = Auth::user()->name.' deleted '.$masters[$master->master_type].' "'.$master->name.'"';
            update_masterlogs(Auth::user()->id, $id, $activity_title);
            session()->flash("masterDelSuccessMsg", $masters[$master->master_type]." has been deleted successfully");  
        }else {
            session()->flash("masterDelErrorMsg", $masters[$master->master_type]." can not be deleted.Please try again.");
        }

        return redirect('master?master_type='.$master->master_type);
    }

    public function editor_upload(Request $request) {

        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $dir = 'public/'.date('Y')."/".date('m');
            Storage::makeDirectory($dir);
            $file = Storage::putFile($dir, $request->file('upload'));
            $file = ltrim($file, 'public/');
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/'.$file); 
            $msg = 'File uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }

    }

    public function upload_files(Request $request) {
        $data = array();
        $upload_file = $request->file('files');
        if (count($upload_file)) {
            $upload_file = reset($upload_file);
            $dir = 'public/'.date('Y')."/".date('m');
            Storage::makeDirectory($dir);
            $file = Storage::putFile($dir, $upload_file);
            if(!empty($file)) {
                $file = ltrim($file, 'public/');
                $master = new Master;
                $master->name = $upload_file->getClientOriginalName();
                $master->master_type = 'attachment';
                $master->create_by = Auth::user()->id;
                $master->save();

                update_mastermeta($master->id, '_attachment_url', $file);
                update_mastermeta($master->id, '_attachment_mime', $upload_file->getClientMimeType());
                update_mastermeta($master->id, '_attachment_size', $upload_file->getSize());

                $activity_title = Auth::user()->name.' uploaded a file "'.$upload_file->getClientOriginalName().'"';
                update_masterlogs(Auth::user()->id, $master->id, $activity_title);

                $data['success'] = true;
                $data['attachment_id'] = $master->id;
            }else {
                $data['success'] = false;
            }
        }else {
            $data['success'] = false;
        }

        echo json_encode($data);
    }

    public function user_todo_list() {
        $todos = [];
        $todoassignees = Todoassignees::select('master_id')->where('user_id', Auth::user()->id)->orderBy("master_id", "desc")->get();
        if(count($todoassignees)) {
            foreach ($todoassignees as $todoassignee) {
                $todo = Master::where([['id', $todoassignee->master_id], ['active', 1], ['master_type', 'todo']])->first();
                if($todo) {
                  array_push($todos, $todo);
                }
            }
        }

        $activity_title = Auth::user()->name.' opened todo list';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
          return view('todo.list', compact('todos'));
        }else {
          return view('non_admin.todo.list', compact('todos'));
        }
    }

    public function user_todo($id) {
        $data['todo'] = Master::find($id);
        $data['todoassignees'] = $data['todo']->todoassignees;
        $data['comments'] = Master::select('id', 'create_by', 'created_at')->where([['master_parent_id', $id], ['master_type', 'todo_comment'], ['active', 1]])->get();
        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');

        $activity_title = Auth::user()->name.' opened '.$data['todo']->name;
        update_masterlogs(Auth::user()->id, $id, $activity_title);

        if($user_role == 10) { 
          return view('todo.index', compact('data'));
        }else {
          return view('non_admin.todo.index', compact('data'));
        }
    }

    public function make_todo_comment(Request $request, $id) {
      $data = Validator::make($request->all(), [
          'todo_comment' => ['required', 'string']
      ])->validate();

      $master = new Master;
      $master->name = 'Todo Comment';
      $master->master_parent_id = $id;
      $master->master_type = 'todo_comment';
      $master->create_by = Auth::user()->id;
      $is_saved = $master->save();      

      if($is_saved) {
        update_mastermeta($master->id, '_comment', $data['todo_comment']);

        $todo = Master::find($id);
        $todoassignees = $todo->todoassignees;
        foreach ($todoassignees as $todoassignee) {
          if($todoassignee->user_id != Auth::user()->id) {
            $user = User::find($todoassignee->user_id);
              $letter = collect(['title' => Auth::user()->name.' commented on your assigned todo.', 'body' => $todo->name, 'link' => url("/my_todo/".$todo->id)]);
              Notification::send($user, new TodoCreated($letter));
          }
        }
        $activity_title = Auth::user()->name.' commented on a todo "'.$todo->name.'"';
        update_masterlogs(Auth::user()->id, $id, $activity_title);

        session()->flash("todoSuccessMsg", "Your comment has been added successfully");
      }else {
        session()->flash("todoErrorMsg", "Some error occurs.Please try again.");
      }

      return redirect('my_todo/'.$id);
    }

    public function get_masterchilds($id) {
      $master_type = trim($_GET['master_type']);
      $children = Master::select('id', 'name')->where([['master_parent_id', $id], ['active', 1], ['master_type', $master_type]])->get();
      echo json_encode($children);
    }

    public function change_todo_status($id) {
      $status = get_mastermeta($id, 'is_completed');
      $status = !$status;
      update_mastermeta($id, 'is_completed', $status);
      if($status == 1) {
        update_mastermeta($id, 'closed_on', date('Y-m-d H:i:s'));
        update_mastermeta($id, 'closed_by', Auth::user()->id);
      }

      $todo = Master::find($id);
      $status_title = $status == 1 ? 'Closed' : 'Open';
      $activity_title = Auth::user()->name.' changed status to '.$status_title.' of a todo "'.$todo->name.'"';
      update_masterlogs(Auth::user()->id, $master->id, $activity_title);

      session()->flash("todoSuccessMsg", "Todo has been updated successfully");
      return redirect('my_todo_list');

    }
    public function delete_todo_comment($id)
    {
        $master = Master::find($id);
        $master->active = 0;
        $is_saved = $master->save();
        if($is_saved) {
            $activity_title = Auth::user()->name.' deleted comment of a todo "'.$master->name.'"';
            update_masterlogs(Auth::user()->id, $master->id, $activity_title);
            session()->flash("todoSuccessMsg", "Your comment has been deleted successfully");  
        }else {
            session()->flash("todoErrorMsg", "Your comment can not be deleted.Please try again.");
        }

        return redirect('my_todo/'.$master->master_parent_id);
    }
    public function update_todo_comment(Request $request, $id)
    {
        $master = Master::find($id);
        $data = Validator::make($request->all(), [
            'todo_old_comment' => ['required', 'string']
        ])->validate();
        update_mastermeta($id, '_comment', $data['todo_old_comment']);
        $activity_title = Auth::user()->name.' updated comment of a todo "'.$master->name.'"';
        update_masterlogs(Auth::user()->id, $master->id, $activity_title);
        session()->flash("todoSuccessMsg", "Your comment has been updated successfully");  

        return redirect('my_todo/'.$master->master_parent_id);
    }

    public function user_incident_list() {
        $incidents = [];
        $incidentassignees = Todoassignees::select('master_id')->where('user_id', Auth::user()->id)->orderBy("master_id", "desc")->get();
        if(count($incidentassignees)) {
            foreach ($incidentassignees as $incidentassignee) {
                $incident = Master::where([['id', $incidentassignee->master_id], ['active', 1], ['master_type', 'incident']])->first();
                if($incident) {
                  array_push($incidents, $incident);
                }
            }
        }

        $activity_title = Auth::user()->name.' opened incident list';
        update_masterlogs(Auth::user()->id, 0, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
          return view('incident.list', compact('incidents'));
        }else {
          return view('non_admin.incident.list', compact('incidents'));
        }
    }

    public function user_incident($id) {
        $data['incident'] = Master::find($id);
        $data['incidentassignees'] = $data['incident']->todoassignees;
        $data['comments'] = Master::select('id', 'create_by', 'created_at')->where([['master_parent_id', $id], ['master_type', 'incident_comment'], ['active', 1]])->get();

        $activity_title = Auth::user()->name.' opened '.$data['incident']->name;
        update_masterlogs(Auth::user()->id, $id, $activity_title);

        $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
        if($user_role == 10) { 
          return view('incident.index', compact('data'));
        }else {
          return view('non_admin.incident.index', compact('data'));
        }
    }

    public function make_incident_comment(Request $request, $id) {
      $data = Validator::make($request->all(), [
          'incident_comment' => ['required', 'string']
      ])->validate();

      $master = new Master;
      $master->name = 'Incident Comment';
      $master->master_parent_id = $id;
      $master->master_type = 'incident_comment';
      $master->create_by = Auth::user()->id;
      $is_saved = $master->save();      

      if($is_saved) {
        update_mastermeta($master->id, '_comment', $data['incident_comment']);

        $incident = Master::find($id);
        $incidentassignees = $incident->todoassignees;
        foreach ($incidentassignees as $incidentassignee) {
          if($incidentassignee->user_id != Auth::user()->id) {
            $user = User::find($incidentassignee->user_id);
              $letter = collect(['title' => Auth::user()->name.' commented on your assigned incident.', 'body' => $incident->name, 'link' => url("/my_incident/".$incident->id)]);
              Notification::send($user, new TodoCreated($letter));
          }
        }
        $activity_title = Auth::user()->name.' commented on a incident "'.$incident->name.'"';
        update_masterlogs(Auth::user()->id, $id, $activity_title);

        session()->flash("incidentSuccessMsg", "Your comment has been added successfully");
      }else {
        session()->flash("incidentErrorMsg", "Some error occurs.Please try again.");
      }

      return redirect('my_incident/'.$id);
    }

    public function change_incident_status($id) {
      $status = get_mastermeta($id, 'is_completed');
      $status = !$status;
      update_mastermeta($id, 'is_completed', $status);
      if($status == 1) {
        update_mastermeta($id, 'closed_on', date('Y-m-d H:i:s'));
        update_mastermeta($id, 'closed_by', Auth::user()->id);
      }

      $incident = Master::find($id);
      $status_title = $status == 1 ? 'Closed' : 'Open';
      $activity_title = Auth::user()->name.' changed status to '.$status_title.' of a incident "'.$incident->name.'"';
      update_masterlogs(Auth::user()->id, $master->id, $activity_title);

      session()->flash("incidentSuccessMsg", "incident has been updated successfully");
      return redirect('my_incident_list');

    }
    public function delete_incident_comment($id)
    {
        $master = Master::find($id);
        $master->active = 0;
        $is_saved = $master->save();
        if($is_saved) {
            $activity_title = Auth::user()->name.' deleted comment of a incident "'.$master->name.'"';
            update_masterlogs(Auth::user()->id, $master->id, $activity_title);
            session()->flash("incidentSuccessMsg", "Your comment has been deleted successfully");  
        }else {
            session()->flash("incidentErrorMsg", "Your comment can not be deleted.Please try again.");
        }

        return redirect('my_incident/'.$master->master_parent_id);
    }
    public function update_incident_comment(Request $request, $id)
    {
        $master = Master::find($id);
        $data = Validator::make($request->all(), [
            'incident_old_comment' => ['required', 'string']
        ])->validate();
        update_mastermeta($id, '_comment', $data['incident_old_comment']);
        $activity_title = Auth::user()->name.' updated comment of a incident "'.$master->name.'"';
        update_masterlogs(Auth::user()->id, $master->id, $activity_title);
        session()->flash("incidentSuccessMsg", "Your comment has been updated successfully");  

        return redirect('my_incident/'.$master->master_parent_id);
    }
    public function upload_drive_files(Request $request) {
      $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'folder_name' => ['required', 'string', 'max:255'],
            'master_id' => ['required', 'integer'],
        ])->validate();
      if($data['folder_name'] == 'User Documents') {
        $dir_name = get_usermeta($data['master_id'], 'dir_name');

        if($dir_name == null) {
          $user = User::find($data['master_id']);

          $dir_name = $user->email;
          if($dir_name == '' || $dir_name == null) {
            $data['success'] = false;
            $data['message'] = 'Please set a name first';
            echo json_encode($data);
            exit;
          }
          if($data['master_id'] > 0) {
            $dir_name_arr = explode('@', $dir_name);
            $dir_name = $dir_name_arr[0].'_'.date('Ymdhis');
            update_usermeta($data['master_id'], 'dir_name', $dir_name);
          } 
        }
      }else {
        $dir_name = get_mastermeta($data['master_id'], 'dir_name');

        if($dir_name == null) {
          $dir_name = str_replace(' ', '_', strtolower($data['name'])).'_'.date('Ymdhis');
          if($data['master_id'] > 0) {
            update_mastermeta($data['master_id'], 'dir_name', $dir_name);
          } 
        }
      }

      $parent_dir = '/';
      $recursive = false; // Get subdirectories also?
      $contents = collect(Storage::disk('google')->listContents($parent_dir, $recursive));

      $dir = $contents->where('type', '=', 'dir')
          ->where('filename', '=', $data['folder_name'])
          ->first(); // There could be duplicate directory names!

      $sub_contents = collect(Storage::disk('google')->listContents($dir['path'], $recursive));

      $sub_dir = $sub_contents->where('type', '=', 'dir')
          ->where('filename', '=', $dir_name)
          ->first(); // There could be duplicate directory names!

      if ( ! $sub_dir) {
          Storage::disk('google')->makeDirectory($dir['path'].'/'.$dir_name);
          $sub_contents = collect(Storage::disk('google')->listContents($dir['path'], $recursive));
          $sub_dir = $sub_contents->where('type', '=', 'dir')
          ->where('filename', '=', $dir_name)
          ->first(); // There could be duplicate directory names!
      }
      $upload_file = $request->file('file');
        
      if (count($upload_file)) {
          $upload_file = reset($upload_file);
          $file = Storage::disk('google')->put($dir['path'].'/'.$sub_dir['path'].'/'.$upload_file->getClientOriginalName(), fopen($upload_file, 'r+'));

      }

      if($data['folder_name'] == 'Case Documents') {
        $master = Master::find($data['master_id']);

        $masterassignees = $master->todoassignees;
        foreach ($masterassignees as $masterassignee) {
          if($masterassignee->user_id != Auth::user()->id) {
            $user = User::find($masterassignee->user_id);
              $letter = collect(['title' => Auth::user()->name.' uploaded a file in your assigned case.', 'body' => $master->name, 'link' => url("/master/".$master->id.'/edit')]);
              Notification::send($user, new TodoCreated($letter));
          }
        }
        $activity_title = Auth::user()->name.' uploaded a file to a case "'.$master->name.'"';
        update_masterlogs(Auth::user()->id, $master->id, $activity_title);
      }

      $data['success'] = true;
      $data['dir_name'] = $dir_name;
      echo json_encode($data);
   
    }

    public function delete_drive_file(Request $request) {
      $data = Validator::make($request->all(), [
          'folder' => ['required', 'string'],
          'folder_name' => ['required', 'string'],
          'filename' => ['required', 'string'],
          'master_id' => ['required', 'integer'],
      ])->validate();

      $filename = $data['filename'];
      $folder = $data['folder'];

      $parent_dir = '/';
      $recursive = false; // Get subdirectories also?
      $contents = collect(Storage::disk('google')->listContents($parent_dir, $recursive));

      $dir = $contents->where('type', '=', 'dir')
          ->where('filename', '=', $data['folder_name'])
          ->first(); // There could be duplicate directory names!

      $sub_contents = collect(Storage::disk('google')->listContents($dir['path'], $recursive));

      $sub_dir = $sub_contents->where('type', '=', 'dir')
          ->where('filename', '=', $folder)
          ->first(); // There could be duplicate directory names!
      
      if (  $sub_dir) {
        // Get the files inside the folder...
        $contents = collect(Storage::disk('google')->listContents($sub_dir['path'], false));
        $file = $contents
          ->where('type', '=', 'file')
          ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
          ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
          ->first(); // there can be duplicate file names!

        Storage::disk('google')->delete($file['path']);
        if($data['folder_name'] == 'Case Documents') {
          $master = Master::find($data['master_id']);
          $activity_title = Auth::user()->name.' deleted a file of a case "'.$master->name.'"';
          update_masterlogs(Auth::user()->id, $master->id, $activity_title);
        }
        
      }

      $data['success'] = true;
      echo json_encode($data);
    } 

    public function get_drive_files(Request $request, $id) {
      $data = Validator::make($request->all(), [
          'folder_name' => ['required', 'string', 'max:255'],
      ])->validate();
      if($data['folder_name'] == 'User Documents') {
        $folder = get_usermeta($id, 'dir_name');
      }else {
        $folder = get_mastermeta($id, 'dir_name');
      }

      $data['files'] = [];
      if($folder != null) {
        $parent_dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($parent_dir, $recursive));

        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $data['folder_name'])
            ->first(); // There could be duplicate directory names!

        $sub_contents = collect(Storage::disk('google')->listContents($dir['path'], $recursive));

        $sub_dir = $sub_contents->where('type', '=', 'dir')
            ->where('filename', '=', $folder)
            ->first(); // There could be duplicate directory names!
      
        if (  $sub_dir) {
          $data['main_dir'] = Storage::disk('google')->url($sub_dir['path']);
          // Get the files inside the folder...
          $files = collect(Storage::disk('google')->listContents($sub_dir['path'], false))
              ->where('type', '=', 'file');
          $data['files'] = $files->mapWithKeys(function($file) {
              $filename = $file['filename'].'.'.$file['extension'];
              $path = $file['path'];
              $url = Storage::disk('google')->url($path);
              return [$filename => $url];
            });
          
        }
      
      }
      echo json_encode($data);

    }

    public function show_evaluation($id) {
      $data['evaluation'] = Master::find($id);
      $data['evaluation_weight'] = get_mastermeta($id, 'evaluation_weight');
      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      $data['objectives'] = $data['evaluation']->objectives;

      $activity_title = Auth::user()->name.' opened '.$data['evaluation']->name;
      update_masterlogs(Auth::user()->id, $id, $activity_title);

      if($user_role == 10) { 
        return view('evaluation.index', compact('data'));
      }else {
        return view('non_admin.evaluation.index', compact('data'));
      }
    }

    public function update_evaluation_review(Request $request, $id) {
      $data = Validator::make($request->all(), [
          'employee_comment' => ['array'],
      ])->validate();
      
      foreach ($data['employee_comment'] as $key => $employee_comment) {
        $objective = Objective::find($key);
        $objective->employee_comment = $data['employee_comment'][$key];
        $objective->save();
      }

      $assignee_id = get_mastermeta($id, 'assignee_id');
      $evaluation = Master::find($id);

      $user = User::find($assignee_id);
      $letter = collect(['title' => Auth::user()->name.' commented on '.$evaluation->name, 'body' => $evaluation->name, 'link' => url("/evaluation/".$evaluation->id)]);
      Notification::send($user, new TodoCreated($letter));

      $activity_title = Auth::user()->name.' commented on "'.$evaluation->name.'"';
      update_masterlogs(Auth::user()->id, $evaluation->id, $activity_title);

      session()->flash("evaluationSuccessMsg", "Your comments has been updated successfully");

      return redirect('evaluation/'.$id);

    }

    public function user_evaluation() {
      $data = [];
      $data['evaluations'] = [];
      $my_evaluations = DB::table('mastermetas')->select('master_id')->where([['meta_key', 'assignee_id'], ['meta_value', Auth::user()->id]])->get();
      if (count($my_evaluations)) {
        foreach ($my_evaluations as $my_evaluation) {
          $evaluation = Master::where([['id', $my_evaluation->master_id], ['master_type', 'evaluation'], ['active', 1]])->first();
          if($evaluation) {
            array_push($data['evaluations'], $evaluation);
          }
        }
      }

      $activity_title = Auth::user()->name.' opened evaluation';
      update_masterlogs(Auth::user()->id, 0, $activity_title);

      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      if($user_role == 10) {
        return view('evaluation.list', compact('data'));
      }else {
        return view('non_admin.evaluation.list', compact('data'));
      }
    }

    public function bulk_delete(Request $request) {
      $data = Validator::make($request->all(), [
          'master_ids' => ['required', 'array'],
      ])->validate();
      if(count($data['master_ids'])) {
        foreach ($data['master_ids'] as $master_id) {
          $master = Master::find($master_id);
          $master->active = 0;
          $is_saved = $master->save();
          $masters = get_master_slugs();
          if($is_saved) {
              $activity_title = Auth::user()->name.' deleted '.$masters[$master->master_type].' "'.$master->name.'"';
              update_masterlogs(Auth::user()->id, $master_id, $activity_title);
          }
        }
      }
      $resp_data = [];
      $resp_data['success'] = true;

      echo json_encode($resp_data);
    }

    public function upload_excel_index() {
      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      
      $data['master_type'] = ($_GET['master_type']) ?? 'file_manager';

      $activity_title = Auth::user()->name.' opened upload excel in file manager';
      update_masterlogs(Auth::user()->id, 0, $activity_title);

      if($user_role == 10) { 
        return view('upload_excel.index', compact('data'));
      }else {
        return view('non_admin.upload_excel.index', compact('data'));
      }
    }

    public function upload_excel(Request $request) {
      $master_type = ($_GET['master_type']) ?? 'file_manager';
      $excel_data = $request->all();
      $response = [];
      $columnMap = $excel_data['column_map'];
      if(empty($excel_data['data']) && empty($columnMap)) {
          $response['error'] = 'Invalid Action';

          echo json_encode($response);
          die();
      }

      if($master_type == 'file_manager') {
        foreach ($excel_data['data'] as $key => $data) {
          
          $location = Master::select('id')->where([['master_type', 'file_location'], ['name', $data[$columnMap['location']]]])->first();

          if($location) {
            $master = new Master;
            $master->name = $data[$columnMap['name']];
            $master->master_type = $master_type;
            $master->create_by = Auth::user()->id;
            $master->save();

            update_mastermeta($master->id, 'file_number', $data[$columnMap['file_number']]);
            update_mastermeta($master->id, 'case_number', $data[$columnMap['case_number']]);
            update_mastermeta($master->id, 'file_matter', $data[$columnMap['matter']]);
            update_mastermeta($master->id, 'file_location_id', $location->id);
            update_mastermeta($master->id, 'last_update_date', date('Y-m-d', strtotime($data[$columnMap['last_update']])));

          } 
        }
      }

      $response['data'] = 'Inserted Successfully';

      echo json_encode($response);

    }


    public function send_email($id) {
      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      
      $data['master'] = Master::find($id);
      $activity_title = Auth::user()->name.' opened '.$data['master']->name.' in contacts send email';
      update_masterlogs(Auth::user()->id, $id, $activity_title);
      if(isset($data['master']->master_type) && $data['master']->master_type == 'contact') {
        $email = get_mastermeta($id, 'email');
        if(!empty($email)) {
          if($user_role == 10) { 
            return view('master.email', compact('data'));
          }else {
            return view('non_admin.master.email', compact('data'));
          }
        }else {
          session()->flash("masterErrorMsg", "Email is invalid");
          return redirect('master?master_type='.$data['master']->master_type);
        }
      }else {
        return redirect('/')->with('permissionError', 'URL is invalid.');
      }
    }

    public function post_email(Request $request, $id) {
      Validator::make($request->all(), [
          'subject' => ['required', 'string'],
          'message' => ['required', 'string'],
      ])->validate();
      $data = $request->all();
      $data['cc_arr'] = [];
      $data['bcc_arr'] = [];
      if(!empty($data['cc'])) {
        $data['cc_arr'] = explode(',', $data['cc']);
      }
      if(!empty($data['bcc'])) {
        $data['bcc_arr'] = explode(',', $data['bcc']);
      }

      $file_arr = [];
      $data['attach_arr'] = [];

      if($request->hasFile('attachment')) {
          $dir = 'public/'.date('Y')."/".date('m');
          Storage::makeDirectory($dir);
          $files = $request->file('attachment');
        
          foreach ($request->file('attachment') as $attachment) {
            $file = Storage::putFile($dir, $attachment);

            array_push($file_arr, ltrim($file, 'public/'));
            array_push($data['attach_arr'], 
                [
                    'path' => $attachment->getRealPath(),
                    'as' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType(),
                ] );
          }
      }  
      $contact = Master::find($id);
      if(isset($contact->master_type) && $contact->master_type == 'contact') {
        $email = get_mastermeta($id, 'email');
        if(!empty($email)) {
          $from_email = empty(get_option('site_email')) ? 'admin@admin.com' : get_option('site_email');
          $from_name = empty(get_option('site_name')) ? 'Alphaxine Admin' : get_option('site_name');
          Mail::to($email)->from($from_email, $from_name)->send(new SendMail($data));

          $master = new Master;
          $master->name = $data['subject'];
          $master->master_type = 'email';
          $master->master_parent_id = $id;
          $master->create_by = Auth::user()->id;
          $master->save();

          update_mastermeta($master->id, 'message', $data['message']);

          if(count($file_arr)) {
            foreach ($file_arr as $file) {
              $attach = new Master;
              $attach->name = 'Email Attachment';
              $attach->master_type = 'attachment';
              $attach->master_parent_id = $master->id;
              $attach->create_by = Auth::user()->id;
              $attach->save();

              update_mastermeta($attach->id, 'attachment_path', $file);
            }
          }

          $activity_title = Auth::user()->name.' send an email to '.$contact->name;
          update_masterlogs(Auth::user()->id, $id, $activity_title);

          session()->flash("emailSuccessMsg", "Email has been sent successfully");
          return redirect('send_email/'.$id);
        }else {
          session()->flash("masterErrorMsg", "Email is invalid");
          return redirect('master?master_type='.$contact->master_type);
        }
      }else {
        return redirect('/')->with('permissionError', 'URL is invalid.');
      }

    }

    public function send_sms($id) {
      $user_role = get_usermeta(Auth::user()->id, '_userrole_id');
      
      $data['master'] = Master::find($id);
      $activity_title = Auth::user()->name.' opened '.$data['master']->name.' in contacts send sms';
      update_masterlogs(Auth::user()->id, $id, $activity_title);
      if($data['master']->master_type == 'contact') {
        if($user_role == 10) { 
          return view('master.sms', compact('data'));
        }else {
          return view('non_admin.master.sms', compact('data'));
        }
      }else {
        return redirect('/')->with('permissionError', 'URL is invalid.');
      }     
    }

    public function post_sms(Request $request, $id) {
      
    }
}
