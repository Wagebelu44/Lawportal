@extends('layouts.master')
@section('title', ucfirst($data['todo']->name).' - My TODO')
@section('content')
<section class="page-content  @yield('edit-page-content')">
	<div class="wrapper">
		<div class="page-header">
			<h1>{{ucfirst($data['todo']->name)}} 
				@if(check_permission(Auth::user()->id, 32)) 
				<a href="{{ url('/master/'.$data['todo']->id.'/edit') }}" class="btn btn-default">Edit</a>
				@endif
			</h1>
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
		@if(session()->has('todoSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('todoSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('todoErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('todoErrorMsg') }}</p>
		</div>
		@endif
		<div class="content-box">
			<div class="row">
				<div class="col-sm-2">Priority</div>
				<div class="col-sm-10">
					<?php
					$priority = get_mastermeta($data['todo']->id, 'todo_priority');
					if($priority == 'low') {
						$priority_html = '<span class="label label-default">'.ucwords($priority).'</span>';
					}elseif($priority == 'medium') {
						$priority_html = '<span class="label label-warning">'.ucwords($priority).'</span>';
					}else {
						$priority_html = '<span class="label label-danger">High</span>';
					}
					?>
					<?php echo $priority_html;?>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-2">Due Date</div>
				<div class="col-sm-10">
					{{ date('F d, Y', strtotime(get_mastermeta($data['todo']->id, 'due_date'))) }}
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-2">Assigned to</div>
				<div class="col-sm-10">
					<?php
						foreach ($data['todoassignees'] as $todoassignee) :
							$user = get_user($todoassignee->user_id);
							$profile_image = get_usermeta($todoassignee->user_id, '_profile_image');
							$role_id = get_usermeta($todoassignee->user_id, '_userrole_id');
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
					<?php endif;
						endforeach;
					?>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-2">Status</div>
				<div class="col-sm-10">{{ get_mastermeta($data['todo']->id, 'is_completed') == 0 ? 'Open' : 'Closed' }}</div>
				<div class="clearfix"></div>
				@if(get_mastermeta($data['todo']->id, 'is_completed') == 1)
				<div class="col-sm-2">Closed By</div>
				<?php
				$closed_by = get_mastermeta($data['todo']->id, 'closed_by');
				$closed_by_user = get_user($closed_by);
				?>
				<div class="col-sm-10">{{ $closed_by_user->name }}</div>
				<div class="clearfix"></div>
				<div class="col-sm-2">Closed On</div>
				<div class="col-sm-10">{{ date('F d, Y h:i A', strtotime(get_mastermeta($data['todo']->id, 'closed_on'))) }}</div>
				<div class="clearfix"></div>
				@endif
				<div class="col-sm-2">TODO Description</div>
				<div class="col-sm-10"><?php echo get_mastermeta($data['todo']->id, 'todo_description'); ?></div>
			</div>
		</div>
		@forelse($data['comments'] as $comment)
		<div class="content-box">
			<div class="row">
				<div class="col-sm-3">
					<?php
						$user = get_user($comment->create_by);
						$profile_image = get_usermeta($comment->create_by, '_profile_image');
						$role_id = get_usermeta($comment->create_by, '_userrole_id');
						$role_name = '';
						if($role_id) {
							$user_role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
							$role_name = $user_role->name;
						}
					if($profile_image == null) :
					?>
					<img class="rounded-comment-assignee" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $user->name .' - '.$role_name }}" data-toggle="tooltip" title="{{ $user->name .' - '.$role_name }}">
					<?php else :
							$profile_image_url = 'public/storage/'.$profile_image;
					?>
					<img class="rounded-comment-assignee" src="{{ url($profile_image_url) }}" alt="{{ $user->name .' - '.$role_name }}" data-toggle="tooltip" title="{{ $user->name .' - '.$role_name }}">
					<?php endif;?>
					<p>{{ $user->name .' - '.$role_name }}</p>
					<p>{{ date('M j, Y g:i A', strtotime($comment->updated_at)) }}</p>
				</div>
				<div class="col-sm-9">
					@if(get_mastermeta($data['todo']->id, 'is_completed') == 0)
					@if($comment->create_by == Auth::user()->id)
					<div class="comment-action">
						@if(check_permission(Auth::user()->id, 48))
						<i class="fa fa-pencil edit_comment" data-id="{{$comment->id}}"></i>
						<i class="fa fa-trash"
						onclick="event.preventDefault();
						document.getElementById('delete-comment-form-{{$comment->id}}').submit();"></i>
						<form id="delete-comment-form-{{$comment->id}}" action="{{(url('todo_comment'))}}/{{$comment->id}}" method="POST" style="display: none;">
							@csrf
							@method('DELETE')
						</form>
						@endif
					</div>
					@endif
					@endif
					<div class="comment-part">
						<?php
							$todo_comment = get_mastermeta($comment->id, '_comment');
							if($todo_comment) {
								echo $todo_comment;
							}
						?>
					</div>
				</div>
			</div>
		</div>
		@empty
		@endforelse
		@if(get_mastermeta($data['todo']->id, 'is_completed') == 0)
		@if(check_permission(Auth::user()->id, 48))
		<div class="content-box">
			<div class="row">
				<h3>Add Comment</h3>
				<form method="post" action="{{url('/todo_comment/'.Request::segment(2))}}" class="formular adminForm" autocomplete="off">
					@csrf
					<textarea name="todo_comment" id="todoCommentEditor"></textarea>
					<input type="submit" value="Submit" class="btn btn-primary pull-right">
				</form>
			</div>
		</div>
		@endif
		@endif
	</div>
</section>
@if(get_mastermeta($data['todo']->id, 'is_completed') == 0)
<script src="{{ asset('/public/js/ckeditor/ckeditor.js') }}" ></script>
<script type="text/javascript">
(function() {
	CKEDITOR.replace( 'todoCommentEditor', {
		filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
	});
	//alert(1234)
	$('.edit_comment').on('click', function(e) {
		e.preventDefault();
		let comment = $(this).parent().parent().find('.comment-part').html();
		let comment_id = $(this).attr('data-id');
		$(this).parent().parent().find('.comment-part').html(`<form method="post" action="{{url('/todo_comment')}}/${comment_id}" class="formular adminForm" autocomplete="off">
				@csrf
				@method('PUT')
				<textarea name="todo_old_comment" id="todoOldCommentEditor${comment_id}"></textarea>
				<input type="submit" value="Submit" class="btn btn-primary pull-right">
		</form>`);
		CKEDITOR.replace( `todoOldCommentEditor${comment_id}`, {
			filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
		});
		CKEDITOR.instances[`todoOldCommentEditor${comment_id}`].setData(comment);
	})
})()
</script>
@endif
@endsection