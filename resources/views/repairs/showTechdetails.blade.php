@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
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
<script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/moment/locales.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/datetime.min.js') }}"></script>
<script>
    jQuery(function () {
        $('#toa').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#tod').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#roc').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
    });  
</script>
<script>
    $(document).ready(function() { $(".tech_fault_select").select2(); });
    $(document).ready(function() { $(".correction_select").select2(); });
 </script>

<!-- Page JS Helpers (BS Notify Plugin) -->

<script>jQuery(function(){ Dashmix.helpers('notify'); });</script>

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
        @include('layouts.innerRepairNav')
        <!-- END Main Navigation -->
    </div>
</div>
<!-- Page Content -->
<div class="content">

    <!-- <button type="button" class="js-notify btn btn-info push" data-type="info" data-icon="fa fa-info-circle mr-1" data-message="Hello World">
     <i class="fa fa-bell mr-1"></i> Launch Notification
</button> -->
    <!-- Bootstrap Datepicker (.js-datepicker and .input-daterange classes are initialized in Helpers.datepicker()) -->
    <!-- For more info and examples you can check out https://github.com/eternicode/bootstrap-datepicker -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">Repairs for
                {{$repair->jobs->job_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/repairs/{{$repair->id}}/techdetails" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Technical Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-warning">Update repairs</button>
                    </div>
                </h2>
                <div class="row">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Time of Arrival and Time of Departure of this repairs
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-group date" id="toa" data-target-input="nearest">
                                <input type="text" name="time_of_arrival" class="form-control datetimepicker-input"
                                    data-target="#toa" value="{{$repair->time_of_arrival}}" />
                                <div class="input-group-append" data-target="#toa" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <span class="input-group-text font-w600">
                                <i class="fa fa-fw fa-arrow-down"></i>
                            </span>
                            <div class="input-group date" id="tod" data-target-input="nearest">
                                <input type="text" name="time_of_departure" class="form-control datetimepicker-input"
                                    data-target="#tod" value="{{$repair->time_of_departure}}" />
                                <div class="input-group-append" data-target="#tod" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="content-heading">Technical Details</h2>

                <div class="col-lg-10" style="padding-left: 50px;">
                    <div class="form-group">
                        <label for="example-text-input">Parts Required</label>
                        <textarea class="form-control" rows="2" placeholder="" name="parts_required" required>{{$repair->parts_required}}</textarea>
                    </div>
                </div>
        </div>
    </div>
    @endsection
