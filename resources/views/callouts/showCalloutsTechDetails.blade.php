@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<style>
#callout_map{width:100%;height:100%;}
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
<script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
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
        $('#toaccept').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#todecline').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#mtoa').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
        $('#mtod').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            value: new Date()
        });
    });
</script>
<script>
    $(document).ready(function() { $(".tech_fault_select").select2(); });
    $(document).ready(function() { $(".correction_select").select2(); });

      var marker;
      let map;
      let markersArray = [];
      function initMap() {
        map = new google.maps.Map(document.getElementById('callout_map'), {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644}
        });
        /*
        addMarker({lat: -34.297, lng: 150.544}, "Accept","blue");
        addMarker({lat: -34.397, lng: 150.644}, "Decline","red");
        addMarker({lat: -34.197, lng: 150.544}, "Start","green");
        addMarker({lat: -34.597, lng: 150.644}, "Finish","yellow");
        */
        <?php
            if ($accept_lat!=0 && $accept_lng!=0) {
                echo 'addMarker({lat:'.$accept_lat.',lng:'. $accept_lng.'},"Accept","blue");';
            }
            if ($decline_lat!=0 && $decline_lng!=0) {
                echo 'addMarker({lat:'.$decline_lat.',lng:'. $decline_lng.'},"Accept","red");';
            }
            if ($start_lat!=0 && $start_lng!=0) {
                echo 'addMarker({lat:'.$start_lat.',lng:'. $start_lng.'},"Accept","green");';
            }
            if ($finish_lat!=0 && $finish_lng!=0) {
                echo 'addMarker({lat:'.$finish_lat.',lng:'. $finish_lng.'},"Accept","yellow");';
            }
        ?>
      }
      function addMarker(latLng,label, color) {
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
 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU&callback=initMap">
</script>
<!-- Page JS Helpers (BS Notify Plugin) -->

<script>jQuery(function(){ Dashmix.helpers('notify'); });</script>
<!-- Page JS Helpers (Magnific Popup Plugin) -->
<script>jQuery(function(){ Dashmix.helpers('magnific-popup'); });</script>
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
        @include('layouts.innerCalloutNav')
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
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">Callouts for
                {{$callout->jobs->job_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/callouts/{{$callout->id}}/techdetails" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Time Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-warning">Update Callouts</button>
                    </div>
                </h2>
                <div class="row">
                    <div class="col-lg-8">
                    <div class="row">
                    <div class="col-lg-4">
                            <p class="text-muted" >
                                Time of Callout accept
                            </p>

                            <p class="text-muted" style="margin-top: 50px">
                                Time of Callout decline
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-6">
                            <div class="form-group">
                                <div class="input-group date" id="toaccept" data-target-input="nearest">
                                    <input type="text" name="time_of_callout_start" class="form-control datetimepicker-input"
                                        data-target="#toaccept" value="{{$callouttime?$callouttime->accept_time:''}}" />
                                    <div class="input-group-append" data-target="#toaccept" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span class="input-group-text font-w600">
                                    <i class="fa fa-fw fa-arrow-down"></i>
                                </span>
                                <div class="input-group date" id="todecline" data-target-input="nearest">
                                    <input type="text" name="time_of_callout_finish" class="form-control datetimepicker-input"
                                        data-target="#todecline" value="{{$callouttime?$callouttime->decline_time:''}}" />
                                    <div class="input-group-append" data-target="#todecline" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p class="text-muted" >
                                Time of Arrival
                            </p>

                            <p class="text-muted" style="margin-top: 50px">
                                Time of Departure of this Callouts
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-6">
                            <div class="form-group">
                                <div class="input-group date" id="toa" data-target-input="nearest">
                                    <input type="text" name="time_of_arrival" class="form-control datetimepicker-input"
                                        data-target="#toa" value="{{$callout->time_of_arrival}}" />
                                    <div class="input-group-append" data-target="#toa" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span class="input-group-text font-w600">
                                    <i class="fa fa-fw fa-arrow-down"></i>
                                </span>
                                <div class="input-group date" id="tod" data-target-input="nearest">
                                    <input type="text" name="time_of_departure" class="form-control datetimepicker-input"
                                        data-target="#tod" value="{{$callout->time_of_departure}}" />
                                    <div class="input-group-append" data-target="#tod" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <p class="text-muted" >
                                Time of Arrival
                            </p>

                            <p class="text-muted" style="margin-top: 40px">
                                Time of Departure of this Callouts(Manuly Input by technician)
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-6">
                            <div class="form-group">
                                <div class="input-group date" id="mtoa" data-target-input="nearest">
                                    <input type="text" name="mtime_of_arrival" class="form-control datetimepicker-input"
                                        data-target="#mtoa" value="{{$callouttime?$callouttime->toa:''}}" />
                                    <div class="input-group-append" data-target="#mtoa" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span class="input-group-text font-w600">
                                    <i class="fa fa-fw fa-arrow-down"></i>
                                </span>
                                <div class="input-group date" id="mtod" data-target-input="nearest">
                                    <input type="text" name="mtime_of_departure" class="form-control datetimepicker-input"
                                        data-target="#mtod" value="{{$callouttime?$callouttime->tod:''}}" />
                                    <div class="input-group-append" data-target="#mtod" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-left">
                            <label>Accept</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/blue-dot.png"/>
                            <label>Decline</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/red-dot.png"/>
                            <label>Start</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png"/>
                            <label>Finish</label>
                            <img src="https://maps.google.com/mapfiles/ms/icons/yellow-dot.png"/>
                        </div>
                        <div id="callout_map" class="callout_map" ></div>
                    </div>
                </div>


                <h2 class="content-heading">Technical Details</h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                    <div class="form-group">
                        <label for="example-text-input">Fault Found(Cause)</label>
                        <select class="form-control tech_fault_select" name="technician_fault_id" required>
                            <option value="">--- Select Tech Fault ---</option>
                            @foreach ($techfaults as $data)
                            @if($callout->techfault)
                            <option value="{{ $data->id }}" @if($callout->techfault->id == $data->id) selected
                                @endif>{{ $data->technician_fault_name }}</option>
                            @else<option value="{{ $data->id }}">{{ $data->technician_fault_name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Work Correction</label>
                        <select class="form-control correction_select" name="correction_id" required>
                            <option value="">--- Select Correction ---</option>
                            @foreach ($corrections as $data)
                            @if($callout->correction)
                            <option value="{{ $data->id }}" @if($callout->correction->id == $data->id) selected
                                @endif>{{ $data->correction_name }}</option>
                            @else<option value="{{ $data->id }}">{{ $data->correction_name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Part Required?</label>
                        <select class="form-control" name="part_required" required>
                            <option value="">--- Select ---</option>
                            <option value="1" @if($callout->part_required == 1) selected @endif>YES</option>
                            <option value="0" @if($callout->part_required == 0) selected @endif>NO</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                    <!-- <div class="form-group">
                        <label for="example-text-input">Callout due to Outside interferance</label>
                        <select class="form-control" name="attributable_id">
                            <option value="">--- Select ---</option>
                            <option value="1" @if($callout->attributable_id == 1) selected @endif>Attributable</option>
                            <option value="2" @if($callout->attributable_id == 2) selected @endif>Not Attributable</option>
                            <option value="3" @if($callout->attributable_id == 3) selected @endif>N/A</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                            <label for="example-text-input">Chargeable?</label>
                            <select class="form-control" name="chargeable_id">
                                <option value="">--- Select ---</option>
                                <option value="1" @if($callout->chargeable_id == 1) selected @endif>Chargeable</option>
                                <option value="2" @if($callout->chargeable_id == 2) selected @endif>Not Chargeable</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Part Replaced?</label>

                        <select class="form-control" name="part_replaced" required>
                            <option value="">--- Select ---</option>
                            <option value="1" {{$callout->part_replaced ==1?'selected':''}}>YES</option>
                            <option value="0" {{$callout->part_replaced ==0?'selected':''}}>NO</option>
                        </select>
                    </div>
                    </div>
                    </div>
                    <div class="col-lg-10" style="padding-left: 50px;">

                        <div class="form-group">
                            <label for="example-text-input">Parts Description</label>
                            <textarea class="form-control" rows="2" placeholder="" name="part_description">{{$callout->part_description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Technical Description</label>
                            <textarea class="form-control" rows="3" placeholder="" name="tech_description">{{$callout->tech_description}}</textarea>
                        </div>
                    </div>
                </div>

                <h2 class="content-heading" style="margin-left:20px">Callout Pictures ({{count($callout->files)}})</h2>
                <div class="row items-push js-gallery img-fluid-100" style="padding:20px;">
                    @foreach ($callout->files as $one_pic)
                        @if ($one_pic->status == 'verified')
                        <div class="col-md-3 col-lg-3 col-xl-3 animated fadeIn">
                            <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{$one_pic->path}}">
                                <img class="img-fluid" src="{{$one_pic->path}}" alt="">
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div>
            </form>
    </div>
    @endsection
