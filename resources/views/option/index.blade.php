@extends('layouts.master') 
@section('title', 'Site Settings')
@section("site_name", get_option('site_name'))
@section("site_email", get_option('site_email'))
@section("site_copyright", get_option('site_copyright'))
@section("site_logo", get_option('site_logo'))
@section("site_favicon", get_option('site_favicon'))
@section("office_start", get_option('office_start'))
@section("office_end", get_option('office_end'))

@section('content')
<section class="page-content">
    <div class="wrapper">
        <div class="page-header">
            <h1>Site Settings</h1>
        </div>
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('optionSuccessMsg'))
        <div class="alert alert-success" role="alert">
            <p>{{ session()->get('optionSuccessMsg') }}</p>
        </div>
        @endif
        @if(session()->has('optionErrorMsg'))
        <div class="alert alert-danger" role="alert">
            <p>{{ session()->get('optionErrorMsg') }}</p>
        </div>
        @endif
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <form method="post" action="{{route('option.update')}}" id="MasterForm" class="formular adminForm" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <label class="col-sm-3 label-lg">Site Name </label>
                            <div class="col-sm-9 form-group"><input type="text" class="form-control validate[required] text-input" name="site_name" id="site_name" value="<?php
                                if ($__env->yieldContent('site_name')) {
                                    echo $__env->yieldContent('site_name');
                                } else {
                                    echo old('site_name');
                                }
                                ?>"></div>
                            <div class="clearfix"></div>
                            <label class="col-sm-3 label-lg">Site Email </label>
                            <div class="col-sm-9 form-group"><input type="text" class="form-control validate[required],custom[email] text-input" name="site_email" id="site_email" value="<?php
                                if ($__env->yieldContent('site_email')) {
                                    echo $__env->yieldContent('site_email');
                                } else {
                                    echo old('site_email');
                                }
                                ?>"></div>
                            <div class="clearfix"></div>
                            <label class="col-sm-3 label-lg">Site Copyright </label>
                            <div class="col-sm-9 form-group"><input type="text" class="form-control text-input validate[required]" name="site_copyright" id="site_copyright" value="<?php
                                if ($__env->yieldContent('site_copyright')) {
                                    echo $__env->yieldContent('site_copyright');
                                } else {
                                    echo old('site_copyright');
                                }
                                ?>"></div>
                            <div class="clearfix"></div>

                            <label class="col-sm-3 label-lg">Office Timings</label>
                            <div class="col-sm-9">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control time" id="office_start" name="office_start" placeholder="Start Time" value="<?php
                                        if ($__env->yieldContent('office_start')) {
                                            echo $__env->yieldContent('office_start');
                                        } else {
                                            echo old('office_start');
                                        }
                                        ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control time" id="office_end" name="office_end" placeholder="End Time" value="<?php
                                        if ($__env->yieldContent('office_end')) {
                                            echo $__env->yieldContent('office_end');
                                        } else {
                                            echo old('office_end');
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <label class="col-sm-3 label-lg">Site Logo</label>
                            <div class="col-sm-9  form-group clearfix">
                                <div class="avatar-img img-thumbnail pull-left">
                                    @if(empty($__env->yieldContent('site_logo')))
                                    <img src="{{ asset('/public/images/default-logo.jpg') }}" alt="Site Logo">
                                    @else
                                    <img src="{{ url('public/storage') }}/@yield('site_logo')" alt="Site Logo">
                                    @endif
                                </div>
                                <div class="fileUpload btn btn-warning btn-xs pull-left">
                                    <span>Upload Site Logo</span>
                                    <input type="file" class="upload" name="site_logo" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <label class="col-sm-3 label-lg">Site Favicon</label>
                            <div class="col-sm-9  form-group clearfix">
                                <div class="img-thumbnail pull-left">
                                    @if(empty($__env->yieldContent('site_favicon')))
                                    <img src="{{ asset('/public/images/default-logo.ico') }}" alt="Site Favicon">
                                    @else
                                    <img src="{{ url('public/storage') }}/@yield('site_favicon')" alt="Site Favicon">
                                    @endif
                                </div>
                                <div class="fileUpload btn btn-warning btn-xs pull-left">
                                    <span>Upload Site Favicon</span>
                                    <input type="file" class="upload" name="site_favicon" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-9 col-sm-offset-3"><input type="submit" value="Submit" class="btn btn-primary"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection