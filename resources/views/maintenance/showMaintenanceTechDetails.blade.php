@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<style>
    #callout_map {
        width: 100%;
        height: 300px
    }
</style>
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
    jQuery(function() {
        $('#toa').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#tod').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#toa_new').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#tod_new').datetimepicker({
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
    $(document).ready(function() {
        $(".tech_fault_select").select2();
    });
    $(document).ready(function() {
        $(".correction_select").select2();
        sanitizeForm($('select[name="part_required"]').val() == '0');
    });

    $('select[name="part_required"]').change(function() {
        sanitizeForm(this.value == 0);
        if (this.value == 0) {
            $('textarea[name="part_description"]').val('');
            $('select[name="part_replaced"]').val('0');
        }

    });

    function sanitizeForm(value) {
        $('select[name="part_replaced"]').prop({
            "disabled": value,
            "required": value
        });
        $('textarea[name="part_description"]').prop({
            "disabled": value,
            "required": value
        });
    }
</script>
<script>
    var marker;
    let map;
    let markersArray = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('callout_map'), {
            zoom: 8,
            center: {
                lat: -34.397,
                lng: 150.644
            }
        });

        <?php
        if ($start_lat != 0 && $start_lng != 0)  echo 'addMarker({lat:' . $start_lat . ',lng:' . $start_lng . '},"Start","green");';

        if ($finish_lat != 0 && $finish_lng != 0)  echo 'addMarker({lat:' . $finish_lat . ',lng:' . $finish_lng . '},"Finish","red");';
        ?>

    }

    function addMarker(latLng, label, color) {
        let url = "https://maps.google.com/mapfiles/ms/icons/";
        url += color + "-dot.png";

        let marker = new google.maps.Marker({
            map: map,
            position: latLng,
            icon: {
                url: url
            },
        });

        //store the marker object drawn in global array
        markersArray.push(marker);
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU&callback=initMap">
</script>

<!-- Page JS Helpers (BS Notify Plugin) -->

<script>
    jQuery(function() {
        Dashmix.helpers('notify');
    });
</script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>
    jQuery(function() {
        Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']);
    });
</script>

@endsection

@section('content')
@include('error.error')
<div class="bg-white">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerMaintenanceNav')
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
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">Maintenance for
                {{$maintenance->jobs->job_name}}
            </h3>
        </div>
        <div class="block-content">
            <form action="/maintenances/{{$maintenance->id}}/techdetails" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Technical Details

                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-warning">Update Maintenance</button>
                    </div>

                </h2>
                <div class="row">

                    <div class='col-lg-6'>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-muted">
                                    Time of Arrival and Time of Departure of this Maintenance
                                </p>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group date" id="toa" data-target-input="nearest">
                                        <input type="text" name="toa_date" class="form-control datetimepicker-input" data-target="#toa" value="{{$maintenance->maintenance_toa}}" />
                                        <div class="input-group-append" data-target="#toa" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-down"></i>
                                    </span>
                                    <div class="input-group date" id="tod" data-target-input="nearest">
                                        <input type="text" name="tod_date" class="form-control datetimepicker-input" data-target="#tod" value="{{$maintenance->maintenance_tod}}" />
                                        <div class="input-group-append" data-target="#tod" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted">

                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-6'>
                        <!-- Google Map here-->
                        <div class="text-center">
                            <label>Start</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png" />
                            <label>Finish</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/red-dot.png" />
                        </div>
                        <div id="callout_map" class="callout_map"></div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6">
                    <div class="form-group">
                        <label for="example-text-input">Part Required?</label>
                        <select class="form-control" name="part_required" required>
                            <option value="">--- Select ---</option>
                            <option value="1" @if($maintenance->part_required == 1) selected @endif>YES</option>
                            <option value="0" @if($maintenance->part_required == 0) selected @endif>NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Part Replaced?</label>

                        <select class="form-control" name="part_replaced" required>
                            <option value="">--- Select ---</option>
                            <option value="1" {{$maintenance->part_replaced ==1?'selected':''}}>YES</option>
                            <option value="0" {{$maintenance->part_replaced ==0?'selected':''}}>NO</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">

                    <div class="form-group">
                        <label for="example-text-input">Parts Description</label>
                        <textarea class="form-control" rows="2" placeholder="" name="part_description">{{$maintenance->part_description}}</textarea>
                    </div>
                </div>

                <div class="col-lg-12 col-xl-12">
                    <div class="form-group">
                        <label for="example-text-input">Order Number</label>
                        <input type="text" class="form-control" value="{{$maintenance->order_no}}" name="order_no">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input">Docket Number</label>
                        <input type="text" class="form-control" value="{{$maintenance->docket_no}}" name="docket_no">
                    </div>

                    <div id="where">
                        <h2 class="content-heading">Task Info</h2>
                        <div class="col-lg-12">
                            <!-- Block Tabs Default Style -->
                            <div class="block block-rounded block-bordered">
                                <select id="active_month" name="active_month" class="form-control" disabled onchange="change(this.value)">
                                    <option value="">Select montly tasks:</option>
                                    <option value="1" {{$selected_task_month==1?'selected':''}}>January</option>
                                    <option value="2" {{$selected_task_month==2?'selected':''}}>February</option>
                                    <option value="3" {{$selected_task_month==3?'selected':''}}>March</option>
                                    <option value="4" {{$selected_task_month==4?'selected':''}}>April</option>
                                    <option value="5" {{$selected_task_month==5?'selected':''}}>May</option>
                                    <option value="6" {{$selected_task_month==6?'selected':''}}>June</option>
                                    <option value="7" {{$selected_task_month==7?'selected':''}}>July</option>
                                    <option value="8" {{$selected_task_month==8?'selected':''}}>August</option>
                                    <option value="9" {{$selected_task_month==9?'selected':''}}>September</option>
                                    <option value="10" {{$selected_task_month==10?'selected':''}}>October</option>
                                    <option value="11" {{$selected_task_month==11?'selected':''}}>November</option>
                                    <option value="12" {{$selected_task_month==12?'selected':''}}>December</option>
                                </select>
                                <div class="block-content tab-content">
                                    <div class="tab-pane active" id="btabs-static-jan" role="tabpanel">
                                        <h4 class="font-w400"> {{strtoupper ($month_label)}} Task</h4>
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Task Name</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($tasks as $task)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{$task->task_name}}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                            <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}" name="task[]" value="{{$task->task_id}}" checked readonly>
                                                            <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>
@endsection