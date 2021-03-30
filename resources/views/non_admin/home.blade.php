@extends('non_admin.layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="col-lg-8 col-md-7">
	<div class="form-block">
	<h1>Dashboard</h1>
@if(session('permissionError'))
<div class="alert alert-success" role="alert">
	<p>{{ session('permissionError') }}</p>
</div>
@endif
	<div class="row">
		@if(check_permission(Auth::user()->id, 'user.index')) 
	    <div class="col-lg-3 col-sm-6 col-xs-12">
	        <div class="small-box bg-aqua">
	            <div class="inner">
	                <h3>{{$data['client_count']}}</h3>
	                <p>Clients</p>
	            </div>
	            <div class="icon"><i class="fa fa-users"></i></div>
	            <a href="{{route('user.index')}}?userrole_id=2" class="small-box-footer">
	                More Info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	    @endif
	    @if(check_permission(Auth::user()->id, 2))
	    <div class="col-lg-3 col-sm-6 col-xs-12">
	        <div class="small-box bg-green">
	            <div class="inner">
	                <h3>{{$data['case_count']}}</h3>
	                <p>Cases</p>
	            </div>
	            <div class="icon"><i class="fa fa-list"></i></div>
	            <a href="{{route('master.index')}}?master_type=case" class="small-box-footer">
	                More Info  <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	    @endif
	    @if(check_permission(Auth::user()->id, 'user.index'))
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{$data['employee_count']}}</h3>
                    <p>Employees</p>
                </div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <a href="{{route('user.index')}}" class="small-box-footer">
                    More Info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endif
        @if(check_permission(Auth::user()->id, 3))
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$data['todo_count']}}</h3>
                    <p>My Todos</p>
                </div>
                <div class="icon"><i class="fa fa-tasks"></i></div>
                <a href="{{route('todo_list')}}" class="small-box-footer">
                    More Info  <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endif
	</div>
	<div class="row">
		@if(check_permission(Auth::user()->id, 1))
		<div class="col-sm-12">
			<div class="card" style="width: 43rem;">
			  <div class="card-body">
			    <h5 class="card-title">Attendence</h5>
			    <table id="dashAttendenceTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>Name</th>
				<th>Logged On</th>
				</tr>
				</thead>
				<tbody>
				@foreach($data['attendences'] as $attendence)
				<tr>
				@if($attendence['profile_image'] == null)
				<td><img class="rounded-assignee" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $attendence['user_name'] }}">{{ $attendence['user_name'] }} - {{ $attendence['role_name'] }}</td>
				@else
				<?php $profile_image_url = 'public/storage/'.$attendence['profile_image'];?>
				<td><img class="rounded-assignee" src="{{ url($profile_image_url) }}" alt="{{ $attendence['user_name'] }}"> {{ $attendence['user_name'] }} - {{ $attendence['role_name'] }}</td>
				@endif
				<td>{{ $attendence['logged_at'] }}</td>
				</tr>
				@endforeach
				</tbody>
				</table>
			  </div>
			</div>
		</div>
		@endif
		<div class="clearfix"></div>
		@if(check_permission(Auth::user()->id, 2))
		<div class="col-sm-12">
			<div class="panel panel-primary">
		      <div class="panel-heading">Recent Case Updates</div>
		      <div class="panel-body">
		      	<table id="dashCaseTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>Name</th>
				<th>Court</th>
				<th>Next Hearing Date</th>
				<th>Action</th>
				</tr>
				</thead>
				<tbody>
				@foreach($data['cases'] as $case)
				<tr>
				<td>{{ $case['name'] }}</td>
				<td>{{ $case['court_name'] }}</td>
				<td>{{ $case['hearing_date'] }}</td>
				<td>
					<a href="{{route('master.show', ['master' => $case['id'] ])}}" class="btn-link-td"><i class="fa fa-eye"></i>View</a>
				</td>
				</tr>
				@endforeach
				</tbody>
				</table>
		      </div>
		    </div>			
		</div>
		@endif
		<div class="clearfix"></div>
		@if(check_permission(Auth::user()->id, 3))
		<div class="col-sm-12">
			<div class="panel panel-primary">
		      <div class="panel-heading">TODO</div>
		      <div class="panel-body">
		      	<table id="dashTodoTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>Name</th>
				<th>Priority</th>
				<th>Due Date</th>
				</tr>
				</thead>
				<tbody>
				@foreach($data['todos'] as $case)
				<tr>
				<td>{{ $case['name'] }}</td>
<?php
if($case['priority'] == 'low') {
	$priority_html = '<span class="label label-default">'.ucwords($priority).'</span>';
}elseif($case['priority'] == 'medium') {
	$priority_html = '<span class="label label-warning">'.ucwords($priority).'</span>';
}else {
	$priority_html = '<span class="label label-danger">High</span>';
}
?>
				<td><?php echo $priority_html;?></td>
				<td>{{ $case['due_date'] }}</td>
				</tr>
				@endforeach
				</tbody>
				</table>
		      </div>
		    </div>			
		</div>
		@endif
		<div class="clearfix"></div>
		@if(check_permission(Auth::user()->id, 4))
		<div class="col-sm-12">
			<div class="panel panel-primary">
		      <div class="panel-heading">Holiday Lists</div>
		      <div class="panel-body">
		      	<table id="dashHolidayTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>Name</th>
				<th>Holiday Date</th>
				</tr>
				</thead>
				<tbody>
				@foreach($data['holidays'] as $holiday)
				<tr>
				<td>{{ $holiday->name }}</td>
				<td>{{ date('F d, Y', strtotime($holiday->meta_value)) }}</td>
				</tr>
				@endforeach
				</tbody>
				</table>
		      </div>
		    </div>			
		</div>
		@endif
	</div>
</div>
</div>
@endsection
