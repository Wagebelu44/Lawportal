@extends("advt.create")

@section("advtId", $advt->id)

@section("name", $advt->name)

@section("edit-page-content", 'edit-page-content')

<?php 
	$email = get_mastermeta($advt->id, 'email');
	$profile_image = get_mastermeta($advt->id, '_profile_image');
?>

@section("email", $email)
@section("profile_image", $profile_image)

@section("editMethod")
@method('PUT')
@endsection

@section("masterLogs")
<?php
$masterlogs = get_masterlogs($advt->id);
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