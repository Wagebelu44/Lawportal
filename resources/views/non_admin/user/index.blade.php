@extends('non_admin.layouts.master')
@if($data['userrole_id'] > 0)
@section('title', $data['userrole']->name)
@else
@section('title', 'Employees')
@endif
@section('content')
<div class="col-lg-8 col-md-7">
	<div class="form-block">
		<h1>
			<?php if($__env->yieldContent('title')) { echo $__env->yieldContent('title');}else { echo 'Employee'; } ?> 
				@if(check_permission(Auth::user()->id, 17)) 
				<a href="{{ url('/user/create') }}{{ $data['userrole_id'] > 0 ? '?userrole_id='.$data['userrole_id'] : ''}}" class="btn btn-default">Add New <?php if($__env->yieldContent('title')) { echo $__env->yieldContent('title');}else { echo 'Employee'; } ?></a>
				@endif
		</h1>
		@if(session()->has('userDelSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('userDelSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('userDelErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('userDelErrorMsg') }}</p>
		</div>
		@endif
		<div class="item-wrap item-list-table">
			<table id="userdataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Profile Image</th>
						<th>Name</th>
						@if($data['userrole_id'] == 0)
						<th>Employee Type</th>
						@endif
						<th>Email</th>
						<th>Created On</th>
						<th>Created By</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data['users'] as $user)
					<?php
					$created_by_id = get_usermeta($user->id, 'created_by');
					$created_by_role_id = get_usermeta( $created_by_id, '_userrole_id' );
					$created_by_role_name = '';
					if($created_by_role_id != null) {
						$created_by_role = DB::table('userroles')->select('name')->where('id', $created_by_role_id)->first();
						$created_by_role_name = $created_by_role->name;
					}
					$user_role_id = get_usermeta( $user->id, '_userrole_id' );
					$user_role_name = '';
					if($user_role_id != null) {
						$user_role = DB::table('userroles')->select('name')->where('id', $user_role_id)->first();
						$user_role_name = $user_role->name;
					}
					$created_by = get_user($created_by_id);
					$created_by_name = isset($created_by->name) ? ucwords($created_by->name) : '';
					$profile_image = get_usermeta($user->id, '_profile_image');
					?>
					@if($user->id != 29)
					<tr>
						@if($profile_image == null)
						<td><img class="user-profile-image" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $user->name }}"></td>
						@else
						<?php $profile_image_url = 'public/storage/'.$profile_image;?>
						<td><img class="user-profile-image" src="{{ url($profile_image_url) }}" alt="{{ $user->name }}"></td>
						@endif
						<td>{{ $user->name }}</td>
						@if($data['userrole_id'] == 0)
						<td>{{ $user_role_name }}</td>
						@endif
						<td>{{ $user->email }}</td>
						<td>{{ date('F d, Y', strtotime($user->created_at)) }}</td>
						<td>{{ $created_by_name.' - '.$created_by_role_name }}</td>
						<td>
							@if(check_permission(Auth::user()->id, 6)) 
							<a href="{{url('user/'.$user->id.'/edit')}}" class="btn-link-td"><i class="fa fa-edit"></i>Edit</a>
							@endif
							@if(check_permission(Auth::user()->id, 7)) 
							<button type="button"
							class="btn-link-td"
							onclick="event.preventDefault();
							document.getElementById('delete-form-{{$user->id}}').submit();">
							<i class="fa fa-trash-o"></i>Delete
							</button>
							<form id="delete-form-{{$user->id}}" action="{{url('user/'.$user->id)}}" method="POST" style="display: none;">
								@csrf
								@method('DELETE')
							</form>
							@endif
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection