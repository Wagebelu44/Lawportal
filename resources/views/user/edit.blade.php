@extends("user.create")
@section("userId", $data['user']->id)
@section("name", $data['user']->name)
@section("username", $data['user']->username)
@section("email", $data['user']->email)
@section("mobile", get_usermeta($data['user']->id, 'mobile'))
@section("address", get_usermeta($data['user']->id, 'address'))
@section("addnew")
@if(check_permission(Auth::user()->id, 17))
<a href="{{ url('/user/create') }}{{ $data['userrole_id'] > 0 ? '?userrole_id='.$data['userrole_id'] : ''}}" class="btn btn-default">Add New</a>
@endif
@endsection
<?php $profile_image = get_usermeta($data['user']->id, '_profile_image');
	$userrole_id = get_usermeta($data['user']->id, '_userrole_id');
	if(isset($userrole_id) && !empty($userrole_id)) {
		$field_ids = DB::table('userforms')->where('userrole_id', $userrole_id)->get();
	}
?>
@section('extraFields')
@isset($field_ids)
@forelse($field_ids as $field_id)

@if($field_id->formfield_id == 5)
<h3>Communication Address</h3>
<label class="col-sm-3 label-lg">C/O Name </label>
<div class="col-sm-9 form-group"><input type="text" class="form-control text-input" name="com_addr_co" id="com_addr_co" value="<?php if($__env->yieldContent('com_addr_co')) { echo $__env->yieldContent('com_addr_co');}else { echo old('com_addr_co');} ?>"></div>
<label class="col-sm-3 label-lg">House no./Street </label>
<div class="col-sm-9 form-group"><input type="text" class="form-control text-input" name="com_addr_hsno" id="com_addr_hsno" value="<?php if($__env->yieldContent('com_addr_hsno')) { echo $__env->yieldContent('com_addr_hsno');}else { echo old('com_addr_hsno');} ?>"></div>
<label class="col-sm-3 label-lg">Village/Town </label>
<div class="col-sm-9 form-group"><input type="text" class="form-control text-input" name="com_addr_village" id="com_addr_village" value="<?php if($__env->yieldContent('com_addr_village')) { echo $__env->yieldContent('com_addr_village');}else { echo old('com_addr_village');} ?>"></div>
<label class="col-sm-3 label-lg">Enter Pin code </label>
<div class="col-sm-9 form-group"><input type="text" class="form-control text-input" name="com_addr_pin" id="com_addr_pin" value="<?php if($__env->yieldContent('com_addr_pin')) { echo $__env->yieldContent('com_addr_pin');}else { echo old('com_addr_pin');} ?>"></div>
<label class="col-sm-3 label-lg">Contact No. </label>
<div class="col-sm-9 form-group"><input type="text" class="form-control text-input" name="com_addr_contactno" id="com_addr_contactno" value="<?php if($__env->yieldContent('com_addr_contactno')) { echo $__env->yieldContent('com_addr_contactno');}else { echo old('com_addr_contactno');} ?>"></div>
@endif
@empty
@endforelse
@endisset
@endsection
@section("profile_image", $profile_image)
@section("editMethod")
@method('PUT')
@endsection