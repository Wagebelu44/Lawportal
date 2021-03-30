<?php
$masters = get_master_slugs();
unset($masters['case_category']);
unset($masters['file_location']);
unset($masters['holiday']);
?>
@section("site_logo", get_option('site_logo'))
@section("site_favicon", get_option('site_favicon'))
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user-id" content="{{ Auth::check() ? Auth::user()->id : '' }}">
        <title>@yield('title') - {{ empty(get_option('site_name')) ? 'Alphaxine' : get_option('site_name') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <link href="{{ asset('/public/css/bootstrap.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
        <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="{{ asset('/public/css/external.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/css/style.css') }}?v=1.5.0" rel="stylesheet">
        <link href="{{ asset('/public/css/waitMe.min.css') }}" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="{{ asset('/public/js/html5shiv.min.js') }}"></script>
        <![endif]-->
        @if(empty($__env->yieldContent('site_favicon')))
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('/public/images/default-logo.ico') }}">
        <link rel="shortcut icon" href="{{ asset('/public/images/default-logo.ico') }}">
        @else
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('public/storage') }}/@yield('site_favicon')">
        <link rel="shortcut icon" href="{{ url('public/storage') }}/@yield('site_favicon')">
        @endif
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

        <script>
            var fileThumbUrl = `{{ asset('public/images/file.png') }}`;
            var masterType = `{{ isset($data['master_type']) ? $data['master_type'] : '' }}`;
            var base_url = `{{URL::to('/')}}`;
            var currentRoute = `{{Route::currentRouteName()}}`;
            var officeEndTimeHour = `{{empty(get_option('office_end')) ? '' : date('H', strtotime(get_option('office_end')))}}`;
            var officeEndTimeMin = `{{empty(get_option('office_end')) ? '' : date('i', strtotime(get_option('office_end')))}}`;

        </script>
        @if(Route::currentRouteName() == 'upload.excel.index')
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/http_ajax.googleapis.com_ajax_libs_jquery_3.2.1_jquery.min.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/http_cdnjs.cloudflare.com_ajax_libs_popper.js_1.12.6_umd_popper.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/http_maxcdn.bootstrapcdn.com_bootstrap_4.0.0-beta.2_js_bootstrap.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/http_unpkg.com_sweetalert_dist_sweetalert.min.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/http_rawgit.com_eligrey_FileSaver.js_master_FileSaver.js') }}" ></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js" ></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js" ></script>
        <script type="text/javascript" src="{{ asset('/public/js/excel-upload/excel_uploader.js') }}" ></script>
        @else
        <script type="text/javascript" src="{{ asset('/public/js/jquery.min.js') }}" ></script>
        <script src="{{ asset('/public/js/bootstrap.min.js') }}" ></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        @endif
    </head>
    <body>
        <header class="header">
            <ul class="header-link">
                <li><a href="#" class="toogle-btn" id="menu-toggle" >
                        <span aria-hidden="true" class="glyphicon glyphicon-menu-hamburger"></span>
                        <span aria-hidden="true" class="glyphicon glyphicon-remove-circle"></span>
                    </a></li>
                <li><a href="{{ url('/') }}"><span aria-hidden="true" class="glyphicon glyphicon-home"></span><strong>{{ empty(get_option('site_name')) ? 'Alphaxine Admin' : get_option('site_name') }}</strong></a></li>
            </ul>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php $my_profile_image = get_usermeta(Auth::user()->id, '_profile_image'); ?>
                    @if($my_profile_image == null)
                    <td><img src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ Auth::user()->name }}"></td>
                    @else
                    <?php $my_profile_image_url = 'public/storage/' . $my_profile_image; ?>
                    <td><img src="{{ url($my_profile_image_url) }}" alt="{{ Auth::user()->name }}"></td>
                    @endif
                    Welcome {{ Auth::user()->name }} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/profile')}}"><i class="fa fa-user"></i>My Profile</a></li>
                    @if(check_permission(Auth::user()->id, 'todo_list'))
                    <li><a href="{{url('/my_todo_list')}}"><i class="fa fa-tasks"></i>My TODO</a></li>
                    @endif
                    @if(check_permission(Auth::user()->id, 'incident_list'))
                    <li><a href="{{url('/my_incident_list')}}"><i class="fa fa-tasks"></i>My Incident</a></li>
                    @endif
                    @if(check_permission(Auth::user()->id, 'user_evaluation'))
                    <li><a href="{{url('/my_evaluation')}}"><i class="fa fa-tasks"></i>My Assessment</a></li>
                    @endif
                    <li>
                        <a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-light" id="noti_count">
                        @if(Auth::user()->unreadNotifications->count() > 0)
                        {{Auth::user()->unreadNotifications->count()}}
                        @else
                        0
                        @endif
                    </span><span class="caret"></span>
                </button>
                <ul class="dropdown-menu notify" id="noti_list">
                    @if(Auth::user()->unreadNotifications->count() > 0)
                    @foreach(Auth::user()->unreadNotifications as $notification)
                    <li><a href="{{$notification->data['letter']['link']}}">{{$notification->data['letter']['title']}}<br>{{$notification->data['letter']['body']}}</a></li>
                    @endforeach
                    <li><a href="{{route('markAsRead')}}">Mark As Read</a></li>
                    @else
                    <li><a href="javascript:void(0);">You have no notifications</a></li>
                    @endif
                </ul>
            </div>
        </header>
        <aside id="page-sidebar">
            <nav class=" sidebar-menu">
                <ul>
                    <li><a href="{{ url('/') }}"><span class="nav-parent-list"><i class="fa fa-dashboard"></i>Dashboard</span></a></li>
                    @if(check_permission(Auth::user()->id, 'user.index') || check_permission(Auth::user()->id, 'userrole.index') || check_permission(Auth::user()->id, 'attendence') || check_permission(Auth::user()->id, 'master.index', 'holiday'))
                    <li class="<?php
                    if (Request::segment(1) == 'user' || Request::segment(1) == 'userrole' || Request::segment(1) == 'user_attendence' || (isset($_GET['master_type']) && $_GET['master_type'] == 'holiday')) {
                        echo 'active';
                    }
                    ?>"><a href="javascript:void();"><span class="nav-parent-list"><i class="fa fa-th-large"></i>HR Management</span></a>
                        <ul <?php
                        if (Request::segment(1) == 'user' || Request::segment(1) == 'userrole' || Request::segment(1) == 'user_attendence' || (isset($_GET['master_type']) && $_GET['master_type'] == 'holiday')) {
                            echo 'style=display:block';
                        }
                        ?>>
                            @if(check_permission(Auth::user()->id, 'user.index'))
                            <li><a href="{{ url('/user') }}?userrole_id=2">Client</a></li>
                            @endif
                            @if(check_permission(Auth::user()->id, 'user.index'))
                            <li><a href="{{ url('/user') }}?userrole_id=18">Associates</a></li>
                            @endif
                            @if(check_permission(Auth::user()->id, 'user.index'))
                            <li><a href="{{ url('/user') }}">Employees</a></li>
                            @endif
                            @if(check_permission(Auth::user()->id, 'userrole.index'))
                            <li><a href="{{ url('/userrole') }}">User Role</a></li>
                            @endif
                            @if(check_permission(Auth::user()->id, 'master.index', 'holiday'))
                            <li><a href="{{ url('/master?master_type=holiday') }}">Holidays</a></li>
                            @endif
                            @if(check_permission(Auth::user()->id, 'attendence'))
                            <li><a href="{{ url('/user_attendence') }}"><span class="nav-parent-list">Attendence</span></a></li>
                            @endif
                        </ul>
                        @endif
                        @foreach($masters as $key => $master)
                        @if(check_permission(Auth::user()->id, 'master.index', $key))
                    <li class="<?php
                    if (isset($_GET['master_type']) && $_GET['master_type'] == $key) {
                        echo 'active';
                    }
                    ?>"><a href="{{
                        $key == 'revision' ? url('/master?master_type='.$key) : 'javascript:void(0);' }}"><span class="nav-parent-list"><i class="fa fa-th-large"></i>{{
                                $key == 'revision' ? $master : 'Manage '.$master }}</span></a>
                        @if($key != 'revision')
                        <ul <?php
                        if (isset($_GET['master_type']) && $_GET['master_type'] == $key) {
                            echo 'style="display: block"';
                        }
                        ?>>
                            <li><a href="{{ url('/master?master_type='.$key) }}">{{$master}} List</a></li>
                            @if(check_permission(Auth::user()->id, 'master.create', $key))
                            <li><a href="{{ url('/master/create?master_type='.$key) }}">Add {{$master}}</a></li>
                            @endif
                            @if($key == 'case')
                            @if(check_permission(Auth::user()->id, 'master.index', 'case_category'))
                            <li><a href="{{ url('/master?master_type=case_category') }}">Categories</a></li>
                            @endif
                            @endif

                            @if($key == 'file_manager')
                            @if(check_permission(Auth::user()->id, 'master.index', 'file_location'))
                            <li><a href="{{ url('/master?master_type=file_location') }}">Locations</a></li>
                            @endif
                            @endif
                        </ul>
                        @endif
                    </li>
                    @endif
                    @endforeach
                    @if(check_permission(Auth::user()->id, 'option.index') && check_permission(Auth::user()->id, 'option.update'))
                    <li><a href="{{ url('/settings') }}"><span class="nav-parent-list"><i class="fa fa-th-large"></i>Site Settings</span></a></li>
                    @endif
                </ul>
            </nav>
        </aside>
        <a class="btn btn-primary footer_logout" 
           onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            &nbsp;Logout</a>
        @yield('content')
        <footer class="footer">{!! empty(get_option('site_name')) ? '&copy; Copyright and All Reserved by Alphaxine' : get_option('site_copyright') !!}</footer>
        <!-- Bootstrap core JavaScript================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script type='text/javascript' src="{{ asset('/public/js/jquery-ui.js') }}" ></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" ></script> -->
        <script type="text/javascript" src="{{ asset('/public/js/jquery.filer.js') }}" ></script>
        <script src="{{ asset('/public/js/jquery.validationEngine-en.js') }}"  type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('/public/js/jquery.validationEngine.js') }}"  type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('/public/js/jquery.dataTables.min.js') }}" ></script>
        <script src="{{ asset('/public/js/dataTables.bootstrap.min.js') }}" ></script>
        <script src="{{ asset('/public/js/dataTables.responsive.js') }}" ></script>
        <script src="{{ asset('/public/js/hideShowPassword.min.js') }}" ></script>
        <script src="{{ asset('/public/js/jquery.mCustomScrollbar.concat.min.js') }}" ></script>
        <script language="javascript" src="{{ asset('/public/js/jquery.pwdMeter.js') }}" ></script>
        <script src="{{ asset('/public/js/clipboard.min.js') }}" ></script>
        <script src="{{ asset('/public/js/trigger.js') }}" ></script>
        <script src="{{ asset('/public/js/tooltips.js') }}" ></script>
        <script src="{{ asset('/public/js/waitMe.min.js') }}" ></script>
        <script src="{{ asset('/public/js/jquery.mask.min.js') }}" ></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
        <script src="{{ asset('/public/js/custom.js') }}?v=1.5.0" ></script>
        <script src="{{ asset('/public/js/app.js') }}"></script>
        <script>
               $('input[type="password"]').hidePassword(true);
               var clipboard = new Clipboard('.btn');
               clipboard.on('success', function (e) {
                   console.log(e);
               });
               clipboard.on('error', function (e) {
                   console.log(e);
               });
        </script>
