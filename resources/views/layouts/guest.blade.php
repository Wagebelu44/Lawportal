@section("site_logo", get_option('site_logo'))
@section("site_favicon", get_option('site_favicon'))
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

<!-- Meta, title, CSS, favicons, etc. -->

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title') - {{ config('app.name', 'KSHETRY AND ASSOCIATES') }}</title>

<!-- Bootstrap core CSS -->

<link href="{{ asset('/public/css/bootstrap.css') }}" rel="stylesheet">

<link href="{{ asset('/public/css/font-awesome.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/public/css/validationEngine.jquery.css') }}" type="text/css"/>

<link href="{{ asset('/public/css/style.css') }}" rel="stylesheet">

<script src="{{ asset('/public/js/ie10-viewport-bug-workaround.js') }}"></script>

<script src="{{ asset('/public/js/ie-emulation-modes-warning.js') }}"></script>

@if(empty($__env->yieldContent('site_favicon')))
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('/public/images/default-logo.ico') }}">
<link rel="shortcut icon" href="{{ asset('/public/images/default-logo.ico') }}">
@else
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('public/storage') }}/@yield('site_favicon')">
<link rel="shortcut icon" href="{{ url('public/storage') }}/@yield('site_favicon')">
@endif

</head>



<body class="intro-bg">



@yield('content')



<script src="{{ asset('/public/js/jquery.min.js') }}"></script>

<script src="{{ asset('/public/js/bootstrap.js') }}"></script>

<script src="{{ asset('/public/js/jquery.validationEngine-en.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/public/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/public/js/hideShowPassword.min.js') }}"></script>

<script>

$('#password').hidePassword(true);

jQuery(document).ready(function(){

	jQuery(".guestForm").validationEngine('attach', {promptPosition : "bottomLeft", autoPositionUpdate : true});

});



</script>

</body>

</html>

