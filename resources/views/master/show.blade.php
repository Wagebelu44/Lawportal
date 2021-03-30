@extends('layouts.master')
@section('title', $data['name'])
@section('content')
<section class="page-content">
<div class="wrapper">
<div class="page-header">
<h1>{{$data['name']}}&nbsp;&nbsp;<button class="btn btn-default" onclick="printDiv()">Print</button></h1>
</div>
<div class="row" id="print_section">
<table>
  <tr>
    <td>Case Name</td>
    <td>
    	{{$data['name']}}
    </td>
  </tr>
@forelse($data['casefiles'] as $casefile)
  <tr>
    <td>File Numbers</td>
    <td>
      <span style="border: 1px solid #000; padding: 3px">{{$data['name']}}</span>
    </td>
  </tr>
@empty
@endforelse
  <tr>
    <td>Client</td>
    <td>
    	@isset($data['client_id'])
		<?php $client = get_user($data['client_id']); 
		echo $client->name;
		?>
		@endisset
    </td>
  </tr>
  <tr>
    <td>Opponent</td>
    <td>
    	@isset($data['opponent_id'])
		<?php $opponent = get_user($data['opponent_id']); 
		echo $opponent->name;
		?>
		@endisset
    </td>
  </tr>
  <tr>
    <td>Court</td>
    <td>
    	@isset($data['court_id'])
		<?php $court = DB::table('masters')->where('id',$data['court_id'])->first();?>
		{{isset($court->name) ? $court->name : ''}}
		@endisset
    </td>
  </tr>
  <tr>
    <td>Subcourt</td>
    <td>
		@isset($data['subcourt_id'])
		<?php $subcourt = DB::table('masters')->where('id',$data['subcourt_id'])->first(); ?>
		{{isset($subcourt->name) ? $subcourt->name : ''}}
		@endisset
    </td>
  </tr>
  <tr>
    <td>Case Category</td>
    <td>
    	@isset($data['case_category_id'])
		<?php $case_category = DB::table('masters')->where('id',$data['case_category_id'])->first();?>
		{{isset($case_category->name) ? $case_category->name : ''}}
		@endisset
    </td>
  </tr>
  <tr>
    <td>Case Subcategory</td>
    <td>
    	@isset($data['case_subcategory_id'])
		<?php $case_subcategory = DB::table('masters')->where('id',$data['case_subcategory_id'])->first(); ?>
		{{isset($case_subcategory->name) ? $case_subcategory->name : ''}}
		@endisset
    </td>
  </tr>
  <tr>
    <td>Assignees</td>
    <td>
<?php
	foreach ($data['todoassignees'] as $todoassignee) :
		$user = get_user($todoassignee->user_id);
		$role_id = get_usermeta($todoassignee->user_id, '_userrole_id');
		$role_name = '';
		if($role_id) {
			$user_role = DB::table('userroles')->select('name')->where('id', $role_id)->first();
			$role_name = $user_role->name;
		}
?>

	<span style="border: 1px solid #000; padding: 3px">{{ $user->name .' - '.$role_name }}</span>
<?php endforeach;
?>
    </td>
  </tr>
  <tr>
    <td>Next Hearing Date</td>
    <td>
    	{{isset($data['hearing_date']) ? $data['hearing_date'] : ''}}
    </td>
  </tr>
  <tr>
    <td>Case Status</td>
    <td>
	<?php
	$case_status = isset($data['case_status']) ? $data['case_status'] : 'active';
		switch ($case_status) {
			case 'suspended':
				echo 'Closed';
				break;
			
			case 'closed':
				echo 'Suspended';
				break;

			default:
				echo 'Active';
				break;
		}
	?>
    </td>
  </tr>
  <tr>
    <td>Case Description</td>
    <td>
    	<?php $case_desc = isset($data['case_desc']) ? $data['case_desc'] : ''; 
			echo $case_desc;
		?>
    </td>
  </tr>
</table>
</div>
</div>
</section>
<script> 
    function printDiv() { 
        var divContents = document.getElementById("print_section").innerHTML; 
        var a = window.open('', '', 'height=500, width=500'); 
        a.document.write(divContents); 
        a.document.close(); 
        a.print(); 
    } 
</script>
@endsection