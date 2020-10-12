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
<!-- Page Content -->
<div class="content">
    <!-- Bootstrap Datepicker (.js-datepicker and .input-daterange classes are initialized in Helpers.datepicker()) -->
    <!-- For more info and examples you can check out https://github.com/eternicode/bootstrap-datepicker -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">{{$job->job_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/jobs/{{$job->id}}" method="POST">
            {{method_field('PATCH')}}
            @csrf
            <div class="input-group-append" style="float:right;">
                    <button type="submit" class="btn btn-hero-warning">Update</button>
                </div>
                <h2 class="content-heading pt-0">Basic</h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Status</label>
                            <select class="form-control" name="status_id" id="status_id" required>
                                <option value="">--- Select Status ---</option>
                                @foreach ($status as $data)
                                <option value="{{ $data->id }}" @if($selectedStatus->id == $data->id) selected
                                    @endif>{{ $data->status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <input type="text" class="form-control input {{$errors->has('title') ? 'is-danger' : ''}}" placeholder="" name="job_name" value="{{$job->job_name}}">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Contract</label>
                            <!-- <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                            <input type="radio" class="custom-control-input" id="example-rd-custom-inline-lg1" name="example-rd-custom-inline-lg" checked="">
                            <label class="custom-control-label" for="example-rd-custom-inline-lg1">Not Define</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                            <input type="radio" class="custom-control-input" id="example-rd-custom-inline-lg2" name="example-rd-custom-inline-lg">
                            <label class="custom-control-label" for="example-rd-custom-inline-lg2">Standard</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                            <input type="radio" class="custom-control-input" id="example-rd-custom-inline-lg3" name="example-rd-custom-inline-lg">
                            <label class="custom-control-label" for="example-rd-custom-inline-lg3">Exclusive</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                            <input type="radio" class="custom-control-input" id="example-rd-custom-inline-lg4" name="example-rd-custom-inline-lg">
                            <label class="custom-control-label" for="example-rd-custom-inline-lg4">Premium</label>
                        </div> -->

                            <select class="form-control" name="contract_id" id="contract_id">
                                <option value="">--- Select Contract ---</option>
                                @foreach ($contract as $data)
                                <option value="{{ $data->id }}" @if($selectedContract->id == $data->id) selected
                                    @endif>{{ $data->contract_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Round</label>
                            <select class="form-control" name="round_id" id="round_id" style="color:#fff;background-image:none;background-color:#{{$selectedRound->round_colour}}">
                                @foreach ($rounds as $data)
                                <option style="background-color:#{{$data->round_colour}};" value="{{ $data->id }}"
                                    @if($selectedRound->id == $data->id) selected @endif>{{ $data->round_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent</label>
                            <select class="form-control" name="agent_id" id="agent_id">
                                <option value="">--- Select Agent ---</option>
                                @foreach ($agents as $data)
                                <option value="{{ $data->id }}" 
                                    @if(isset($selectedAgent)){ 
                                        @if($selectedAgent->id == $data->id) {
                                            selected
                                        }@endif
                                    }
                                    @endif>{{
                                    $data->agent_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent Details (Property Manager, Contact phone number etc)</label>
                            <input type="text" class="form-control" placeholder="Agent Input" value="{{$job->job_agent_contact}}" name="job_agent_contact">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Floors</label>
                            <input type="number" class="form-control" placeholder="Floor Input" value="{{$job->job_floors}}" name="job_floors">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Group</label>
                            <input type="text" class="form-control" placeholder="Group input" value="{{$job->job_group}}" name="job_group">
                        </div>
                        <div class="form-group">
                            <label for="example-textarea-input">Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Textarea content.." name="note">{{$job->note}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        <div class="form-group form-row">
                            <div class="col-4">
                                <label>Street No</label>
                                <input type="text" class="form-control" value="{{$job->job_address_number}}" name="job_address_number">
                            </div>
                            <div class="col-8">
                                <label>Street Name</label>
                                <input type="text" class="form-control" value="{{$job->job_address}}" name="job_address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Suburb</label>
                            <input type="text" class="form-control" placeholder="Surburd Input" value="{{$job->job_suburb}}" name="job_suburb">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Number</label>
                            <input type="text" class="form-control" placeholder="Number Input" value="{{$job->job_number}}" name="job_number">
                        </div>
                        <div class="form-group">
                            <label for="example-textarea-input">Key Access</label>
                            <textarea class="form-control" rows="4" placeholder="Textarea content.." name="job_key_access">{{$job->job_key_access}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Visit Frequency</label>
                            <select class="form-control" name="frequency_id" id="frequency_id">
                                <option value="">--- Select Frequency ---</option>
                                @foreach ($frequency as $data)
                                <option value="{{ $data->id }}" @if($selectedFrequency->id == $data->id) selected
                                    @endif>{{ $data->frequency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Report Send Email</label>
                            <input id="email" class="form-control" placeholder="" name="job_email"  value="{{$job->job_email}}" type="text" pattern="^[\W]*([\w+\-.%]+@[\w\-.]+\.[A-Za-z]{2,4}[\W]*;{1}[\W]*)*([\w+\-.%]+@[\w\-.]+\.[A-Za-z]{2,4})[\W]*$">
                        </div>
                    </div>
                </div>
                <h2 class="content-heading">Contract Info
					<img style="width:28px" src="../image/images/icons/{{$job->contract_icon}}" />
					
				</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Start Date and Finish Date
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" placeholder="From" name="start_time" value="{{$job->start_time}}">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="To" name="finish_time" value="{{$job->finish_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Cancellation Date
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="cancel_time" value="{{$job->cancel_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Activition Date
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="active_time" value="{{$job->active_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Suspension Date
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="inactive_time" value="{{$job->inactive_time}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Contract Price
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="example-text-input">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control text-center" id="example-group1-input3" name="price"
                                    placeholder="" value="{{$job->price}}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="content-heading">Owner Details</h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Owner Details about <span style="color:green;">{{$job->job_name}}</span>
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="example-text-input">Contact Details</label>
                            <input type="text" class="form-control" placeholder="" name="job_contact_details" value="{{$job->job_contact_details}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Contact Phone</label>
                            <input type="text" class="form-control" placeholder="" name="tel_phone" value="{{$job->tel_phone}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Owners Details</label>
                            <input type="text" class="form-control" placeholder="" name="job_owner_details" value="{{$job->job_owner_details}}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Bootstrap Datepicker -->

    <!-- Bootstrap Colorpicker (.js-colorpicker class is initialized in Helpers.colorpicker()) -->
    <!-- For more info and examples you can check out https://github.com/itsjavi/bootstrap-colorpicker/ -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Map</h3>
        </div>
        <div class="block-content">

        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection
