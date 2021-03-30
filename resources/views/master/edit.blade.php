@extends("master.create")
@section("masterId", $data['master']->id)
@section("name", $data['master']->name)
@section("edit-page-content", 'edit-page-content')
@section("addnew")
@if(check_permission(Auth::user()->id, 'master.create', $data['master_type']))
<a href="{{ url('/master/create?master_type='.$data['master_type']) }}" class="btn btn-default">Add New</a>
@endif
@endsection
@section("editMethod")
@method('PUT')
@endsection
@if($data['master_type'] == 'case')
@section("hearingLogs")
<?php $hearing_logs = get_case_hearing_logs($data['master']->id);?>
<section class="page-content edit-page-content" id="masterLog">
	<div class="wrapper">
		<div class="content-box">
			<h3>Hearing Logs</h3>
			<table>
				<thead>
					<tr>
						<th>Hearing Date</th>
						<th>Created By</th>
						<th>Created On</th>
					</tr>
				</thead>
				<tbody>
					@forelse($hearing_logs as $hearing_log)
					<?php $create_by = get_user($hearing_log['create_by']);?>
					<tr>
						<td>{{date('F d, Y', strtotime($hearing_log['hearing_date']))}}</td>
						<td>{{ucwords($create_by->name)}}</td>
						<td>{{date('F d, Y h:i A', strtotime($hearing_log['created_at']))}}</td>
					</tr>
					@empty
					<tr><td colspan="3"><center>No hearings happened yet</center></td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection
@endif
@section("masterLogs")
<?php
$masterlogs = get_masterlogs($data['master']->id);
?>
<section class="page-content edit-page-content" id="masterLog">
	<div class="wrapper">
		<div class="content-box">
			<h3>Last Modifieds</h3>
			<table>
				<thead>
					<tr>
						<th>Modified By</th>
						<th>Modified On</th>
					</tr>
				</thead>
				<tbody>
					@forelse($masterlogs as $masterlog)
					<?php $create_by = get_user($masterlog->create_by);?>
					<tr>
						<td>{{ucwords($create_by->name)}}</td>
						<td>{{date('F d, Y h:i A', strtotime($masterlog->created_at))}}</td>
					</tr>
					@empty
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection