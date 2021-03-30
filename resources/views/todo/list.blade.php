@extends('layouts.master')
@section('title', 'My TODO')
@section('content')
<section class="page-content">
	<div class="wrapper">
		<div class="page-header">
			<h1>My TODO <a href="{{ url('/master/create?master_type=todo') }}" class="btn btn-default">Add New TODO</a></h1>
		</div>
		@if(session()->has('todoSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('todoSuccessMsg') }}</p>
		</div>
		@endif
		<div class="item-wrap item-list-table">
			<table id="dataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Title</th>
						<th>Priority</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Created By</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($todos as $todo)
					<?php
					$created_by = get_user($todo->create_by);
					$due_date = date('F d, Y', strtotime(get_mastermeta($todo->id, 'due_date')));
					?>
					<tr>
						<td><a href="{{url('my_todo/'.$todo->id)}}" class="btn-link-td">{{ $todo->name }}</a></td>
						<?php
						$priority = get_mastermeta($todo->id, 'todo_priority');
						if($priority == 'low') {
							$priority_html = '<span class="label label-default">'.ucwords($priority).'</span>';
						}elseif($priority == 'medium') {
							$priority_html = '<span class="label label-warning">'.ucwords($priority).'</span>';
						}else {
							$priority_html = '<span class="label label-danger">High</span>';
						}
						?>
						<td><?php echo $priority_html;?></td>
						<td>{{ $due_date }}</td>
						<td>{{ get_mastermeta($todo->id, 'is_completed') == 0 ? 'Open' : 'Closed' }}</td>
						<td>{{ date('F d, Y', strtotime($todo->created_at)) }}</td>
						<td>{{ ucwords($created_by->name) }}</td>
						<td>
							<a href="{{url('my_todo/'.$todo->id)}}" class="btn-link-td"><i class="fa fa-eye"></i>View</a>
							@if(check_permission(Auth::user()->id, 47))
							<button type="button"
							class="btn-link-td"
							onclick="event.preventDefault();
							document.getElementById('close-form-{{$todo->id}}').submit();">
							<i class="fa {{ get_mastermeta($todo->id, 'is_completed') == 0 ? 'fa-times' : 'fa fa-folder-open' }}"></i>{{ get_mastermeta($todo->id, 'is_completed') == 0 ? 'Close TODO' : 'Open TODO' }}
							</button>
							<form id="close-form-{{$todo->id}}" action="{{url('todo')}}/{{$todo->id}}" method="POST" style="display: none;">
								@csrf
								@method('PUT')
							</form>
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