@extends('layouts.master')
@section('title', ucfirst($data['evaluation']->name).' - Evaluation')
@section('content')
<section class="page-content  @yield('edit-page-content')">
	<div class="wrapper">
		<div class="page-header">
			<h1>{{ucfirst($data['evaluation']->name)}} </h1>
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
		@if(session()->has('evaluationSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('evaluationSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('evaluationErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('evaluationErrorMsg') }}</p>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="clearfix"></div>
				<div class="col-sm-2">Deadline</div>
				<div class="col-sm-10">
					{{ date('F d, Y', strtotime(get_mastermeta($data['evaluation']->id, 'deadline'))) }}
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-2">Assigned to</div>
				<div class="col-sm-10">
					<?php
							$user = get_user(get_mastermeta($data['evaluation']->id, 'assignee_id'));
							$profile_image = get_usermeta($user->id, '_profile_image');
							$role_id = get_usermeta($user->id, '_userrole_id');
							$role_name = '';
							if($role_id) {
								$user_role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
								$role_name = $user_role->name;
							}
						if($profile_image == null) :
					?>
					<img class="rounded-assignee" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $user->name .' - '.$role_name }}" data-toggle="tooltip" title="{{ $user->name .' - '.$role_name }}">
					<?php else :
							$profile_image_url = 'public/storage/'.$profile_image;
					?>
					<img class="rounded-assignee" src="{{ url($profile_image_url) }}" alt="{{ $user->name .' - '.$role_name }}" data-toggle="tooltip" title="{{ $user->name .' - '.$role_name }}">
					<?php endif;?>
				</div>
				<div class="clearfix"></div>
				@if(isset($data['evaluation_weight']) && !empty($data['evaluation_weight']))
				<div class="col-sm-2">Weight</div>
				<div class="col-sm-10"><?php echo $data['evaluation_weight']; ?>%</div>
				@endif
			</div>
		</div>
		<?php
		$is_reviewed = [];
		?>
		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 form-group">
					<h4>Objectives</h4>
					<div class="table-responsive">
						<form method="post" action="{{url('/evaluation/'.$data['evaluation']->id)}}" class="formular adminForm" autocomplete="off">
							@csrf
							<table class="table table-striped" id="objective_table">
								<thead>
									<tr>
										<th>Objective</th>
										<th>Weightage</th>
										<th>Employee Comment</th>
										<th>Reviewer Comment</th>
										<th>Actual Score</th>
									</tr>
								</thead>
								<tbody>
									@forelse($data['objectives'] as $objective)
									<tr>
										<td>
											{{$objective->objective}}
										</td>
										<td>
											{{$objective->weightage}}
										</td>
										<td>
											@if(Auth::user()->id == $user->id)
											@if(empty($objective->reviewer_comment))
											<?php array_push($is_reviewed, 0); ?>
											@if(check_permission(Auth::user()->id, 'evaluation_review'))
											<textarea name="employee_comment[{{$objective->id}}]">{{$objective->employee_comment}}</textarea>
											@endif
											@else
											{{$objective->employee_comment}}
											<?php array_push($is_reviewed, 1); ?>
											@endif
											@endif
										</td>
										<td>
											{{$objective->reviewer_comment}}
										</td>
										<td>
											{{$objective->score}}
										</td>
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
							@if(Auth::user()->id == $user->id)
							@if(in_array(0, $is_reviewed))
							@if(check_permission(Auth::user()->id, 'evaluation_review'))
							<div class="col-sm-12">
								<input type="submit" value="Submit" class="btn btn-primary">
							</div>
							@endif
							@endif
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection