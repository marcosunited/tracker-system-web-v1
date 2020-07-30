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
<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<!-- Page JS Helpers (BS Notify Plugin) -->
<script>jQuery(function(){ Dashmix.helpers('notify'); });</script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>
@endsection

@section('content')
@include('error.error')
<!-- Page Content -->
<div class="bg-white inner-top-bar">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerAgentNav')
        <!-- END Main Navigation -->
    </div>
</div>
<div class="content">

    <!-- <button type="button" class="js-notify btn btn-info push" data-type="info" data-icon="fa fa-info-circle mr-1" data-message="Hello World">
     <i class="fa fa-bell mr-1"></i> Launch Notification
</button> -->
    <!-- Bootstrap Datepicker (.js-datepicker and .input-daterange classes are initialized in Helpers.datepicker()) -->
    <!-- For more info and examples you can check out https://github.com/eternicode/bootstrap-datepicker -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Update:</span>&nbsp&nbsp<h3 class="block-title">Agent:{{$agent->agent_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/agents/{{$agent->id}}" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Basic
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn btn-hero-warning">Update Agent</button>
                    </div>
                </h2>
                <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Agent Name</label>
                            <input type="text" class="form-control" name="agent_name" value="{{$agent->agent_name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent Address</label>
                            <input type="text" class="form-control"  name="agent_address" value="{{$agent->agent_address}}" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent Phone Number</label>
                            <input type="text" class="form-control"  name="agent_phone" value="{{$agent->agent_phone}}" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent Fax</label>
                            <input type="text" class="form-control"  name="agent_fax" value="{{$agent->agent_fax}}" required>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>

<!-- END Page Content -->
@endsection
