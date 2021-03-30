@extends('layouts.master')
<?php $masters = get_master_slugs();?>
@if(isset($masters[$data['master_type']]))
@section('title', $masters[$data['master_type']])
@section('content')
<div class="col-lg-8 col-md-7">
    <div class="form-block">
		<h1>Upload {{$masters[$data['master_type']]}}</h1>
	    <div class="row">
	       <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <!--This is the import type selector-->
                        <div class="form-group" style="display:none">
                            <select class="form-control" id="dataType">
                                <option value="-1" disabled selected>Select Data to Import</option>
                                <option selected value="{{route('upload.excel', ['_token' => csrf_token() ])}}&master_type=file_manager">Import Posts Data</option>
                            </select>
                        </div>
                        <!-- This is the file chooser input field-->
                        <div class="form-group">
                            <input type="file" id="fileUploader" class="btn btn-fill btn-primary btn-large" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                        </div>
                    </div>
                </div>
                <!-- This is the Blank output/progress div-->
                <div id="tableOutput">
                </div>
	       </div>
	    </div>
		    	
	</div>
</div>
@if($data['master_type'] == 'file_manager')
<script type="text/javascript">
	new ExcelUploader({
        maxInAGroup: 50,
        serverColumnNames: ["Name", "File Number", "Case Number", "Matter", "Location", "Last Update"],
        importTypeSelector: "#dataType",
        fileChooserSelector: "#fileUploader",
        outputSelector: "#tableOutput",
        extraData: {}
    });
</script>
@endif
@endsection
@endif




