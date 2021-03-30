@extends('layouts.master')
<?php $masters = get_master_slugs();?>
@if(isset($data['master']->master_type))
@section('title', 'Send Email')
@section('content')
<?php
$user_role = get_usermeta(Auth::user()->id, '_userrole_id');
?>
<div class="col-lg-8 col-md-7">
	<div class="form-block">
		<div class="page-header">
			<h1>Send Email</h1>
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
		@if(session()->has('emailSuccessMsg'))
		<div class="alert alert-success" role="alert">
			<p>{{ session()->get('emailSuccessMsg') }}</p>
		</div>
		@endif
		@if(session()->has('emailErrorMsg'))
		<div class="alert alert-danger" role="alert">
			<p>{{ session()->get('emailErrorMsg') }}</p>
		</div>
		@endif

		<div class="content-box">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form method="post" action="{{route('post.email', ['id' => $data['master']->id ])}}" id="MasterForm" class="formular adminForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<label class="col-sm-2 label-lg">Subject </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control validate[required] text-input" name="subject" id="subject" value="{{isset($data['subject']) ? $data['subject'] : old('subject')}}"></div>
							<label class="col-sm-2 label-lg">Cc </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control text-input" name="cc" id="cc" value="{{isset($data['cc']) ? $data['cc'] : old('cc')}}"></div>
							<label class="col-sm-2 label-lg">Bcc </label>
							<div class="col-sm-10 form-group"><input type="text" class="form-control text-input" name="bcc" id="bcc" value="{{isset($data['bcc']) ? $data['bcc'] : old('bcc')}}"></div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Attachments</label>
							<div class="col-sm-10"><input type="file" name="attachment[]" class="filer_input" multiple></div>
							<div class="clearfix"></div>
							<label class="col-sm-2 label-lg">Message</label>
							<div class="col-sm-10 form-group">
								<textarea name="message" id="messageEditor"></textarea>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-10 col-sm-offset-2"><input type="submit" value="Send" class="btn btn-primary"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/public/js/ckeditor/ckeditor.js') }}" ></script>
<script type="text/javascript">
CKEDITOR.replace( 'messageEditor', {
	filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}"
});
</script>
@endsection
@endif