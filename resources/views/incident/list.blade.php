@extends('layouts.master')
@section('title', 'My Incident')
@section('content')
<section class="page-content">
	<div class="wrapper">
		<div class="page-header">
			<h1>My Incident <a href="{{ url('/master/create?master_type=incident') }}" class="btn btn-default">Add New Incident</a></h1>
		</div>
		@if(session()->has('incidentSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('incidentSuccessMsg') }}</p>
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
					@foreach($incidents as $incident)
					<?php
					$created_by = get_user($incident->create_by);
					$due_date = date('F d, Y', strtotime(get_mastermeta($incident->id, 'due_date')));
					?>
					<tr>
						<td><a href="{{url('my_incident/'.$incident->id)}}" class="btn-link-td">{{ $incident->name }}</a></td>
						<?php
						$priority = get_mastermeta($incident->id, 'incident_priority');
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
						<td>
							<?php
								$incident_status = get_mastermeta($incident->id, 'is_completed');
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
						<td>{{ date('F d, Y', strtotime($incident->created_at)) }}</td>
						<td>{{ ucwords($created_by->name) }}</td>
						<td>
							<a href="{{url('my_incident/'.$incident->id)}}" class="btn-link-td"><i class="fa fa-eye"></i>View</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection