@extends('layouts.guest')

@section('title', 'Reset Password')
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
    <div class="alert alert-error" role="alert">
        {{ $message }}
    </div>
@enderror

@error('password')
    <div class="alert alert-error" role="alert">
        {{ $message }}
    </div>
@enderror
<form method="post" action="{{ route('password.update') }}" id="resetForm" class="formular guestForm">
@csrf
<input type="hidden" name="token" value="{{ $token }}">
<div class="form-group"> 
<label for="email1">Email</label> 
<input type="text" class="form-control validate[required],custom[email]] text-input" name="email" id="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
</div>
<div class="form-group"> 
<label for="password">Password</label> 
<input type="password" class="form-control validate[required] text-input login-field login-field-password" id="password" name="password" required autocomplete="new-password">
</div>
<div class="form-group"> 
<label for="password">Confirm Password</label> 
<input type="password" class="form-control validate[required,equals[password]] text-input login-field login-field-password" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
</div>
<div class="form-group"> <button class="btn btn-block btn-primary" type="submit">Reset Password</button> </div>
</form>
</div>
</div>
</div>
@endsection
