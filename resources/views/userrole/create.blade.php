@extends('layouts.master')
@section('title', ucfirst(substr(Route::currentRouteName(), 9)).' User Role')
@section('content')
<section class="page-content  @yield('edit-page-content')">
	<div class="wrapper">
		<div class="page-header">
			<h1>{{ucfirst(substr(Route::currentRouteName(), 9))}} User Role @yield('addnew')</h1>
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
		@if(session()->has('userroleSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('userroleSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('userroleErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('userroleErrorMsg') }}</p>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{url('/userrole')}}<?php if($__env->yieldContent('userroleId')) { echo '/'.$__env->yieldContent('userroleId');}?>" id="UserRoleForm" class="formular adminForm" autocomplete="off">
						@csrf
						@section("editMethod")
						@show
						<div class="row">
							<label class="col-sm-1 label-lg">Name </label>
							<div class="col-sm-5 form-group"><input type="text" class="form-control validate[required] text-input" name="name" id="name" value="<?php if($__env->yieldContent('name')) { echo $__env->yieldContent('name');}else { echo old('name');} ?>"></div>
							<div class="clearfix"></div>
							<div class="col-sm-12">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">User Permissions</a>
											</h4>
										</div>
										<div id="collapse1" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<a href="javascript:void(0);" class="btn-link-td check_action" data-action="check"><i class="fa fa-check-square-o"></i>Check All</a>
														<a href="javascript:void(0);" class="btn-link-td check_action" data-action="uncheck"><i class="fa fa-check-empty"></i>Uncheck All</a>
													</div>
													<div class="clearfix"></div>
													<?php
													$permission_role_arr = [];
													if(isset($data['permission_roles']) && count($data['permission_roles'])) {
														foreach ($data['permission_roles'] as $permission_role) {
															$permission_role_arr[] = $permission_role->permission_id;
														}
													}
													?>
													@forelse($data['permission_parents'] as $permission_parent)
													<div class="col-sm-12">
													<h4>{{$permission_parent->name}}</h4>
													
<?php
$data['permissions'] = DB::table('permissions')->select('id', 'name')->where([['active', 1], ['permission_parent_id', $permission_parent->id]])->orderBy('sort', 'ASC')->get();
?>
													@forelse($data['permissions'] as $permission)
													<div class="col-sm-4"><input type="checkbox" name="permission_id[]" id="{{str_replace(' ', '_', strtolower($permission->name))}}" value="{{$permission->id}}" <?php if(in_array($permission->id, $permission_role_arr)) { echo 'checked';} ?>> <label for="{{str_replace(' ', '_', strtolower($permission->name))}}">{{$permission->name}}</label></div>
													@empty
													@endforelse
													</div>
													@empty
													@endforelse
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">User Form Fields</a>
											</h4>
										</div>
										<div id="collapse2" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-3"><input type="checkbox" id="name" checked disabled> <label for="name">Name</label></div>
													<div class="col-sm-3"><input type="checkbox" id="email" checked disabled> <label for="email">Email</label></div>
													<div class="col-sm-3"><input type="checkbox" id="password" checked disabled> <label for="password">Password</label></div>
													<div class="col-sm-3"><input type="checkbox" id="image" checked disabled> <label for="image">Upload Image</label></div>
													<div class="col-sm-3"><input type="checkbox" id="address" checked disabled> <label for="address">Address</label></div>
													<div class="col-sm-3"><input type="checkbox" id="mobile" checked disabled> <label for="mobile">Mobile</label></div>
													<?php
													$userform_arr = [];
													if(isset($userforms) && count($userforms)) {
														foreach ($userforms as $userform) {
															$userform_arr[] = $userform->formfield_id;
														}
													}
													?>
													@forelse($data['formfields'] as $formfield)
													@if($formfield->id == 5 || $formfield->id == 6)
													<?php
													$userform = DB::table('userforms')->where('formfield_id', $formfield->id)->get();
													?>
													@if(count($userform) == 0 || in_array($formfield->id, $userform_arr))
													<div class="col-sm-3"><input type="checkbox" id="{{$formfield->id}}" name="formfield[]" value="{{$formfield->id}}" <?php if(in_array($formfield->id, $userform_arr)) { echo 'checked';} ?>> <label for="{{$formfield->id}}">{{$formfield->field_name}}</label></div>
													@endif
													@else
													<div class="col-sm-3"><input type="checkbox" id="{{$formfield->id}}" name="formfield[]" value="{{$formfield->id}}" <?php if(in_array($formfield->id, $userform_arr)) { echo 'checked';} ?>> <label for="{{$formfield->id}}">{{$formfield->field_name}}</label></div>
													@endif
													@empty
													<center><p>No Form field found.</p></center>
													@endforelse
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12"><input type="submit" value="Submit" class="btn btn-primary"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection