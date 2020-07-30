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
        @include('layouts.innerCalloutNav')
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
            <a href="/jobs/{{$callout->jobs->id}}"><button style="float:right;" type="button" class="btn btn-hero-warning">Update on this link</button></a>
        </div>
        <div class="block-content">
            <div class="input-group-append" style="float:right;">
                </div>
                <h2 class="content-heading pt-0">Basic</h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Status</label>
                            <select class="form-control" name="status_id" id="status_id" required disabled>
                                <option value="">--- Select Status ---</option>
                                @foreach ($status as $data)
                                <option value="{{ $data->id }}" @if($selectedStatus->id == $data->id) selected
                                    @endif>{{ $data->status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <input type="text" class="form-control input {{$errors->has('title') ? 'is-danger' : ''}}" placeholder="" name="job_name" value="{{$job->job_name}}" disabled>
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

                            <select disabled class="form-control" name="contract_id" id="contract_id">
                                <option value="">--- Select Contract ---</option>
                                @foreach ($contract as $data)
                                <option value="{{ $data->id }}" @if($selectedContract->id == $data->id) selected 
                                    @endif>{{ $data->contract_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Round</label>
                            <select disabled class="form-control" name="round_id" id="round_id" style="color:#fff;background-image:none;background-color:#{{$selectedRound->round_colour}}">
                                @foreach ($rounds as $data)
                                <option style="background-color:#{{$data->round_colour}};" value="{{ $data->id }}"
                                    @if($selectedRound->id == $data->id) selected @endif>{{ $data->round_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent</label>
                            <select disabled class="form-control" name="agent_id" id="agent_id">
                                <option value="">--- Select Agent ---</option>
                                @foreach ($agents as $data)
                                <option value="{{ $data->id }}" @if($selectedAgent->id == $data->id) selected @endif>{{
                                    $data->agent_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Floors</label>
                            <input  disabled  type="number" class="form-control" placeholder="Floor Input" value="{{$job->job_floors}}" name="job_floors">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Group</label>
                            <input disabled type="text" class="form-control" placeholder="Group input" value="{{$job->job_group}}" name="job_group">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-6" style="padding-left: 230px;">
                        <div class="form-group form-row">
                            <div class="col-4">
                                <label>Street No</label>
                                <input disabled type="text" class="form-control" value="{{$job->job_address_number}}" name="job_address_number">
                            </div>
                            <div class="col-8">
                                <label>Street Name</label>
                                <input disabled type="text" class="form-control" value="{{$job->job_address}}" name="job_address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Suburb</label>
                            <input disabled type="text" class="form-control" placeholder="Surburd Input" value="{{$job->job_suburb}}" name="job_suburb">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Agent Details</label>
                            <input disabled type="text" class="form-control" placeholder="Agent Input" value="{{$job->job_agent_contact}}" name="job_agent_contact">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Job Number</label>
                            <input disabled type="text" class="form-control" placeholder="Number Input" value="{{$job->job_number}}" name="job_number">
                        </div>
                        <div class="form-group">
                            <label for="example-textarea-input">Key Access</label>
                            <textarea  disabled class="form-control" rows="4" placeholder="Textarea content.." name="job_key_access">{{$job->job_key_access}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Visit Frequency</label>
                            <select disabled class="form-control" name="frequency_id" id="frequency_id">
                                <option value="">--- Select Frequency ---</option>
                                @foreach ($frequency as $data)
                                <option value="{{ $data->id }}" @if($selectedFrequency->id == $data->id) selected
                                    @endif>{{ $data->frequency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <h2 class="content-heading">Contract Details</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Start Date and Finish Date 
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input disabled type="text" class="form-control" placeholder="From" name="start_time" value="{{$job->start_time}}">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input disabled type="text" class="form-control" placeholder="To" name="finish_time" value="{{$job->finish_time}}">
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
                            <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input disabled type="text" class="form-control" name="cancel_time" value="{{$job->cancel_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Active Date 
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input disabled type="text" class="form-control" name="active_time" value="{{$job->active_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Inactive Date 
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-6">
                        <div class="form-group">
                            <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input disabled type="text" class="form-control" name="inactive_time" value="{{$job->inactive_time}}">
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="content-heading pt-0">Price</h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Basic Finiance information about <span style="color:green;">{{$job->job_name}}</span>
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
                                <input  disabled type="text" class="form-control text-center" id="example-group1-input3" name="job_price"
                                    placeholder="" value="{{$job->price}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">CPI</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        $
                                    </span>
                                </div>
                                <input disabled type="text" class="form-control text-center" id="example-group1-input3" name="cpi"
                                    placeholder="" value="{{$job->cpi}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">,00</span>
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
                            <input disabled type="text" class="form-control" placeholder="" name="job_contact_details" value="{{$job->job_contact_details}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Owners Details</label>
                            <input  disabled type="text" class="form-control" placeholder="" name="job_owner_details" value="{{$job->job_owner_details}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Contact Email</label>
                            <input disabled type="text" class="form-control" placeholder="" name="job_email" value="{{$job->job_email}}">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- END Bootstrap Datepicker -->

    <!-- Bootstrap Colorpicker (.js-colorpicker class is initialized in Helpers.colorpicker()) -->
    <!-- For more info and examples you can check out https://github.com/itsjavi/bootstrap-colorpicker/ -->

    <!-- END Dropzone -->
</div>

<!-- END Page Content -->
@endsection
