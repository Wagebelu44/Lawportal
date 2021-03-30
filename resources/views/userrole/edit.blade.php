@extends("userrole.create", ['userforms' => $data['userform']])
@section("userroleId", $data['userrole']->id)
@section("name", $data['userrole']->name)
@section("edit-page-content", 'edit-page-content')
@section("editMethod")
@method('PUT')
@endsection
@section("addnew")
@if(check_permission(Auth::user()->id, 53)) 
<a href="{{ url('/userrole/create') }}" class="btn btn-default">Add New</a>
@endif
@endsection
@section("masterLogs")
<?php
$masterlogs = get_masterlogs($data['userrole']->id);
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