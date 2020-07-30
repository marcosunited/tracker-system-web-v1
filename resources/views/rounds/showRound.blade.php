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
        @include('layouts.innerRoundNav')
        <!-- END Main Navigation -->
    </div>
</div>
<!-- Page Content -->
<div class="content">
    <!-- Bootstrap Datepicker (.js-datepicker and .input-daterange classes are initialized in Helpers.datepicker()) -->
    <!-- For more info and examples you can check out https://github.com/eternicode/bootstrap-datepicker -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">{{$round->round_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/rounds/{{$round->id}}" method="POST">
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
                                <option value="1" @if($round->status_id == 1) selected @endif>Active</option>
                                <option value="2" @if($round->status_id == 2) selected @endif>InActive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Round Name</label>
                            <input type="text" class="form-control"  value="{{$round->round_name}}" name="round_name" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Round Colour</label>
                            <input type="text" class="form-control"  value="{{$round->round_colour}}" name="round_colour" required>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<!-- END Page Content -->
@endsection
