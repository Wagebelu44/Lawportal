@extends('layouts.master')
<?php $masters = get_master_slugs();?>
@if(isset($masters[$data['master_type']]))
@section('title', $masters[$data['master_type']])
@section('content')

<?php $is_show = true;?>
@if($data['master_type'] == 'revision' && empty($data['activity_date_range']))
<?php $is_show = false;?>
@endif

@if(!check_permission(Auth::user()->id, 'upload.excel.index', $data['master_type']))
<style type="text/css">
	#file_managerdataTable_wrapper .dt-buttons .dt-button:nth-child(2) {
		display: none
	}
</style>
@endif

<section class="page-content">
	<div class="wrapper">
		<div class="page-header">
			<h1>{{$masters[$data['master_type']]}}
			@if($data['master_type'] !== 'revision')
			@if(check_permission(Auth::user()->id, 'master.create', $data['master_type']))
			<a href="{{ url('/master/create?master_type='.$data['master_type']) }}" class="btn btn-default">Add New {{$masters[$data['master_type']]}}</a>
			@endif
			@endif
			</h1>
		</div>
		@if(session()->has('masterDelSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('masterDelSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('masterDelErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('masterDelErrorMsg') }}</p>
		</div>
		@endif
		@if($data['master_type'] == 'revision')
	    <div class="row">
	      <div class="col-sm-12">
	        <div class="panel panel-primary">
	            <div class="panel-heading">Search Attendence</div>
	            <div class="panel-body">
	              <form class="form-inline" action="{{url()->current()}}">
	              	<input type="hidden" name="master_type" value="{{$data['master_type']}}">
	                <div class="form-group">
	                  <label for="email">Select Date</label>
	                  <input type="text" name="activity_date_range" class="date_range" value="{{!empty($data['activity_date_range']) ? $data['activity_date_range'] : ''}}"/>
	                </div>
	                <div class="form-group">
	                  <label for="pwd">Select Employee</label>
	                  <select class="form-control lawselect" name="user_id">
	                    <option value="">Select employee</option>
	                    @forelse($data['employees'] as $employee)
	                    @if($employee->id != 29)
	                    <option value="{{$employee->id}}" <?php if(isset($data['user_id']) && ($data['user_id'] == $employee->id)) { echo 'selected';} ?>>{{$employee->name}}</option>
	                    @endif
	                    @empty
	                    @endforelse
	                  </select>
	                </div>
	                <button type="submit" class="btn btn-default">Submit</button>
	              </form>
	              
	            </div>
	          </div>
	      </div>
	    </div>
	    @endif
	    @if($is_show)
		<div class="item-wrap item-list-table">
			<table id="<?php if(in_array($data['master_type'], array('revision', 'user_attendence', 'file_manager', 'holiday', 'case'))) { echo $data['master_type'];} ?>dataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
					<tr>
						@if(!in_array($data['master_type'], array('revision', 'user_attendence')))
						@if(check_permission(Auth::user()->id, 'master.destroy', $data['master_type']))
						<th><input type="checkbox" id="all_check_action"></th>
						@endif
						@endif
						@if($data['master_type'] == 'case')
						<th>Client & Case Detail</th>
						@else
						<th>{{ $data['master_type'] == 'revision' ? 'Activity' : 'Name' }} </th>
						@endif
						@if($data['master_type'] == 'evaluation')
						<th>Assignee</th>
						<th>Deadline</th>
						@endif
						<?php $has_sub_master_arr = array('court', 'state', 'case_category'); ?>
						@if( in_array($data['master_type'], $has_sub_master_arr) )
						<th>Parent Name</th>
						@endif
						@if($data['master_type'] == 'revision')
						<th>Entity</th>
						@endif
						@if($data['master_type'] == 'case')
						<th>Court Detail</th>
						<th>Client vs Opponent</th>
						<th>Next Date</th>
						<th>Status</th>
						@elseif($data['master_type'] == 'todo' || $data['master_type'] == 'incident')
						<th>Assigned To</th>
						<th>Priority</th>
						<th>Due Date</th>
						<th>Status</th>
						@elseif($data['master_type'] == 'holiday')
						<th>Holiday Date</th>
						@elseif($data['master_type'] == 'file_manager')
						<th>File Number</th>
						<th>Case Number</th>
						<th>Location</th>
						@elseif($data['master_type'] == 'judgement')
						<th>Case Number</th>
						@endif
						<th>Created On</th>
						<th>Created By</th>
						@if($data['master_type'] !== 'revision')
						<th>Action</th>
						@endif
					</tr>
				</thead>
				<tbody>

					@foreach($data['masters'] as $master)
					<?php
					$created_by = get_user($master->create_by);
					$role_id = get_usermeta( $master->create_by, '_userrole_id' );
					$role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
					?>
					@if(!in_array($data['master_type'], array('revision', 'user_attendence')))
					@if(check_permission(Auth::user()->id, 'master.destroy', $data['master_type']))
					<td><input type="checkbox" class="single_check_action" value="{{$master->id}}"></td>
					@endif
					@endif
					@if($data['master_type'] == 'case')
					<td>
						<span class="case_name">{{ $master->name }}</span>
						<br>
						<span class="case_number">No: <?php echo get_mastermeta($master->id, 'case_number');?></span>
						<br>
						<?php 
						$case_category_id = get_mastermeta($master->id, 'case_category_id');
						$case_subcategory_id = get_mastermeta($master->id, 'case_subcategory_id');

						$case_category = get_master($case_category_id);
						$case_subcategory = get_master($case_subcategory_id);

						?>
						<span class="case_cat">Case: {{$case_category == null ? '' : $case_category->name}} {{$case_subcategory == null ? '' : '- '.$case_subcategory->name}}</span>
						<br>
						<span class="file_number">File Numbers: 
							<?php
								$casefiles = DB::table('case_files')->select('case_files.file_id as file_id', 'name')
						                              ->join('masters', function ($join) {
						                                    $join->on('case_files.file_id', '=', 'masters.id');
						                                })
						                              ->where('case_id', $master->id)
						                              ->get();
						        foreach ($casefiles as $casefile) :
						        $file_location_id = get_mastermeta($casefile->file_id, 'file_location_id');
						        $file_location = get_master($file_location_id);
							?>
							<span class="label label-primary">{{$casefile->name}} - {{$file_location == null ? '' : $file_location->name}}</span>
							<?php endforeach;?>
						</span>
						<br>
						<span class="assigned">Assigned To: </span>
						<br>
						<span class="assignees">
							<?php 
								$assignees = DB::table('todoassignees')->select('todoassignees.user_id as user_id', 'users.name as name', 'users.username as username', 'users.email as email', 'users.id as id')
								->join('users', 'users.id', '=', 'todoassignees.user_id')
								->where('todoassignees.master_id', $master->id)
								->get();


								if(count($assignees)) :
								foreach ($assignees as $assignee) :
									$role_id = get_usermeta($assignee->user_id, '_userrole_id');
									$role_name = '';
									if($role_id) {
										$user_role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
										$role_name = $user_role->name;
									}
							?>
							<ul style="display: none">
								<li>{{$assignee->name}}</li>
								<li>{{$role_name}}</li>
								<li>{{$assignee->email}}</li>
								<li>{{$assignee->username}}</li>
								<li>{{get_usermeta($assignee->id, 'mobile')}}</li>
							</ul>
							<?php		
									$profile_image = get_usermeta($assignee->user_id, '_profile_image');
									if($profile_image == null) :
							?>
							<span class="assignee_name" data-toggle="tooltip" title="{{ $assignee->name .' - '.$role_name }}">
								{{substr(strrev($assignee->name),-1)}}
							</span>
							<?php else: 
								$profile_image_url = 'public/storage/'.$profile_image;
							?>
							<img class="rounded-assignee" src="{{ url($profile_image_url) }}" alt="{{ $assignee->name .' - '.$role_name }}" data-toggle="tooltip" title="{{ $assignee->name .' - '.$role_name }}">
							<?php endif;
								endforeach;
								endif;
							?>
						</span>

					</td>
					@else
					<td>{{ $master->name }}</td>
					@endif
					@if($data['master_type'] == 'evaluation')
					<?php
					$assignee_id = get_mastermeta($master->id, 'assignee_id');;
					$assignee = get_user($assignee_id);
					$role_id = get_usermeta( $assignee_id, '_userrole_id' );
					$role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
					?>
					<td>{{$assignee->name .' - '. $role->name}}</td>
					<td>{{date('F d, Y', strtotime(get_mastermeta($master->id, 'deadline')))}}</td>
					@endif
					@if( in_array($data['master_type'], $has_sub_master_arr) || $data['master_type'] == 'revision' )
					@if($master->master_parent_id == 0)
						<td>Opened</td>
					@else
						<?php
						$parent = DB::table('masters')->select('name')->where('id', $master->master_parent_id)->first();
						?>
						<td>{{isset($parent->name) ? $parent->name : ''}}</td>
					@endif
					@endif
					@if($data['master_type'] == 'case')
					<td>
						<?php
							$court_id = get_mastermeta($master->id, 'court_id');
							$subcourt_id = get_mastermeta($master->id, 'subcourt_id');

							$court = get_master($court_id);							
							$subcourt = get_master($subcourt_id);							
						?>
						<span class="court_name">Court: {{$court == null ? '' : $court->name}}</span>
						<br>
						<span class="subcourt_name">Subcourt: {{$subcourt == null ? '' : $subcourt->name}}</span>
					</td>
					<td>
						<?php
							$client_id = get_mastermeta($master->id, 'client_id');
							$opponent_id = get_mastermeta($master->id, 'opponent_id');

							$client = get_user($client_id);							
							$opponent = get_user($opponent_id);							
						?>
						{{empty($client) ? '' : $client->name}}
						<br>
						<span class="vs">VS</span>
						<br>
						{{empty($opponent) ? '' : $opponent->name}}

						<ul style="display: none">
							<li>{{$client->email}}</li>
							<li>{{$client->username}}</li>
							<li>{{get_usermeta($client->id, 'mobile')}}</li>
						</ul>
					</td>
					<td>
						<?php
							$hearing_date = '';
				            $hearing = DB::table('masters')->select('id')->where([['master_parent_id', $master->id], ['master_type', 'hearing']])->orderByDesc('id')->first();

				            if(isset($hearing->id)) {
				              $hearing_date = date('d-m-Y', strtotime(get_mastermeta($hearing->id, 'hearing_date')));
				            }

				            echo $hearing_date;
						?>
					</td>
					<td>
						<?php
							$case_status = get_mastermeta($master->id, 'case_status');

							echo ucwords(str_replace('_', ' ', $case_status));
						?>
						
					</td>
					@elseif($data['master_type'] == 'todo')
					<?php
					$assignees = DB::table('todoassignees')->select('user_id')->where('master_id', $master->id)->get();
					?>
					<td>
						<ul>
							@forelse($assignees as $assignee)
							<?php $user = get_user($assignee->user_id);?>
							<li>{{$user->name}}</li>
							@empty
							@endforelse
						</ul>
					</td>
					<?php
					$priority = get_mastermeta($master->id, 'todo_priority');
					if($priority == 'low') {
						$priority_html = '<span class="label label-default">'.ucwords($priority).'</span>';
					}elseif($priority == 'medium') {
						$priority_html = '<span class="label label-warning">'.ucwords($priority).'</span>';
					}else {
						$priority_html = '<span class="label label-danger">High</span>';
					}
					?>
					<td><?php echo $priority_html;?></td>
					<td>{{ date('F d, Y', strtotime(get_mastermeta($master->id, 'due_date'))) }}</td>
					<td>{{ get_mastermeta($master->id, 'is_completed') == 0 ? 'Open' : 'Close' }}</td>
					@elseif($data['master_type'] == 'incident')
					<?php
					$assignees = DB::table('todoassignees')->select('user_id')->where('master_id', $master->id)->get();
					?>
					<td>
						<ul>
							@forelse($assignees as $assignee)
							<?php $user = get_user($assignee->user_id);?>
							<li>{{$user->name}}</li>
							@empty
							@endforelse
						</ul>
					</td>
					<?php
					$priority = get_mastermeta($master->id, 'incident_priority');
					if($priority == 'low') {
						$priority_html = '<span class="label label-default">'.ucwords($priority).'</span>';
					}elseif($priority == 'medium') {
						$priority_html = '<span class="label label-warning">'.ucwords($priority).'</span>';
					}else {
						$priority_html = '<span class="label label-danger">High</span>';
					}
					?>
					<td><?php echo $priority_html;?></td>
					<td>{{ date('F d, Y', strtotime(get_mastermeta($master->id, 'due_date'))) }}</td>
					<td>
						<?php
							$incident_status = get_mastermeta($master->id, 'is_completed');
							switch ($incident_status) {
								case 0:
									echo 'Open';
									break;
								
								case 1:
									echo 'Close';
									break;
								case 2:
									echo 'Pending Customer';
									break;
								case 3:
									echo 'On Hold';
									break;
							}
						?>
					</td>
					@elseif($data['master_type'] == 'holiday')
					<td>{{ date('F d, Y', strtotime(get_mastermeta($master->id, 'holiday_date'))) }}</td>
					@elseif($data['master_type'] == 'file_manager')
					<td>{{get_mastermeta($master->id, 'file_number')}}</td>
					<td>{{get_mastermeta($master->id, 'case_number')}}</td>
					<?php
						$file_location_id = get_mastermeta($master->id, 'file_location_id');
						$file_location = DB::table('masters')->select('name')->where('id', $file_location_id)->first();
					?>
					<td>{{isset($file_location->name) ? $file_location->name : '' }}</td>
					@elseif($data['master_type'] == 'judgement')
					<td>{{get_mastermeta($master->id, 'case_number')}}</td>
					@endif
					<td>{{ date('F d, Y g:i A', strtotime($master->created_at)) }}</td>
					<td>{{ ucwords($created_by->name).' - '.$role->name }}</td>
					@if($data['master_type'] !== 'revision')
					<td>
						@if($data['master_type'] == 'case')
						<a href="{{route('master.show', ['master' => $master->id ])}}" class="btn-link-td"><i class="fa fa-eye"></i>View</a>
						@endif
						@if(check_permission(Auth::user()->id, 'master.edit', $data['master_type']))
						<a href="{{url('master/'.$master->id.'/edit')}}" class="btn-link-td"><i class="fa fa-edit"></i>Edit</a>
						@endif
						@if(check_permission(Auth::user()->id, 'master.destroy', $data['master_type']))
						<button type="button"
						class="btn-link-td"
						onclick="event.preventDefault();
						document.getElementById('delete-form-{{$master->id}}').submit();">
						<i class="fa fa-trash-o"></i>Delete
						</button>
						<form id="delete-form-{{$master->id}}" action="{{'master/'.$master->id}}" method="POST" style="display: none;">
							@csrf
							@method('DELETE')
						</form>
						@endif
						@if($data['master_type'] == 'contact')
						@if(check_permission(Auth::user()->id, 'send.email', $data['master_type']))
						<a href="{{route('send.email', ['id' => $master->id ])}}" class="btn-link-td"><i class="fa fa-envelope" aria-hidden="true"></i>Send Email</a>
						@endif
						@if(check_permission(Auth::user()->id, 'send.sms', $data['master_type']))
						<a href="{{route('send.sms', ['id' => $master->id ])}}" class="btn-link-td"><i class="fa fa-paper-plane" aria-hidden="true"></i>Send SMS</a>
						@endif
						@endif
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
</div>
</section>
@endsection
@endif