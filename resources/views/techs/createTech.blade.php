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
<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<script>
$(document).ready(function(){
    $('#filephoto').change(function(){
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_photo').attr('src', e.target.result).css({width:'200px',height:'200px'});
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

})
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
            <span class="badge badge-pill badge-success">Add:</span>&nbsp&nbsp<h3 class="block-title">New Technician</h3>
        </div>
        <div class="block-content">
            <form action="/techs" method="POST" enctype="multipart/form-data">
                @csrf
                <h2 class="content-heading pt-0">Basic
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn btn-hero-primary">Add Tech</button>
                    </div>
                </h2>
                <div class="row">
                    <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input">Status</label>
                                <select class="form-control" name="status_id" id="status_id" required>
                                    <option value="">--- Select Status ---</option>
                                    <option value="1">Active</option>
                                    <option value="2">InActive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Technician Name</label>
                                <input type="text" class="form-control" name="technician_name" required>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Technician Phone</label>
                                <input type="text" class="form-control"  name="technician_phone" required>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Technician Email</label>
                                <input type="text" class="form-control"  name="technician_email" required>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Technician Password</label>
                                <input type="text" class="form-control"  name="technician_password" required>
                            </div>                        
                            <div class="form-group">
                                <label for="example-text-input">Round</label>
                                <select class="form-control" name="round_id" id="round_id" required>
                                <option value="">--- Select Round ---</option>
                                @foreach ($rounds as $data)                                    
                                <option style="background-color:#{{$data->round_colour}};" value="{{ $data->id }}">{{ $data->round_name }}</option>                                                      
                                @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input">Technician Avatar</label>
                            <input type="file" class="form-control" name="technician_photo" id="filephoto">
                        </div>
                        <div class="form-group">
                            <img id="preview_photo"/>
                        </div>
                    </div>                    
                </div>
            </form>
            
    </div>
</div>
</div>

<!-- END Page Content -->
@endsection
