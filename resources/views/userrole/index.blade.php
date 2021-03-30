@extends('layouts.master')
@section('title', 'User Roles')
@section('content')
<section class="page-content">
	<div class="wrapper">
		<div class="page-header">
			<h1>User Roles 
				@if(check_permission(Auth::user()->id, 53)) 
				<a href="{{ url('/userrole/create') }}" class="btn btn-default">Add New User Role</a>
				@endif
			</h1>
		</div>
		@if(session()->has('userroleDelSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('userroleDelSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('userroleDelErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('userroleDelErrorMsg') }}</p>
		</div>
		@endif
		<div class="item-wrap item-list-table">
			<table id="userRoledataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>Created On</th>
						<th>Created By</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($userroles as $userrole)
					<?php
					$created_by = get_user($userrole->created_by);
					$created_by_name = isset($created_by->name) ? ucwords($created_by->name) : '';
					?>
					<tr>
						<td>{{ $userrole->name }}</td>
						<td>{{ date('F d, Y', strtotime($userrole->created_at)) }}</td>
						<td>{{ $created_by_name }}</td>
						<td>
							@if(check_permission(Auth::user()->id, 9)) 
							@if($userrole->id != 10)
							<a href="{{url('userrole/'.$userrole->id.'/edit')}}" class="btn-link-td"><i class="fa fa-edit"></i>Edit</a>
							@endif
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection