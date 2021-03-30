@extends('layouts.master')
<?php $masters = get_master_slugs();?>
@if(isset($data['master']->master_type))
@section('title', 'Send SMS')
@section('content')
<?php
$user_role = get_usermeta(Auth::user()->id, '_userrole_id');
?>
<div class="col-lg-8 col-md-7">
	<div class="form-block">
		<div class="page-header">
			<h1>Send SMS</h1>
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
		@if(session()->has('smsSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('smsSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('smsErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('smsErrorMsg') }}</p>
		</div>
		@endif

		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{route('post.sms', ['id' => $data['master']->id ])}}" id="MasterForm" class="formular adminForm" autocomplete="off">
						@csrf
						<div class="row">
							<label class="col-sm-2 label-lg">Message</label>
							<div class="col-sm-10 form-group">
								<textarea name="message" class="form-control"></textarea>
							</div>
							<div class="clearfix"></div>
							<!-- <div class="col-sm-10 col-sm-offset-2"><input type="submit" value="Send" class="btn btn-primary"></div> -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@endif