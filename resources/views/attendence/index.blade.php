@extends('layouts.master')
@section('title', 'Attendences')
@section('content')
<?php $total_working_hour = 0; $i = 0; $working_hour_arr = []; $date_arr = [];?>
@if(!check_permission(Auth::user()->id, 'attendence.create') || !check_permission(Auth::user()->id, 'attendence.store'))
<style type="text/css">
  #user_attendencedataTable_wrapper .dt-buttons .dt-button:nth-child(1) {
    display: none
  }
</style>
@endif
<section class="page-content">
  <div class="wrapper">
    <div class="page-header">
      <h1>Attendences</h1>
    </div>
    @if(session()->has('attendenceSuccessMsg'))
    <div class="alert alert-success" role="alert">
      <p>{{ session()->get('attendenceSuccessMsg') }}</p>
    </div>
    @endif
    @if(session()->has('attendenceErrorMsg'))
    <div class="alert alert-danger" role="alert">
      <p>{{ session()->get('attendenceErrorMsg') }}</p>
    </div>
    @endif
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Search Attendence</div>
            <div class="panel-body">
              <form class="form-inline" action="">
                <div class="form-group">
                  <label for="email">Select Date</label>
                  <input type="text" name="attendence_date_range" class="date_range" value="{{!empty($data['attendence_date_range']) ? $data['attendence_date_range'] : ''}}"/>
                </div>
                <div class="form-group">
                  <label for="pwd">Select Employee</label>
                  <select class="form-control lawselect" name="user_id">
                    <option value="">Select employee</option>
                    @forelse($data['employees'] as $employee)
                    <option value="{{$employee->id}}" <?php if(isset($data['user_id']) && ($data['user_id'] == $employee->id)) { echo 'selected';} ?>>{{$employee->name}}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
              </form>
              
            </div>
          </div>
      </div>
    </div>
@if(isset($data['user_id']) && $data['user_id'] > 0)
    <div class="row">
      <div class="col-sm-12">
        <canvas id="attendenceChart"></canvas>
      </div>
    </div>
@endif
@if(!empty($data['attendence_date_range']))
    <div class="item-wrap item-list-table" id="attendence_today">
      <table id="user_attendencedataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Profile Image</th>
            <th>Name</th>
            <th>User IP</th>
            <th>City</th>
            <th>Browser</th>
            <th>Device</th>
            <th>Logged On</th>
            <th>Logged Out On</th>
            <th>Note</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
          @forelse($data['attendence'] as $attendence)
          <tr>
            @if($attendence['profile_image'] == null)
            <td><img class="user-profile-image" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $attendence['user_name'] }}"></td>
            @else
            <?php $profile_image_url = 'public/storage/'.$attendence['profile_image'];?>
            <td><img class="user-profile-image" src="{{ url($profile_image_url) }}" alt="{{ $attendence['user_name'] }}"></td>
            @endif
            <td>{{ ucwords($attendence['user_name']) }} - {{ $attendence['role_name'] }}</td>
            <td>{{ $attendence['user_ip'] }}</td>
            <td>{{ $attendence['city'] }}</td>
            <td>{{ $attendence['browser'] }}</td>
            <td>{{ $attendence['device'] }}</td>
            <td>{{ $attendence['logged_at'] }}</td>
            <td>{{ $attendence['logged_out_at'] }}</td>
            <td>{{ $attendence['note'] }}</td>
            <td>
              @if(!check_permission(Auth::user()->id, 'attendence.edit') || !check_permission(Auth::user()->id, 'attendence.update'))
              @if(empty($attendence['logged_out_at']))
              <a class="btn-link-td" href="{{route('attendence.edit', ['id' => $attendence['id'] ])}}"><i class="fa fa-pencil"></i>Approve</a>
              @endif
              @endif
              <button type="button" class="btn-link-td view_logs" data-id="{{$attendence['user_id']}}" data-log-date="{{date('Y-m-d', strtotime($attendence['logged_at']))}}"><i class="fa fa-eye"></i>View Logs</button>
            </td>
          </tr>
          <?php
            if(!empty($attendence['logged_out_at'])) {
              $working_time = date_diff(date_create($attendence['logged_out_at']), date_create($attendence['logged_at']));
              $working_hour = $working_time->format("%h");
              $total_working_hour = $total_working_hour + $working_hour;
              array_push($working_hour_arr, (int) $working_hour);
            }else {
              array_push($working_hour_arr, 0);
            } 
            array_push($date_arr, date('j M, y', strtotime($attendence['logged_at'])));
            $i++;
          ?>
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
@endif
  </div>
</section>
<div class="modal" id="attendenceLogModal">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title-header">Log Details</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="single_attendence_tbl" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Logged On</th>
              <th>Logged Out</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
$avg_working_hour = $i > 0 ? floor($total_working_hour/$i) : 0;
$avg_working_hour_arr = [];
for ($x=1; $x <= $i; $x++) { 
  array_push($avg_working_hour_arr, $avg_working_hour);
}
?>
@if(isset($data['user_id']) && $data['user_id'] > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
    var workingHours = '<?php echo json_encode($working_hour_arr); ?>';
    var dates = '<?php echo json_encode($date_arr); ?>';
    var avgWorkingHour = '<?php echo json_encode($avg_working_hour_arr); ?>';

    var ctx = document.getElementById('attendenceChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse(dates),
            datasets: [
              {
                label: 'Hours Active',
                backgroundColor: 'rgb(255, 99, 132, 0.3)',
                borderColor: 'rgb(255, 99, 132)',
                data: JSON.parse(workingHours)
              },
              {
                label: 'Average Hour',
                backgroundColor: 'rgb(255, 255, 255, .1)',
                borderColor: 'rgb(75, 192, 192)',
                data: JSON.parse(avgWorkingHour)                
              }
            ]
        },

        options: {
          responsive: true,
          title: {
            display: true,
            text: 'Employee Attendence'
          },
          scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 10
                }
            }]
          }
        }
    });
</script>
@endif
@endsection