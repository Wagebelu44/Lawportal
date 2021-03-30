@extends('layouts.guest')

@section('title', 'Forgot Password')
@section("site_logo", get_option('site_logo'))
@section("site_favicon", get_option('site_favicon'))
@section('content')
<div class="auth-container">
<div class="card">
<header class="auth-header">
	@if(empty($__env->yieldContent('site_logo')))
    <img src="{{ asset('/public/images/default-logo.jpg') }}">
    @else
    <img src="{{ url('public/storage') }}/@yield('site_logo')">
    @endif
</header>
<div class="auth-content">
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@error('email')
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@enderror
<p class="text-muted text-center"><small>Enter your email address to reset your password.</small></p>
<form method="post" action="{{ route('password.email') }}" id="forgotForm" class="formular guestForm">
@csrf
<div class="form-group"> 
<label for="email1">Email</label> 
<input type="text" class="form-control validate[required],custom[email]] text-input" name="email" id="email"></div>
<div class="form-group"> <button class="btn btn-block btn-primary" type="submit">Reset</button> </div>
<div class="form-group clearfix text-center"> <a href="{{url('/login')}}">Return to Login</a></div>
</form>
</div>
</div>
</div>
@endsection
