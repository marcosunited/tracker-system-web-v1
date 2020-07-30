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
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
    });  
</script>
<script>
    $(document).ready(function() { $(".job_select").select2(); });
    $(document).ready(function() { $(".tech_select").select2(); });
    $(document).ready(function() { $(".lift_select").select2({
        multiple: true,
    }); });
    $(document).ready(function() { $(".lift_select").select2().val({{$repair->getTagIdsAttribute()}}).trigger('change'); });
    $(document).ready(function() { $(".fault_select").select2(); });
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
                {{$selectedjob->job_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/repairs/{{$repair->id}}" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Repair Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-warning">Update Repairs</button>
                    </div>
                </h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <select class="form-control job_select" name="job_id" required disabled>
                                <option value="">--- Select Job ---</option>
                                @foreach ($jobs as $data)
                                <option value="{{ $data->id }}" @if($repair->jobs->id == $data->id) selected @endif>{{
                                    $data->job_address_number }} {{
                                    $data->job_address }} {{ $data->job_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="there">
                            <label for="example-text-input">Lift</label>
                            <select class="form-control lift_select" name="lift_id[]" required>
                                @foreach ($lifts as $data)
                                <option value="{{ $data->id }}">{{ $data->lift_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Time of Repair</label>
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" name="repair_time" class="form-control datetimepicker-input"
                                    data-target="#datetimepicker1" value="{{$repair->repair_time}}" />
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Quote Number</label>
                            <input type="text" class="form-control" placeholder="" name="quote_no" required value="{{$repair->quote_no}}">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                    <div class="form-group" id="here">
                            <label for="example-text-input">Technician</label>
                            <select class="form-control tech_select" name="technician_id" required>
                                <option value="">--- Select Technician ---</option>
                                @foreach ($technicians as $data)
                                <option value="{{ $data->id }}" @if($repair->techs->id == $data->id) selected
                                    @endif>{{ $data->technician_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Current Status</label>
                            <select class="form-control" name="repair_status_id" required>
                                <option value="">----------Select Status-----------</option>
                                <option value="1" @if($repair->repair_status_id == 1) selected @endif>Open</option>
                                <option value="2" @if($repair->repair_status_id == 2) selected @endif>Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Order Numbers</label>
                            <input class="form-control" rows="2" placeholder="" name="order_no" required value="{{$repair->order_no}}">
                        </div>

                        <div class="form-group">
                            <label for="example-text-input">Charageable</label>
                            <!-- <button style="float:right;" type="button" id="techcheck" class="btn btn-warning">Check Tech</button> -->
                            <select class="form-control tech_select" name="chargeable_id" required>
                                <option value="">--- Select Charageable ---</option>
                                <option value="1" @if($repair->chargeable_id == 1) selected @endif>Yes</option>
                                <option value="2" @if($repair->chargeable_id == 2) selected @endif>No</option>
                            </select>
                        </div>
                        <!-- <div class="form-group" id="there">
                            <label class="d-block">Lift</label>
                            @if($lifts)
                            @foreach ($lifts as $data)
                            <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="example-cb-custom-inline-{{$data->id}}"
                                    name="lift_id[]" value="{{ $data->id }}">
                                <label class="custom-control-label" name="{{ $data->id }}" for="example-cb-custom-inline-{{$data->id}}">{{$data->lift_name}}</label>
                            </div>
                            @endforeach
                            @endif
                        </div> -->
                    </div>
                </div>

                <h2 class="content-heading">Additional information</h2>
                <div class="row">

                    <div class="col-lg-4" style="padding-left: 50px;">
                    </div>

                    <div class="col-lg-10" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Description</label>
                            <textarea class="form-control" rows="3" placeholder="" name="repair_description" required>{{$repair->repair_description}}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-10" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Part Description</label>
                            <textarea class="form-control" rows="3" placeholder="" name="parts_description" required>{{$repair->parts_description}}</textarea>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Email</label>
                            <input type="text" class="form-control" placeholder="" name="notify_email" value="{{$repair->notify_email}}"
                                required>
                        </div>
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
