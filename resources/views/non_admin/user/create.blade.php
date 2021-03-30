@extends('non_admin.layouts.master')
@if($data['userrole_id'] > 0)

@foreach($data['userroles'] as $userrole)
@if($data['userrole_id'] == $userrole->id)
@if(in_array($data['userrole_id'], array(2,3,18))) {
	@section('title', ucfirst(substr(Route::currentRouteName(), 5)).' '.$userrole->name)
@else
	@section('title', ucfirst(substr(Route::currentRouteName(), 5)).' Employee')
@endif

@section('userrole_name', $userrole->name)
@endif
@endforeach

@else
@section('title', ucfirst(substr(Route::currentRouteName(), 5)).' Employee')
@endif
@section('content')
<div class="col-lg-8 col-md-7">
	<div class="form-block">
		<h1>
			{{ucfirst(substr(Route::currentRouteName(), 5))}} 
			<?php if($__env->yieldContent('userrole_name')) { 
				if(in_array($data['userrole_id'], array(2,3,18))) {
					echo $__env->yieldContent('userrole_name');
				}else {
					echo 'Employee';
				}
			}else { 
				echo 'Employee'; 
			} ?> 
			@yield('addnew')
		</h1>
		@if($errors->any())
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		@if(session()->has('userSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('userSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('userErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('userErrorMsg') }}</p>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{url('/user')}}<?php if($__env->yieldContent('userId')) { echo '/'.$__env->yieldContent('userId');} ?>" id="MasterForm" class="formular adminForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@section("editMethod")
						@show
						<div class="row">
							<input type="hidden" name="folder_name" value="User Documents">
							@if($data['userrole_id'] == 0)
							<label class="col-sm-3 label-lg">Employee Type </label>
							<div class="col-sm-9 form-group">
								<select name="userrole_id" class="form-control validate[required] lawselect">
									<option value="">Select Employee Role</option>
									@forelse($data['userroles'] as $userrole)
									@if(!in_array($userrole->id, array(2,3,18)))
									<option value="{{$userrole->id}}" <?php if(isset($userrole_id) && $userrole_id == $userrole->id) { echo 'selected';} ?>>{{ $userrole->name }}</option>
									@endif
									@empty
									<option>No user type found</option>
									@endforelse
								</select>
								<a href="{{ url('/userrole/create') }}" class="btn btn-primary pull-right">Add New User Role</a>
							</div>
							@else
							@if(in_array($data['userrole_id'], array(2,3,18)))
							<input type="hidden" name="userrole_id" value="{{$data['userrole_id']}}">
							@else
							<label class="col-sm-3 label-lg">Employee Type </label>
							<div class="col-sm-9 form-group">
								<select name="userrole_id" class="form-control validate[required] lawselect">
									<option value="">Select Employee Role</option>
									@forelse($data['userroles'] as $userrole)
									@if(!in_array($userrole->id, array(2,3,18)))
									<option value="{{$userrole->id}}" <?php if(isset($userrole_id) && $userrole_id == $userrole->id) { echo 'selected';} ?>>{{ $userrole->name }}</option>
									@endif
									@empty
									<option>No user type found</option>
									@endforelse
								</select>
								<a href="{{ url('/userrole/create') }}" class="btn btn-primary pull-right">Add New User Role</a>
							</div>
							@endif
							@endif
							<label class="col-sm-3 label-lg">Name </label>
							<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required] text-input" name="name" id="name" value="<?php if($__env->yieldContent('name')) { echo $__env->yieldContent('name');}else { echo old('name');} ?>"></div>
							<label class="col-sm-3 label-lg">Username </label>
							<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required] text-input" name="username" id="username" value="<?php if($__env->yieldContent('username')) { echo $__env->yieldContent('username');}else { echo old('username');} ?>"></div>
							<label class="col-sm-3 label-lg">Email Address </label>
							<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required],custom[email]] text-input" name="email" id="email" value="<?php if($__env->yieldContent('email')) { echo $__env->yieldContent('email');}else { echo old('email');} ?>"></div>
							<div class="clearfix"></div>
							<label class="col-sm-3 label-lg">Mobile </label>
							<div class="col-sm-9 form-group"><input type="text" class="form-control text-input phone validate[required]" name="mobile" id="mobile" value="<?php if($__env->yieldContent('mobile')) { echo $__env->yieldContent('mobile');}else { echo old('mobile');} ?>"></div>
							<div class="clearfix"></div>
							<label class="col-sm-3 label-lg">Address </label>
							<div class="col-sm-9 form-group">
								<textarea class="form-control text-input" name="address" id="address"><?php if($__env->yieldContent('address')) { echo $__env->yieldContent('address');}else { echo old('address');} ?></textarea>
							</div>
							<div class="clearfix"></div>
@if(isset($userrole_id))
@if($userrole_id != 3)							
							<div id="password_section">
								<label class="col-sm-3 label-lg">Password</label>
								<div class="col-sm-9 form-group">
									<input type="password" class="form-control <?php if($__env->yieldContent('email')) { echo 'validate[minSize[8]]'; }else { echo 'validate[required,minSize[8]]';} ?> text-input login-field  login-field-password" id="password-3" name="password">
									<div class="clearfix strength-fld">
										<div id="pwdMeter" class="neutral">Very Weak</div>
									</div>
								</div>
							</div>
@endif							
@else
							<div id="password_section">
								<label class="col-sm-3 label-lg">Password</label>
								<div class="col-sm-9 form-group">
									<input type="password" class="form-control <?php if($__env->yieldContent('email')) { echo 'validate[minSize[8]]'; }else { echo 'validate[required,minSize[8]]';} ?> text-input login-field  login-field-password" id="password-3" name="password">
									<div class="clearfix strength-fld">
										<div id="pwdMeter" class="neutral">Very Weak</div>
									</div>
								</div>
							</div>
@endif
						<label class="col-sm-3 label-lg">Profile Picture</label>
						<div class="col-sm-9  form-group clearfix profile-img">
							<div class="avatar-img pull-left">
								@if($__env->yieldContent('profile_image') == null)
								<img src="{{ asset('/public/images/default-user.jpg') }}" alt="user profile image">
								@else
								<img src="{{ url('public/storage') }}/@yield('profile_image')" alt="user profile image">
								@endif
							</div>
							<div class="fileUpload btn btn-default btn-xs pull-left">
								<span>Upload profile image</span>
								<input type="file" class="upload" name="profile_image" />
							</div>
						</div>
						@if($__env->yieldContent('userId'))
						<input type="hidden" name="master_id" value="{{$__env->yieldContent('userId')}}">
						<?php $dir_name = get_usermeta($__env->yieldContent('userId'), 'dir_name');?>
						<label class="col-sm-2 label-lg">Upload ID Proofs <font size="2rem">(Google Drive Folder Name: <span id="subdir_name">{{$dir_name == null ? 'NA' : $dir_name}}</span>)</font></label>
						<div class="col-sm-10"><input type="file" name="file" class="filer_input_doc"></div>
						<div class="clearfix"></div>
						<div class="col-sm-10 col-sm-offset-2 form-group upload_google_drive_sec"></div>
						<div class="clearfix"></div>
						<div class="col-sm-10 col-sm-offset-2">
						<ul class="file-list list-inline"  data-folder="{{$dir_name}}"></ul>
					</div>
					<div class="clearfix"></div>
					@endif
					<div class="clearfix"></div>
					<div class="col-sm-9 col-sm-offset-3"><input type="submit" value="Submit" class="btn btn-primary"></div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
@endsection