@extends('layouts.master')



@section('title', 'ADVT')



@section('content')

<section class="page-content">

<div class="wrapper">

<div class="page-header">

<h1>ADVT <a href="{{ url('/advt/create') }}" class="btn btn-default">Add New ADVT</a></h1>

</div>

@if(session()->has('advtDelSuccessMsg'))

<div class="alert alert-success" role="alert">

	<p>{{ session()->get('advtDelSuccessMsg') }}</p>

</div>

@endif



@if(session()->has('advtDelErrorMsg'))

<div class="alert alert-danger" role="alert">

	<p>{{ session()->get('advtDelErrorMsg') }}</p>

</div>

@endif

<div class="item-wrap item-list-table">

<table id="dataTable" class="table table-striped table-bordered postTable" cellspacing="0" width="100%">

<thead>

<tr>

<th>Profile Image</th>

<th>Name</th>

<th>Email</th>

<th>Created On</th>

<th>Created By</th>

<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($advts as $advt)

<?php

$created_by = get_user($advt->create_by);

$profile_image = get_mastermeta($advt->id, '_profile_image');
$email = get_mastermeta($advt->id, 'email');

?>

<tr>

@if($profile_image == null)

<td><img class="user-profile-image" src="{{ asset('/public/images/default-user.jpg') }}" alt="{{ $advt->name }}"></td>

@else

<?php $profile_image_url = 'public/storage/'.$profile_image;?>

<td><img class="user-profile-image" src="{{ url($profile_image_url) }}" alt="{{ $advt->name }}"></td>

@endif

<td>{{ $advt->name }}</td>

<td>{{ $email }}</td>

<td>{{ date('F d, Y', strtotime($advt->created_at)) }}</td>

<td>{{ ucwords($created_by->name) }}</td>

<td>

<a href="{{url('advt/'.$advt->id.'/edit')}}" class="btn-link-td"><i class="fa fa-edit"></i>Edit</a>

<button type="button" 

		class="btn-link-td" 

		onclick="event.preventDefault();

             	document.getElementById('delete-form').submit();">

 	<i class="fa fa-trash-o"></i>Delete

 </button>

 <form id="delete-form" action="{{url('advt/'.$advt->id)}}" method="POST" style="display: none;">

    @csrf

    @method('DELETE')

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</section>

@endsection