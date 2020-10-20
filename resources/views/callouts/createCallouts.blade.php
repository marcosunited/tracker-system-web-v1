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
<script src="{{ asset('js/plugins/jquery-blockUI/jquery.blockUI.min.js') }}"></script>


<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/moment/locales.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/datetime.min.js') }}"></script>
<script>
    jQuery(function() {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });

        $("#techcheck").click(function() {
            $("#contents").load('techDropdown.blade.php');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".job_select").select2();
    });
    $(document).ready(function() {
        $(".tech_select").select2();
    });
    $(document).ready(function() {
        $(".fault_select").select2();
    });
</script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(document).ready(function() {

        $(".lift_select").select2({
            multiple: true
        });

        $(document).ajaxStop($.unblockUI);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(".job_select").change(function() {

            $.blockUI({
                message: $('.blockUI-layout')
            });

            $.ajax({
                /* the route pointing to the post function */
                url: '/callouts/selectedJob',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    message: $(".job_select").select2("val")
                },
                dataType: 'JSON',
                success: function(data) {
                    try {
                        if (data) {
                            if (data['lifts']) {
                                var lifts = data['lifts'];

                                $("#lift_select").select2().empty();

                                for (var i = 0; i < lifts.length; i++) {
                                    var html = '<option value="' + lifts[i]['id'] + '">' + lifts[i]['lift_name'] + '</option>';
                                    $("#lift_select").append(html);
                                }
                                $("#lift_select").select2({
                                    multiple: true
                                });
                            }

                            if (data['technician']) {
                                var technician = data['technician'];

                                setTimeout(() => {
                                    $("#technician").val(technician.id).trigger('change');
                                }, 10);
                            }
                        }
                    } catch (e) {
                        $.unblockUI();
                    }
                },
                error: function() {
                    $.unblockUI();
                }
            });

            //Session::put('selectedJob',$(".job_select").select2("val"));
            //$selectedJob = Session::get('selectedJob');
            //window.location.reload(true);
            $("#here").load(window.location.href + " #here");
            //$( "#there" ).load(window.location.href + " #there" );           
        });
    });
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
<!-- Page Content -->

<div class="content">
    @include('error.error')
    <!-- <button type="button" class="js-notify btn btn-info push" data-type="info" data-icon="fa fa-info-circle mr-1" data-message="Hello World">
     <i class="fa fa-bell mr-1"></i> Launch Notification
</button> -->
    <!-- Bootstrap Datepicker (.js-datepicker and .input-daterange classes are initialized in Helpers.datepicker()) -->
    <!-- For more info and examples you can check out https://github.com/eternicode/bootstrap-datepicker -->
    <div class="blockUI-layout">
        <h4>Getting data...</h4>
    </div>

    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Add:</span>&nbsp&nbsp<h3 class="block-title">New Callouts</h3>
        </div>
        <div class="block-content">
            <form action="/callouts/add" method="POST">
                @csrf
                <h2 class="content-heading pt-0">Callouts Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-primary">Add Callouts</button>
                    </div>
                </h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <select class="form-control job_select" name="job_id" required>

                                <option value="">--- Select Job ---</option>
                                @foreach ($jobs as $data)
                                <option value="{{ $data->id }}">{{ $data->job_address_number }} {{
                                    $data->job_address }} {{ $data->job_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="there">
                            <label for="example-text-input">Lift</label>
                            <!-- <button style="float:right;" type="button" class="btn btn-warning">Check Lifts</button> -->
                            <select id="lift_select" class="form-control lift_select" name="lift_id[]" required multiple="multiple"></select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Time of Call</label>
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" name="callout_time" class="form-control datetimepicker-input" data-target="#datetimepicker1" />
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Call Reported By</label>
                            <input type="text" class="form-control" placeholder="" name="reported_customer" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Reporter Contact Details</label>
                            <input class="form-control" rows="2" placeholder="" name="contact_details" required>
                        </div>
                        <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        <div class="form-group">
                            <label for="example-text-input">Current Status</label>
                            <select class="form-control" name="callout_status_id" required>
                                <option value="">----------Select Status-----------</option>
                                <option value="1" selected>Open</option>
                                <option value="2">Closed</option>
                                <option value="3">Lift Shutdown</option>
                                <option value="4">Follow Up</option>
                                <option value="5">Under Repair</option>
                            </select>
                        </div>
                        <div class="form-group" id="here">
                            <label for="example-text-input">Technician</label>
                            <!-- <button style="float:right;" type="button" id="techcheck" class="btn btn-warning">Check Tech</button> -->
                            <select class="form-control tech_select" id="technician" name="technician_id" required>
                                <option value="">--- Select Technician ---</option>
                                @foreach ($technicians as $data)
                                <option value="{{ $data->id }}"> {{ $data->technician_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="example-text-input">Which Floor lift located</label>
                            <input type="text" class="form-control" placeholder="" name="floor_no" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Reported Fault</label>
                            <select class="form-control fault_select" name="fault_id" required>
                                <option value="">--- Select Fault ---</option>
                                @foreach ($faults as $data)
                                <option value="{{ $data->id }}">{{ $data->fault_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Description (Optional)</label>
                            <textarea class="form-control" rows="3" placeholder="" name="callout_description"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Order Number (Optional)</label>
                            <input type="text" class="form-control" placeholder="" name="order_number">
                        </div>
                    </div>
                    <!-- <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Email</label>
                            <input type="text" class="form-control" placeholder="" name="notify_email" required>
                        </div>
                    </div> -->
                </div>

                <div class="input-group-append" style="float:right;">
                    <button type="submit" class="btn-hero-primary">Add Callouts</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection