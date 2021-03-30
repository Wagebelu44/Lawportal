@extends('layouts.master')

@section('title', 'My Assessment')

@section('content')
<section class="page-content">
<div class="wrapper">
<div class="page-header">
<h1>My Assessment</h1>
</div>
@if(session()->has('evaluationSuccessMsg'))
<div class="alert alert-success" role="alert">
	<p>{{ session()->get('evaluationSuccessMsg') }}</p>
</div>
@endif
<div class="item-wrap item-list-table">
<table id="dataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">
<thead>
<tr>
<th>Title</th>
<th>Deadline</th>
<th>Created On</th>
<th>Created By</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($data['evaluations'] as $evaluation)
<?php
$created_by = get_user($evaluation->create_by);
$deadline = date('F d, Y', strtotime(get_mastermeta($evaluation->id, 'deadline')));
?>
<tr>
<td><a href="{{url('evaluation/'.$evaluation->id)}}" class="btn-link-td">{{ $evaluation->name }}</a></td>
<td>{{ $deadline }}</td>
<td>{{ date('F d, Y', strtotime($evaluation->created_at)) }}</td>
<td>{{ ucwords($created_by->name) }}</td>
<td>
<a href="{{url('evaluation/'.$evaluation->id)}}" class="btn-link-td"><i class="fa fa-eye"></i>View</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</section>
@endsection