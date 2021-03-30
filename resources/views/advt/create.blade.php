@extends('layouts.master')



@section('title', ucfirst(substr(Route::currentRouteName(), 5)).' ADVT')



@section('content')



<section class="page-content  @yield('edit-page-content')">

<div class="wrapper">

<div class="page-header">

<h1>{{ucfirst(substr(Route::currentRouteName(), 5))}} ADVT</h1>

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



@if(session()->has('advtSuccessMsg'))

<div class="alert alert-success" role="alert">

	<p>{{ session()->get('advtSuccessMsg') }}</p>

</div>

@endif



@if(session()->has('advtErrorMsg'))

<div class="alert alert-danger" role="alert">

	<p>{{ session()->get('advtErrorMsg') }}</p>

</div>

@endif



<div class="content-box">

<div class="row">

<div class="col-sm-12 col-md-10 col-lg-8">

<form method="post" action="{{url('/advt')}}<?php if($__env->yieldContent('advtId')) { echo '/'.$__env->yieldContent('advtId');} ?>" id="LawClerkForm" class="formular adminForm" autocomplete="off" enctype="multipart/form-data">

@csrf

@section("editMethod")

@show

<div class="row">

<label class="col-sm-3 label-lg">Name </label>

<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required] text-input" name="name" id="name" value="<?php if($__env->yieldContent('name')) { echo $__env->yieldContent('name');}else { echo old('name');} ?>"></div>

<label class="col-sm-3 label-lg">Email Address </label>

<div class="col-sm-9 form-group"><input type="text" class="form-control validate[required],custom[email]] text-input" name="email" id="email" value="<?php if($__env->yieldContent('email')) { echo $__env->yieldContent('email');}else { echo old('email');} ?>"></div>

<label class="col-sm-3 label-lg">Image</label>

<div class="col-sm-9  form-group clearfix profile-img">

<div class="avatar-img pull-left">

@if($__env->yieldContent('profile_image') == null)

	<img src="{{ asset('/public/images/default-user.jpg') }}" alt="user profile image">

@else

	<img src="{{ url('public/storage') }}/@yield('profile_image')" alt="user profile image">

@endif

</div>

<div class="fileUpload btn btn-default btn-xs pull-left">

<span>Upload image</span>

<input type="file" class="upload" name="profile_image" />

</div>

</div>

<div class="col-sm-9 col-sm-offset-3"><input type="submit" value="Submit" class="btn btn-primary"></div>

</div>

</form>                        

</div>

</div>

</div>

</div>

</section>



@section("masterLogs")

@show



@endsection