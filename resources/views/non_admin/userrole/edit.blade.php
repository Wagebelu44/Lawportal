@extends("non_admin.userrole.create", ['userforms' => $data['userform']])

@section("userroleId", $data['userrole']->id)

@section("name", $data['userrole']->name)

@section("edit-page-content", 'edit-page-content')

@section("editMethod")
@method('PUT')
@endsection

@section("addnew")
@if(check_permission(Auth::user()->id, 53)) 
<a href="{{ url('/userrole/create') }}" class="btn btn-default">Add New</a>
@endif
@endsection