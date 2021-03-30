@extends('non_admin.layouts.master')
<?php $masters = get_master_slugs();?>
@if(isset($masters[$data['master_type']]))
@section('title', ucfirst(substr(Route::currentRouteName(), 7)).' '.$masters[$data['master_type']])
@section('content')
<?php
$user_role = get_usermeta(Auth::user()->id, '_userrole_id');
?>
<div class="col-lg-8 col-md-7  @yield('edit-page-content')">
	<div class="form-block">
			<h1>{{ucfirst(substr(Route::currentRouteName(), 7))}} {{$masters[$data['master_type']]}} @yield('addnew')</h1>
		@if($errors->any())
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		@if(session()->has('masterSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('masterSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('masterErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('masterErrorMsg') }}</p>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{url('/master')}}<?php if($__env->yieldContent('masterId')) { echo '/'.$__env->yieldContent('masterId');}?>" id="MasterForm" class="formular adminForm" autocomplete="off">
						@csrf
						@section("editMethod")
						@show
						<input type="hidden" name="master_type" value="{{$data['master_type']}}">
						<input type="hidden" name="master_id" value="<?php if($__env->yieldContent('masterId')) { echo $__env->yieldContent('masterId');}else { echo 0;} ?>">
						<div class="row">
							<label class="col-sm-2 label-lg">Name </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="name" id="name" value="<?php if($__env->yieldContent('name')) { echo $__env->yieldContent('name');}else { echo old('name');} ?>"></div>
							<div class="clearfix"></div>
							@if($data['master_type'] == 'evaluation')
							<label class="col-sm-2 label-lg">Deadline </label>
							<div class="col-sm-10 form-group"><input type="text" name="deadline" value="<?php if(isset($data['deadline'])) { echo $data['deadline'];}else { echo old('deadline');} ?>" class="date validate[required]" readonly /></div>
							<div class="clearfix"></div>
							<div class="col-sm-12 form-group">
								<h4>Objectives
								@if(!$__env->yieldContent('masterId'))
								&nbsp;&nbsp;<a href="javascript:void(0);" id="add_objective"><i class="fa fa-plus"></i>&nbsp;Add</a>
								@endif
								</h4>
								<div class="table-responsive">
									<table class="table table-striped" id="objective_table">
										<thead>
											<tr>
												<th>Objective</th>
												<th>Weightage</th>
												<th>Employee Comment</th>
												<th>Reviewer Comment</th>
												<th>Actual Score</th>
												@if(!$__env->yieldContent('masterId'))
												<th>Action</th>
											@endif			</tr>
										</thead>
										<tbody>
											@if($__env->yieldContent('masterId'))
											@isset($data['objectives'])
											@forelse($data['objectives'] as $objective)
											<tr>
												<td>
													{{$objective->objective}}
												</td>
												<td>
													{{$objective->weightage}}
													
												</td>
												<td>
													{{$objective->employee_comment}}
												</td>
												<td>
													@if(in_array(Auth::user()->id, $data['assignees']) || $user_role == 10)
													@if(!empty($objective->employee_comment))
													<textarea name="reviewer_comment[{{$objective->id}}]">{{$objective->reviewer_comment}}</textarea>
													@endif
													@endif
												</td>
												<td>
													@if(in_array(Auth::user()->id, $data['assignees']) || $user_role == 10)
													@if(!empty($objective->employee_comment))
													<input type="text" name="score[{{$objective->id}}]" value="{{$objective->score}}">
													@endif
													@endif
												</td>
											</tr>
											@empty
											@endforelse
											@endisset
											@else
											<tr>
												<td>
													<textarea name="objective[]"></textarea>
												</td>
												<td>
													<input type="text" name="weightage[]" value="">
												</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											@endif
										</tbody>
									</table>
								</div>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Assignee</label>
							<div class="col-sm-10 form-group">
								<select name="assignee_id" id="assignee_id" class="form-control validate[required] text-input">
									<option value="">Select Assignee</option>
									@forelse($data['employees'] as $employee)
									@if(empty($employee['profile_image']))
									<?php $employee['profile_image'] = 'images/default-user.jpg';?>
									@else
									<?php $employee['profile_image'] = 'storage/'.$employee['profile_image'];?>
									@endif
									<option value="{{$employee['id']}}" data-image="{{asset('/public/'.$employee['profile_image'])}}" <?php if(isset($data['assignee_id']) && $employee['id'] == $data['assignee_id'] ) { echo 'selected';} ?>>{{$employee['name']}}</option>
									@empty
									<option value="">No assignees are found</option>
									@endforelse
								</select>
								<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Assignee</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Reviewers</label>
							<div class="col-sm-10 form-group">
								<select name="employee_id[]" id="employee_id" class="form-control validate[required] text-input" multiple>
									<option value="">Select Reviewers</option>
									@forelse($data['employees'] as $employee)
									@if(empty($employee['profile_image']))
									<?php $employee['profile_image'] = 'images/default-user.jpg';?>
									@else
									<?php $employee['profile_image'] = 'storage/'.$employee['profile_image'];?>
									@endif
									<option value="{{$employee['id']}}" data-image="{{asset('/public/'.$employee['profile_image'])}}" <?php if(isset($data['assignees']) && in_array($employee['id'], $data['assignees']) ) { echo 'selected';} ?>>{{$employee['name']}}</option>
									@empty
									<option value="">No assignees are found</option>
									@endforelse
								</select>
								<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Assignee</a>
							</div>
							<div class="clearfix"></div>
							@endif
							@if($data['master_type'] == 'holiday')
							<label class="col-sm-2 label-lg">Date </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input date" name="holiday_date" id="holiday_date" readonly value="<?php if(isset($data['holiday_date'])) { echo $data['holiday_date'];}else { echo old('holiday_date');} ?>"></div>
							<div class="clearfix"></div>
							@endif
							<?php $has_sub_master_arr = array('court', 'state', 'case_category'); ?>
							@if( in_array($data['master_type'], $has_sub_master_arr) )
							<label class="col-sm-2 label-lg">Select Parent {{ucwords(str_replace('_', ' ', $masters[$data['master_type']]))}}</label>
							<div class="col-sm-10 form-group">
								<select name="master_parent_id" class="form-control text-input lawselect">
									<option value="0">Select {{ucwords(str_replace('_', ' ', $masters[$data['master_type']]))}}</option>
									@forelse($data['parents'] as $parent)
									@if(isset($data['master_parent_id']))
									@if($parent->id != $data['edit_id'])
									<option value="{{$parent->id}}" <?php if(isset($data['master_parent_id']) && $data['master_parent_id'] == $parent->id) { echo 'selected';} ?>>{{$parent->name}}</option>
									@endif
									@else
									<option value="{{$parent->id}}">{{$parent->name}}</option>
									@endif
									@empty
									<option value="0">No {{$masters[$data['master_type']]}}s are found</option>
									@endforelse
								</select>
							</div>
							<div class="clearfix"></div>
							@endif
							@if($data['master_type'] == 'case')
							<input type="hidden" name="folder_name" value="Case Documents">
							<label class="col-sm-2 label-lg">Case Number </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="case_number" id="case_number" value="<?php if(isset($data['case_number'])) { echo $data['case_number'];}else { echo old('case_number');} ?>"></div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select File Number</label>
							<div class="col-sm-10 form-group">
								<select name="file_id[]" id="file_id" class="form-control text-input" multiple>
									<option value="">Select File Number</option>
									@if(isset($data['files']))
									@forelse($data['files'] as $file)
									
									<option value="{{$file['id']}}" <?php if(isset($data['casefiles']) && in_array($file['id'], $data['casefiles']) ) { echo 'selected';} ?>>{{$file['name']}}</option>
									@empty
									<option value="">No files are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/master/create?master_type=file_manager') }}" class="btn btn-primary pull-right">Add New File</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Client</label>
							<div class="col-sm-10 form-group">
								<select name="client_id" class="form-control validate[required] text-input lawselect">
									<option value="">Select Client</option>
									@if(isset($data['clients']))
									@forelse($data['clients'] as $client)
									<option value="{{$client[0]['id']}}" <?php if(isset($data['client_id']) && $data['client_id'] == $client[0]['id']) { echo 'selected';} ?>>{{$client[0]['name']}}</option>
									@empty
									<option value="">No clients are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Client</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Opponent</label>
							<div class="col-sm-10 form-group">
								<input type="text" class="form-control validate[required] text-input" name="opponent" id="opponent" value="<?php if(isset($data['opponent'])) { echo $data['opponent'];}else { echo old('opponent');} ?>">
								<?php if($__env->yieldContent('masterId')) : ?>
									<input type="hidden" name="opponent_id" value="{{$data['opponent_id']}}">
								<?php endif;?>
								<?php /* ?>
								<select name="opponent_id" class="form-control validate[required] text-input lawselect">
									<option value="">Select Opponent</option>
									@if(isset($data['opponents']))
									@forelse($data['opponents'] as $opponent)
									<option value="{{$opponent[0]['id']}}" <?php if(isset($data['opponent_id']) && $data['opponent_id'] == $opponent[0]['id']) { echo 'selected';} ?>>{{$opponent[0]['name']}}</option>
									@empty
									<option value="">No opponents are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Opponent</a>
								<?php */ ?>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Court</label>
							<div class="col-sm-10 form-group">
								<select name="court_id" class="form-control validate[required] text-input lawselect" data-type="court">
									<option value="">Select Court</option>
									@if(isset($data['courts']))
									@forelse($data['courts'] as $court)
									<option value="{{$court->id}}" <?php if(isset($data['court_id']) && $data['court_id'] == $court->id) { echo 'selected';} ?>>{{$court->name}}</option>
									@empty
									<option value="">No courts are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/master/create?master_type=court') }}" class="btn btn-primary pull-right">Add New Court</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Subcourt</label>
							<div class="col-sm-10 form-group">
								<select name="subcourt_id" class="form-control text-input lawselect">
									<option value="0">Select Subcourt</option>
									@if(isset($data['subcourts']))
									@forelse($data['subcourts'] as $subcourt)
									<option value="{{$subcourt->id}}" <?php if(isset($data['subcourt_id']) && $data['subcourt_id'] == $subcourt->id) { echo 'selected';} ?>>{{$subcourt->name}}</option>
									@empty
									<option value="0">No subcourts are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/master/create?master_type=court') }}" class="btn btn-primary pull-right">Add New Subcourt</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Case Category</label>
							<div class="col-sm-10 form-group">
								<select name="case_category_id" class="form-control validate[required] text-input lawselect" data-type="case_category">
									<option value="">Select Case Category</option>
									@if(isset($data['case_categories']))
									@forelse($data['case_categories'] as $case_category)
									<option value="{{$case_category->id}}" <?php if(isset($data['case_category_id']) && $data['case_category_id'] == $case_category->id) { echo 'selected';} ?>>{{$case_category->name}}</option>
									@empty
									<option value="">No case categories are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/master/create?master_type=case_category') }}" class="btn btn-primary pull-right">Add New Case Category</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Case Subcategory</label>
							<div class="col-sm-10 form-group">
								<select name="case_subcategory_id" class="form-control text-input lawselect">
									<option value="0">Select Case Subcategory</option>
									@if(isset($data['case_subcategories']))
									@forelse($data['case_subcategories'] as $case_subcategory)
									<option value="{{$case_subcategory->id}}" <?php if(isset($data['case_subcategory_id']) && $data['case_subcategory_id'] == $case_subcategory->id) { echo 'selected';} ?>>{{$case_subcategory->name}}</option>
									@empty
									<option value="0">No case subcategories are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/master/create?master_type=case_category') }}" class="btn btn-primary pull-right">Add New Case Subcategory</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Select Assignees</label>
							<div class="col-sm-10 form-group">
								<select name="employee_id[]" id="employee_id" class="form-control validate[required] text-input" multiple>
									<option value="">Select Assignees</option>
									@if(isset($data['employees']))
									@forelse($data['employees'] as $employee)
									@if(empty($employee['profile_image']))
									<?php $employee['profile_image'] = 'images/default-user.jpg';?>
									@else
									<?php $employee['profile_image'] = 'storage/'.$employee['profile_image'];?>
									@endif
									<option value="{{$employee['id']}}" data-image="{{asset('/public/'.$employee['profile_image'])}}" <?php if(isset($data['assignees']) && in_array($employee['id'], $data['assignees']) ) { echo 'selected';} ?>>{{$employee['name']}}</option>
									@empty
									<option value="">No assignees are found</option>
									@endforelse
									@endif
								</select>
								<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Assignee</a>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Next Hearing Date</label>
							<div class="col-sm-10 form-group">
								<input type="text" class="form-control date" name="hearing_date" value="{{isset($data['hearing_date']) ? $data['hearing_date'] : ''}}" readonly>
							</div>
							<div class="clearfix"></div>
							<?php
							$case_status = isset($data['case_status']) ? $data['case_status'] : 'active';
							?>
							<label class="col-sm-2 label-lg">Case Status</label>
							<div class="col-sm-10 form-group">
								<select name="case_status" class="form-control validate[required] text-input lawselect">
									<option value="active" <?php if($case_status == 'active') { echo 'selected';} ?> >Active</option>
									<option value="suspended" <?php if($case_status == 'suspended') { echo 'selected';} ?> >Suspended</option>
									<option value="closed" <?php if($case_status == 'closed') { echo 'selected';} ?> >Closed</option>
								</select>
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Case Description</label>
							<div class="col-sm-10 form-group">
								<textarea name="case_description" id="clientEditor"></textarea>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-10 col-sm-offset-2 form-group">
								<button type="button" class="btn btn-primary print_ck_text"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Text</button>
							</div>
							<div class="clearfix"></div>
							@if($__env->yieldContent('masterId'))
							<?php $dir_name = get_mastermeta($__env->yieldContent('masterId'), 'dir_name');?>
							<label class="col-sm-2 label-lg">Upload Case Documents <font size="2rem">(Google Drive Folder Name: <span id="subdir_name">{{$dir_name == null ? 'NA' : $dir_name}}</span>)</font></label>
							<div class="col-sm-10"><input type="file" name="file" class="filer_input_doc"></div>
							<div class="clearfix"></div>
							<div class="col-sm-10 col-sm-offset-2 form-group upload_google_drive_sec"></div>
							<div class="clearfix"></div>
							<div class="col-sm-10 col-sm-offset-2">
								<ul class="file-list list-inline" id="subdir_files"  data-folder="{{$dir_name}}"></ul>
							</div>
							<div class="clearfix"></div>
						@endif
						@endif
						@if($data['master_type'] == 'incident')
						<label class="col-sm-2 label-lg">Select Assignees</label>
						<div class="col-sm-10 form-group">
							<select name="employee_id[]" id="employee_id" class="form-control validate[required] text-input" multiple>
								<option value="">Select Assignees</option>
								@forelse($data['employees'] as $employee)
								@if(empty($employee['profile_image']))
								<?php $employee['profile_image'] = 'images/default-user.jpg';?>
								@else
								<?php $employee['profile_image'] = 'storage/'.$employee['profile_image'];?>
								@endif
								<option value="{{$employee['id']}}" data-image="{{asset('/public/'.$employee['profile_image'])}}" <?php if(isset($data['assignees']) && in_array($employee['id'], $data['assignees']) ) { echo 'selected';} ?>>{{$employee['name']}}</option>
								@empty
								<option value="">No assignees are found</option>
								@endforelse
							</select>
							<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Assignee</a>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Due Date</label>
						<div class="col-sm-10 form-group">
							<input type="text" class="form-control date" name="due_date" value="{{isset($data['due_date']) ? $data['due_date'] : ''}}" readonly>
						</div>
						<div class="clearfix"></div>
						<?php
						$incident_status = isset($data['is_completed']) ? $data['is_completed'] : 0;
						?>
						@if($__env->yieldContent('masterId'))
						<label class="col-sm-2 label-lg">Status</label>
						<div class="col-sm-10 form-group">
							<select name="incident_status" class="form-control validate[required] text-input lawselect">
								<option value="0" <?php if($incident_status == 0) { echo 'selected';} ?> >Open</option>
								<option value="2" <?php if($incident_status == 2) { echo 'selected';} ?> >Pending Customer</option>
								<option value="3" <?php if($incident_status == 3) { echo 'selected';} ?> >On Hold</option>
								<option value="1" <?php if($incident_status == 1) { echo 'selected';} ?> >Close</option>
							</select>
						</div>
						<div class="clearfix"></div>
						@endif
						<?php
						$incident_priority = isset($data['incident_priority']) ? $data['incident_priority'] : 'high';
						?>
						<label class="col-sm-2 label-lg">Priority</label>
						<div class="col-sm-10 form-group">
							<select name="incident_priority" class="form-control validate[required] text-input lawselect">
								<option value="high" <?php if($incident_priority == 'high') { echo 'selected';} ?> >High</option>
								<option value="medium" <?php if($incident_priority == 'medium') { echo 'selected';} ?> >Medium</option>
								<option value="low" <?php if($incident_priority == 'low') { echo 'selected';} ?> >Low</option>
							</select>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Incident Description</label>
						<div class="col-sm-10 form-group">
							<textarea name="incident_description" id="incidentEditor"></textarea>
						</div>
						<div class="clearfix"></div>
						@endif
						@if($data['master_type'] == 'todo')
						<label class="col-sm-2 label-lg">Select Assignees</label>
						<div class="col-sm-10 form-group">
							<select name="employee_id[]" id="employee_id" class="form-control validate[required] text-input" multiple>
								<option value="">Select Assignees</option>
								@forelse($data['employees'] as $employee)
								@if(empty($employee['profile_image']))
								<?php $employee['profile_image'] = 'images/default-user.jpg';?>
								@else
								<?php $employee['profile_image'] = 'storage/'.$employee['profile_image'];?>
								@endif
								<option value="{{$employee['id']}}" data-image="{{asset('/public/'.$employee['profile_image'])}}" <?php if(isset($data['assignees']) && in_array($employee['id'], $data['assignees']) ) { echo 'selected';} ?>>{{$employee['name']}}</option>
								@empty
								<option value="">No assignees are found</option>
								@endforelse
							</select>
							<a href="{{ url('/user/create') }}" class="btn btn-primary pull-right">Add New Assignee</a>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Due Date</label>
						<div class="col-sm-10 form-group">
							<input type="text" class="form-control date" name="due_date" value="{{isset($data['due_date']) ? $data['due_date'] : ''}}" readonly>
						</div>
						<div class="clearfix"></div>
						<?php
						$todo_status = isset($data['is_completed']) ? $data['is_completed'] : 0;
						?>
						@if($__env->yieldContent('masterId'))
						<label class="col-sm-2 label-lg">Status</label>
						<div class="col-sm-10 form-group">
							<select name="todo_status" class="form-control validate[required] text-input lawselect">
								<option value="0" <?php if($todo_status == 0) { echo 'selected';} ?> >Open</option>
								<option value="1" <?php if($todo_status == 1) { echo 'selected';} ?> >Close</option>
							</select>
						</div>
						<div class="clearfix"></div>
						@endif
						<?php
						$todo_priority = isset($data['todo_priority']) ? $data['todo_priority'] : 'high';
						?>
						<label class="col-sm-2 label-lg">Priority</label>
						<div class="col-sm-10 form-group">
							<select name="todo_priority" class="form-control validate[required] text-input lawselect">
								<option value="high" <?php if($todo_priority == 'high') { echo 'selected';} ?> >High</option>
								<option value="medium" <?php if($todo_priority == 'medium') { echo 'selected';} ?> >Medium</option>
								<option value="low" <?php if($todo_priority == 'low') { echo 'selected';} ?> >Low</option>
							</select>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Todo Description</label>
						<div class="col-sm-10 form-group">
							<textarea name="todo_description" id="todoEditor"></textarea>
						</div>
						<div class="clearfix"></div>
						@endif

						@if($data['master_type'] == 'file_manager')
						<label class="col-sm-2 label-lg">File Number </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="file_number" value="<?php if(isset($data['file_number'])) { echo $data['file_number'];}else { echo old('file_number');} ?>"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Case Number </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="case_number" value="<?php if(isset($data['case_number'])) { echo $data['case_number'];}else { echo old('case_number');} ?>"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Matter</label>
						<div class="col-sm-10 form-group">
							<textarea name="file_matter" id="fileMatterEditor"></textarea>
						</div>	
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Select Location</label>
						<div class="col-sm-10 form-group">
							<select name="file_location_id" class="form-control text-input lawselect">
								<option value="0">Select Location</option>
								@if(isset($data['file_locations']))
								@forelse($data['file_locations'] as $file_location)
								<option value="{{$file_location->id}}" <?php if(isset($data['file_location_id']) && $data['file_location_id'] == $file_location->id) { echo 'selected';} ?>>{{$file_location->name}}</option>
								@empty
								<option value="0">No case subcategories are found</option>
								@endforelse
								@endif
							</select>
							<a href="{{ url('/master/create?master_type=file_location') }}" class="btn btn-primary pull-right">Add New Location</a>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Last Update</label>
						<div class="col-sm-10 form-group">
							<input type="text" class="form-control date validate[required]" name="last_update_date" value="{{isset($data['last_update_date']) ? $data['last_update_date'] : old('last_update_date')}}" readonly>
						</div>
						<div class="clearfix"></div>
						@endif

						@if($data['master_type'] == 'judgement')
						<input type="hidden" name="folder_name" value="Judgement Documents">
						<label class="col-sm-2 label-lg">Case Number </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="case_number" id="case_number" value="<?php if(isset($data['case_number'])) { echo $data['case_number'];}else { echo old('case_number');} ?>"></div>

						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Judgement Description</label>
						<div class="col-sm-10 form-group">
							<textarea name="judgement_description" id="judgementEditor"></textarea>
						</div>
						<div class="clearfix"></div>
						@if($__env->yieldContent('masterId'))
						<?php $dir_name = get_mastermeta($__env->yieldContent('masterId'), 'dir_name');?>
						<label class="col-sm-2 label-lg">Upload Judgement Documents <font size="2rem">(Google Drive Folder Name: <span id="subdir_name">{{$dir_name == null ? 'NA' : $dir_name}}</span>)</font></label>
						<div class="col-sm-10"><input type="file" name="file" class="filer_input_doc"></div>
						<div class="clearfix"></div>
						<div class="col-sm-10 col-sm-offset-2 form-group upload_google_drive_sec"></div>
							<div class="clearfix"></div>
						<div class="col-sm-10 col-sm-offset-2">
							<ul class="file-list list-inline" id="subdir_files"  data-folder="{{$dir_name}}"></ul>
						</div>
						<div class="clearfix"></div>
						@endif
						@endif

						@if($data['master_type'] == 'contact')
						<label class="col-sm-2 label-lg">Email Address </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required],custom[email]] text-input" name="email" id="email" value="{{isset($data['email']) ? $data['email'] : old('email')}}"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Additional Email Address </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control custom[email] text-input" name="additional_email" id="additional_email" value="{{isset($data['additional_email']) ? $data['additional_email'] : old('additional_email')}}"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Mobile </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control text-input phone validate[required]" name="mobile" id="mobile" value="{{isset($data['mobile']) ? $data['mobile'] : old('mobile')}}"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Additional Mobile </label>
						<div class="col-sm-10 form-group"><input type="text" class="form-control text-input phone validate[required]" name="additional_mobile" id="additional_mobile" value="{{isset($data['additional_mobile']) ? $data['additional_mobile'] : old('additional_mobile')}}"></div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">DOB</label>
						<div class="col-sm-10 form-group">
							<input type="text" class="form-control date validate[required]" name="dob" value="{{isset($data['dob']) ? $data['dob'] : old('dob')}}" readonly>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Anniversary</label>
						<div class="col-sm-10 form-group">
							<input type="text" class="form-control date validate[required]" name="anniversary" value="{{isset($data['anniversary']) ? $data['anniversary'] : old('anniversary')}}" readonly>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-2 label-lg">Comment</label>
						<div class="col-sm-10 form-group">
							<textarea name="comment" id="contactEditor"></textarea>
						</div>
						<div class="clearfix"></div>
						@endif
						<div class="col-sm-10 col-sm-offset-2" <?php if(isset($data['is_completed']) && $data['is_completed'] == 1) { echo 'style="display:none;"';}?>><input type="submit" value="Submit" class="btn btn-primary"></div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@if($data['master_type'] == 'case' || $data['master_type'] == 'todo' || $data['master_type'] == 'incident')
<script src="{{ asset('/public/js/ckeditor/ckeditor.js') }}" ></script>
@endif
@if($data['master_type'] == 'case')
<script type="text/javascript">
CKEDITOR.replace( 'clientEditor', {
	filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
});
$('.print_ck_text').on('click', function(e) {
	e.preventDefault()
	g = CKEDITOR.instances.clientEditor; // Your ckeditor
	if (CKEDITOR.env.ie) {
	   selection = g.getSelection().document.$.selection.createRange().text;
	} else {
	   selection  = g.getSelection().getNative();
	}   
	if(selection != '') {
		var a = window.open('', '', 'height=500, width=500'); 
	    a.document.write(selection); 
	    a.document.close(); 
	    a.print();
	}
})
<?php if(isset($data['case_desc'])) : ?>
CKEDITOR.instances.clientEditor.setData(`<?php echo $data['case_desc'];?>`);
<?php endif;?>
</script>
@endif
@if($data['master_type'] == 'todo')
<script type="text/javascript">
CKEDITOR.replace( 'todoEditor', {
	filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
});
<?php if(isset($data['todo_description'])) : ?>
CKEDITOR.instances.todoEditor.setData(`<?php echo $data['todo_description'];?>`);
<?php endif;?>
</script>
@endif
@if($data['master_type'] == 'incident')
<script type="text/javascript">
CKEDITOR.replace( 'incidentEditor', {
	filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
});
<?php if(isset($data['incident_description'])) : ?>
CKEDITOR.instances.incidentEditor.setData(`<?php echo $data['incident_description'];?>`);
<?php endif;?>
</script>
@endif
@section("hearingLogs")
@show
@endsection
@endif