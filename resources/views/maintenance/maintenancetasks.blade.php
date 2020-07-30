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
        $( "#techcheck" ).click(function() {
            $("#contents").load('techDropdown.blade.php');
        });
});  
</script>
<script>
    $(document).ready(function() { $(".job_select").select2(); });
    $(document).ready(function() { $(".tech_select").select2(); });
    $(document).ready(function() { $(".lift_select").select2({
        multiple: true,
    }); });
    $(document).ready(function() { $(".fault_select").select2(); });
 </script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".job_select").change(function(){
            $.ajax({
                /* the route pointing to the post function */
                url: '/callouts/selectedJob',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, 
                        message:$(".job_select").select2("val")},
                dataType: 'JSON',
            }); 
            
            //Session::put('selectedJob',$(".job_select").select2("val"));
            //$selectedJob = Session::get('selectedJob');
            //window.location.reload(true);
            $( "#here" ).load(window.location.href + " #here" );
            $( "#there" ).load(window.location.href + " #there" );           
        });
   });    
</script>

<!-- Page JS Helpers (BS Notify Plugin) -->

<script>jQuery(function(){ Dashmix.helpers('notify'); });</script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>
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
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Add:</span>&nbsp&nbsp<h3 class="block-title">New Maintenance</h3>
        </div>
        <div class="block-content">
            <form action="/maintenances/add" method="POST">
                @csrf
                <h2 class="content-heading pt-0">Maintenance Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-primary">Add Maintenance</button>
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
                            <select class="form-control lift_select" name="lift_id[]" required>
                                @if($lifts)
                                @foreach ($lifts as $data)
                                <option value="{{ $data->id }}">{{ $data->lift_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Maintenance Date</label>
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="maintenance_date">
                            </div>
                        </div>
                        <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        <div class="form-group">
                            <label for="example-text-input">Current Status</label>
                            <select class="form-control" name="completed_id" required>
                                <option value="">----------Select Status-----------</option>
                                <option value="1">Pending</option>
                                <option value="2">Completed</option>
                            </select>
                        </div>
                        <div class="form-group" id="here">
                            <label for="example-text-input">Technician</label>
                            <!-- <button style="float:right;" type="button" id="techcheck" class="btn btn-warning">Check Tech</button> -->
                            <select class="form-control tech_select" name="technician_id" required>
                                <option value="">--- Select Technician ---</option>
                                @foreach ($technicians as $data)
                                @if(Session::has('selectedJob'))
                                <option value="{{ $data->id }}" @if($selectedTech->first()->id == $data->id) selected
                                    @endif>{{ $data->technician_name }}</option>
                                @else <option value="{{ $data->id }}">{{ $data->technician_name }}</option>
                                @endif
                                @endforeach
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
                <h2 class="content-heading">Task Info</h2>
                <div class="row">


                </div>
            </form>
        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection
