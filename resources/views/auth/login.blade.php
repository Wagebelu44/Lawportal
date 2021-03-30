@extends('layouts.guest')

@section('title', 'Login')
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
@if(session()->has('loginErrorMsg'))
<div class="alert alert-danger" role="alert">
	<p>{{ session()->get('loginErrorMsg') }}</p>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" role="alert">
<ul>
@foreach($errors->all() as $error)
  <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{url('/auth_check')}}" id="loginForm" class="formular guestForm">
@csrf
<div class="form-group">
<label for="username">Username</label> 
<input type="username" class="validate[required] text-input form-control" name="username" id="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
</div>
<div class="form-group"> 
<label for="password">Password</label> 
<input type="password" class="form-control validate[required] text-input login-field login-field-password" id="password" name="password" required autocomplete="current-password">
</div>
<div class="form-group"> 

@if (Route::has('password.request'))
    <a class="forgot-btn pull-right" href="{{ route('password.request') }}">
        Forgot password?
    </a>
@endif
</div>
<div class="form-group"> <button type="submit" class="btn btn-block btn-primary">Login</button> </div>

</form>
</div>
</div>
</div>

@endsection
