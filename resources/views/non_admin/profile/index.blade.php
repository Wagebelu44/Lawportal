@extends('non_admin.layouts.master')
@section('title', ucfirst(Route::currentRouteName()))
@section("userId", $user->id)
@section("name", $user->name)
@section("email", $user->email)
@section("mobile", get_usermeta($user->id, 'mobile'))
@section("address", get_usermeta($user->id, 'address'))
@section('content')
<div class="col-lg-8 col-md-7">
	<div class="form-block">
		<h3>{{ucfirst(Route::currentRouteName())}}</h3>
		@if($errors->any())
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		@if(session()->has('profileSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('profileSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('profileErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('profileErrorMsg') }}</p>
		</div>
		@endif
		<form method="post" action="{{url('/profile')}}" id="MasterForm" class="formular adminForm" autocomplete="off" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<label class="col-sm-3 label-lg">Name </label>
				<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required] text-input" name="name" id="name" value="<?php if($__env->yieldContent('name')) { echo $__env->yieldContent('name');}else { echo old('name');} ?>"></div>
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
				<label class="col-sm-3 label-lg">Password</label>
				<div class="col-sm-9 form-group"><input type="password" class="form-control <?php if($__env->yieldContent('email')) { echo 'validate[minSize[8]]'; }else { echo 'validate[required,minSize[8]]';} ?> text-input login-field  login-field-password" id="password-3" name="password">
				<div class="clearfix strength-fld">
					<div id="pwdMeter" class="neutral">Very Weak</div>
				</div>
			</div>
			<input type="hidden" name="folder_name" value="User Documents">
			<input type="hidden" name="master_id" value="{{Auth::user()->id}}">
			<?php $dir_name = get_usermeta(Auth::user()->id, 'dir_name');?>
			<label class="col-sm-2 label-lg">Upload ID Proofs <font size="2rem">(Google Drive Folder Name: <span id="subdir_name">{{$dir_name == null ? 'NA' : $dir_name}}</span>)</font></label>
			<div class="col-sm-10"><input type="file" name="file" class="filer_input_doc"></div>
			<div class="clearfix"></div>
			<div class="col-sm-10 col-sm-offset-2 form-group upload_google_drive_sec"></div>
			<div class="clearfix"></div>
			<div class="col-sm-10 col-sm-offset-2">
			<ul class="file-list list-inline" id="subdir_files"  data-folder="{{$dir_name}}"></ul>
			<div class="clearfix"></div>
			<div class="col-sm-9 col-sm-offset-3"><input type="submit" value="Submit" class="btn btn-primary"></div>
		</div>
	</form>
</div>
</div>
@endsection