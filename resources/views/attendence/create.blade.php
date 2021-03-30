@extends('layouts.master')
@section('title', ucfirst(substr(Route::currentRouteName(), 11)).' Attendence')
@section('content')
<section class="page-content">
	<div class="wrapper">
		<div class="page-header">
			<h1>{{ucfirst(substr(Route::currentRouteName(), 11)).' Attendence'}}</h1>
		</div>
		@if($errors->any())
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{url('/user_attendence')}}<?php if($__env->yieldContent('attendenceId')) { echo '/'.$__env->yieldContent('attendenceId');}?>" id="MasterForm" class="formular adminForm" autocomplete="off">
						@csrf
						@section("editMethod")
						@show
						<div class="row">
							@if(!$__env->yieldContent('attendenceId')) 
							<label class="col-sm-3 label-lg">Select Employee </label>
							<div class="col-sm-9 form-group">
								<select name="user_id" class="form-control validate[required] text-input lawselect">
									<option value="">Select employee</option>
									 @forelse($data['employees'] as $employee)
				                    <option value="{{$employee->id}}" <?php if(isset($data['user_id']) && ($data['user_id'] == $employee->id)) { echo 'selected';}?>>{{$employee->name}}</option>
				                    @empty
				                    @endforelse
								</select>
							</div>
							<label class="col-sm-3 label-lg">Logged On</label>
							<div class="col-sm-9 form-group">
								<input type="text" class="form-control validate[required] datetime" name="logged_at" id="logged_at">
							</div>
							@endif
							<label class="col-sm-3 label-lg">Logged Out On</label>
							<div class="col-sm-9 form-group">
								<input type="text" class="form-control validate[required] datetime" name="logged_out_at" id="logged_out_at">
							</div>
							<div class="clearfix"></div>
							<label class="col-sm-3 label-lg">Note </label>
							<div class="col-sm-9 form-group">
								<textarea class="form-control text-input" name="note" id="note"></textarea>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-9 col-sm-offset-3"><input type="submit" value="Submit" class="btn btn-primary"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection