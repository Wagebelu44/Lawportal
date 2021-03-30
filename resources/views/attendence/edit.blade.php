@extends("attendence.create")

@section("attendenceId", $data['attendence_id'])

@section("edit-page-content", 'edit-page-content')

@section("editMethod")
@method('PUT')
@endsection