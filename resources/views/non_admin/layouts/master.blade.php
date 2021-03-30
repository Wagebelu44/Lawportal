<?php
$masters = get_master_slugs();
unset($masters['case_category']);
unset($masters['file_location']);
unset($masters['holiday']);
$my_profile_image = get_usermeta(Auth::user()->id, '_profile_image');
$user_role = get_usermeta(Auth::user()->id, '_userrole_id');
?>
@section("site_logo", get_option('site_logo'))
@section("site_favicon", get_option('site_favicon'))
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::check() ? Auth::user()->id : '' }}">
    <title>@yield('title') - {{ empty(get_option('site_name')) ? 'Alphaxine Admin' : get_option('site_name') }}</title>
    <!--[if lt IE 9]><script src="{{ asset('/public/non_admin/js/html5shiv.min.js') }}"></script><![endif]-->
    @if(empty($__env->yieldContent('site_favicon')))
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('/public/images/default-logo.ico') }}">
      <link rel="shortcut icon" href="{{ asset('/public/images/default-logo.ico') }}">
    @else
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('public/storage') }}/@yield('site_favicon')">
      <link rel="shortcut icon" href="{{ url('public/storage') }}/@yield('site_favicon')">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('/public/non_admin/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/non_admin/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/non_admin/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/non_admin/css/style.css') }}?v=1.5.0" rel="stylesheet"> 
    <link href="{{ asset('/public/non_admin/css/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/non_admin/css/jquery.filer.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/waitMe.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script type="text/javascript" src="{{ asset('/public/js/jquery.min.js') }}" ></script>
    <script>
    var fileThumbUrl = `{{ asset('public/images/file.png') }}`;
    var masterType = `{{ isset($data['master_type']) ? $data['master_type'] : '' }}`;
    var base_url = `{{URL::to('/')}}`;
    var currentRoute = `{{Route::currentRouteName()}}`;
    var officeEndTimeHour = `{{empty(get_option('office_end')) ? '' : date('H', strtotime(get_option('office_end')))}}`;
    var officeEndTimeMin = `{{empty(get_option('office_end')) ? '' : date('i', strtotime(get_option('office_end')))}}`;
    </script>
  </head>
  <body>
    <header class="header">
      <div class="container clearfix">
        <div class="logo"><a href="#"><img src="{{ asset('/public/non_admin/images/logo.png') }}" alt=""></a></div>
        <div class="user-block">
          <a data-toggle="collapse" href="#collapseAcc" role="button" aria-expanded="false" >
            @if($my_profile_image == null)
            <img src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ Auth::user()->name }}">
            @else
            <?php $my_profile_image_url = 'public/storage/'.$my_profile_image;?>
            <img src="{{ url($my_profile_image_url) }}" alt="{{ Auth::user()->name }}">
            @endif
            
          </a>
        </div>
        <a class="notification" data-toggle="collapse" href="#collapseNoti" role="button" aria-expanded="false">
          <i class="fas fa-bell"></i>
          <span>
            @if(Auth::user()->unreadNotifications->count() > 0)
            {{Auth::user()->unreadNotifications->count()}}
            @else
            0
            @endif
          </span>
        </a>
        <div class="header-collapse link-collapse">
          <div class="collapse" id="collapseAcc">
            <div class="card card-body">
              <ul>
                <li><a href="{{url('/profile')}}">My Profile</a></li>
                @if(check_permission(Auth::user()->id, 'todo_list'))
                <li><a href="{{url('/my_todo_list')}}">My TODO</a></li>
                @endif
                @if(check_permission(Auth::user()->id, 'incident_list'))
                <li><a href="{{url('/my_incident_list')}}">My Incident</a></li>
                @endif
                @if(check_permission(Auth::user()->id, 'user_evaluation'))
                <li><a href="{{url('/my_evaluation')}}">My Assessment</a></li>
                @endif
                <li>
                  <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="header-collapse notification-collapse">
          <div class="collapse" id="collapseNoti">
            <div class="card card-body">
              <ul>
                @if(Auth::user()->unreadNotifications->count() > 0)
                @foreach(Auth::user()->unreadNotifications as $notification)
                <li>
                  <a href="{{$notification->data['letter']['link']}}">
                    <strong>{{$notification->data['letter']['title']}}</strong>
                    <small> {{$notification->data['letter']['body']}}</small>
                  </a>
                </li>
                @endforeach
                <li><a href="{{route('markAsRead')}}">Mark As Read</a></li>
                @else
                <li><a href="javascript:void(0);">You have no notifications</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-5">
            <div class="sidebar">
              <div class="profile-info">
                <div class="profile-image">
                  <div class="upload-btn-wrapper"><button class="upload-btn">Upload a file</button><input type="file" name="profile_img"  accept=".gif,.jpg,.jpeg,.png" /></div>
                  @if($my_profile_image == null)
                  <img src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ Auth::user()->name }}">
                  @else
                  <?php $my_profile_image_url = 'public/storage/'.$my_profile_image;?>
                  <img src="{{ url($my_profile_image_url) }}" alt="{{ Auth::user()->name }}">
                  @endif
                </div>
                <h5>{{ Auth::user()->name }}</h5>
              </div>
              <ul id="side-menu" class="main-menu">
                <li><a href="{{ url('/') }}"><i class="fa fa-home"></i>Dashboard</a></li>
                @if(check_permission(Auth::user()->id, 'user.index') || check_permission(Auth::user()->id, 'userrole.index') || check_permission(Auth::user()->id, 'attendence') || check_permission(Auth::user()->id, 'master.index', 'holiday'))
                <li class="<?php if(Request::segment(1) == 'user' || Request::segment(1) == 'userrole' || Request::segment(1) == 'user_attendence' || (isset($_GET['master_type']) && $_GET['master_type'] == 'holiday')) { echo 'active';} ?>"><a href="javascript:void();"><span class="nav-parent-list"><i class="fa fa-th-large"></i>HR Management</span></a>
                <ul <?php if(Request::segment(1) == 'user' || Request::segment(1) == 'userrole' || Request::segment(1) == 'user_attendence' || (isset($_GET['master_type']) && $_GET['master_type'] == 'holiday')) { echo 'style=display:block';} ?>>
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
              <li class="<?php if(isset($_GET['master_type']) && $_GET['master_type'] == $key) { echo 'active';} ?>">
                <a href="{{ $key == 'revision' ? url('/master?master_type='.$key) : 'javascript:void(0);' }}"><i class="fa fa-th-large"></i>{{ $key == 'revision' ? $master : 'Manage '.$master }}</a>
                @if($key != 'revision')
                <ul <?php if(isset($_GET['master_type']) && $_GET['master_type'] == $key) { echo 'style="display: block"';} ?>>
                  <li><a href="{{ url('/master?master_type='.$key) }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>{{$master}} List</a></li>
                  @if(check_permission(Auth::user()->id, 'master.create', $key))
                  <li><a href="{{ url('/master/create?master_type='.$key) }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Add {{$master}}</a></li>
                  @endif
                  @if($key == 'case')
                  @if(check_permission(Auth::user()->id, 'master.index', 'case_category'))
                  <li><a href="{{ url('/master?master_type=case_category') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Categories</a></li>
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
              <li><a href="{{ url('/settings') }}">Site Settings</a></li>
              @endif
            </ul>
          </div>
        </div>
        @yield('content')
      </div>
    </div>
  </div>
  @if(!in_array($user_role, array(2,3)))
  <a class="btn btn-primary footer_logout" 
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        &nbsp;Logout</a>
  @endif
  <footer class="footer">
    <div class="container">
      <p>Copyright © {{ date('Y') }} {{ empty(get_option('site_name')) ? 'Alphaxine Admin' : get_option('site_name') }}. All Rights Reserved </p>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  /<script type='text/javascript' src="{{ asset('/public/js/jquery-ui.js') }}" ></script>
  <script src="{{ asset('/public/non_admin/js/popper.min.js') }}"></script>
  <script src="{{ asset('/public/non_admin/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/public/non_admin/js/ie10-viewport-bug-workaround.js') }}"></script>
  <script src="{{ asset('/public/non_admin/js/ie-emulation-modes-warning.js') }}"></script>

  <script src="{{ asset('/public/non_admin/js/custom.js') }}"></script>
  <script src="{{ asset('/public/non_admin/js/jquery.matchHeight-min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/public/js/jquery.filer.js') }}" ></script>
  <script src="{{ asset('/public/js/jquery.validationEngine-en.js') }}"  type="text/javascript" charset="utf-8"></script>
  <script src="{{ asset('/public/js/jquery.validationEngine.js') }}"  type="text/javascript" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>
  <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js" ></script>
  <script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js" ></script>
  
  <script src="{{ asset('/public/js/jquery.mCustomScrollbar.concat.min.js') }}" ></script>
  <script language="javascript" src="{{ asset('/public/js/jquery.pwdMeter.js') }}" ></script>
  <script src="{{ asset('/public/js/hideShowPassword.min.js') }}" ></script>
  <script src="{{ asset('/public/js/clipboard.min.js') }}" ></script>
  <script src="{{ asset('/public/js/trigger.js') }}" ></script>
  <script src="{{ asset('/public/js/tooltips.js') }}" ></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="{{ asset('/public/js/waitMe.min.js') }}" ></script>
  <script src="{{ asset('/public/js/jquery.mask.min.js') }}" ></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="{{ asset('/public/js/custom.js') }}?v=1.5.0" ></script>
  <script src="{{ asset('/public/js/app.js') }}"></script>
  @if(session()->has('attendeeSuccessMsg'))
  @if(!in_array($user_role, array(2,3)))
  <script type="text/javascript">
  Swal.fire({
  icon: 'success',
  title: 'Welcome {{ Auth::user()->name }}',
  text: "{{ session()->get('attendeeSuccessMsg') }}"
  })
  </script>
  @endif
  @endif
  <script type="text/javascript">
  (function() {
  function ajax_post(url = '', data = [], success = function() {}, error = function() {}, beforesend = function() {}) {
  jQuery.ajax({
  url: url,
  type: 'post',
  data: data,
  contentType: false,
  processData: false,
  beforeSend: beforesend,
  success: success,
  error: error
  });
  }
  $('input[name="profile_img"]').on('change', function(e) {
  e.preventDefault();
  var data = new FormData();
  var files = $(this)[0].files[0];
  data.append('profile_image',files);
  data.append("_token", $('meta[name="csrf-token"]').attr('content'));
  let url = base_url + '/change_image';
  let success = function(resp) {
  location.reload();
  
  };
  let error = function() {
  $('body').waitMe('hide');
  toastr.error('', 'Check your network connection', {
  timeOut: '60000',
  positionClass: 'toast-bottom-right'
  });
  };
  let beforesend = function() {
  $('body').waitMe({
  effect : 'bounce',
  text : 'Updating your profile picture...',
  bg : 'rgba(255,255,255,0.8)',
  color : '#24747e',
  maxSize : '',
  textPos : 'vertical',
  source : ''
  });
  };
  ajax_post(url, data, success, error, beforesend);
  })
  })();
  </script>
</body>
</html>