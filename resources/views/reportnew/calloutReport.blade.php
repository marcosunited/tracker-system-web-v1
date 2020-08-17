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
                url: '/reports/selectedJob',
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

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>
@endsection

@section('content')
@include('error.error')
<div class="bg-white">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerReportNavNew')
        <!-- END Main Navigation -->
    </div>
</div>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form action="/reports/new/calloutreport/generate" method="POST">
                @csrf
                <h2 class="content-heading pt-0">Callout Report (Callouts)
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-primary">Generate Report</button>
                    </div>
                </h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <select class="form-control job_select" name="job_id" required>

                                <option value="">--- Select Job ---</option>
                                <option value="-1">--- All ---</option>
                                @foreach ($jobs as $data)
                                <option value="{{ $data->id }}">{{ $data->job_address_number }} {{
                                    $data->job_address }} {{ $data->job_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <label for="example-text-input">Period</label>
                            <div class="col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <div class="input-daterange input-group" data-date-format="yyyy-mm-dd"
                                        data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" placeholder="From" name="start_time">
                                        <div class="input-group-prepend input-group-append">
                                            <span class="input-group-text font-w600">
                                                <i class="fa fa-fw fa-arrow-right"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="To" name="finish_time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

        <!-- END Page Content -->
@endsection
