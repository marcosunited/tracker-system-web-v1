@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/plugins/dropzone/dropzone.min.js') }}"></script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>
@endsection

@section('content')
@include('error.error')
<div class="bg-white inner-top-bar">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerJobNav')
        <!-- END Main Navigation -->
    </div>
</div>
<div class="content">
    <div class="block block-rounded block-bordered">

        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Edit</span>&nbsp&nbsp Lift Name: &nbsp&nbsp<h3 class="block-title">{{$lift->lift_name}}</h3>
            <a href="/jobs/{{$job->id}}/lifts/{{$lift->id}}/callouts"><button class="btn btn-primary">Lift Callouts</button></a>  &nbsp&nbsp
        </div>
        <div class="block-content">
            <form action="/jobs/{{$job->id}}/lifts/{{$lift->id}}" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <div class="input-group-append" style="float:right;">
                    <button type="submit" class="btn btn-hero-warning">Update</button>
                </div>
                <h2 class="content-heading pt-0">{{$job->job_name}}</h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Lift Status</label>
                            <select class="form-control" name="lift_status_id" required>
                                <option value="">--- Select Status ---</option>
                                <option value="1" name="lift_status_id" @if($lift->lift_status_id == 1) selected @endif>Active</option>
                                <option value="2" name="lift_status_id" @if($lift->lift_status_id == 2) selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Type</label>
                            <select class="form-control" name="lift_type" required>
                                <option value="">--- Select Type ---</option>
                                <option value="L" name="lift_type" @if($lift->lift_type == "L") selected @endif>Lifts</option>
                                <option value="E" name="lift_type" @if($lift->lift_type == "E") selected @endif>Escalators or Travelators</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift name</label>
                            <input type="text" class="form-control" name="lift_name" placeholder="" required value="{{$lift->lift_name}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Phone</label>
                            <input type="text" class="form-control" name="lift_phone" placeholder="" value="{{$lift->lift_phone}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Register Number</label>
                            <input type="text" class="form-control" name="lift_reg_number" placeholder="" value="{{$lift->lift_reg_number}}">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        <div class="form-group">
                            <label for="example-text-input">Lift Brand</label>
                            <input type="text" class="form-control" name="lift_brand" placeholder="" value="{{$lift->lift_brand}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Model</label>
                            <input type="text" class="form-control" name="lift_model" placeholder="" value="{{$lift->lift_model}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Speed</label>
                            <input type="text" class="form-control" name="lift_speed" placeholder="" value="{{$lift->lift_speed}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Floors</label>
                            <input type="text" class="form-control" name="lift_floor" placeholder="" value="{{$lift->lift_floor}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Lift Installed Date</label>
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="lift_installed_date" value="{{$lift->lift_installed_date}}">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        
@endsection
