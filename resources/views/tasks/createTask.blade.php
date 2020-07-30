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
<!-- Page JS Helpers (BS Notify Plugin) -->
<script>jQuery(function(){ Dashmix.helpers('notify'); });</script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>
<script>
    $(document).ready(function() { $(".month_select").select2(); });
    $(document).ready(function() { $(".task_type").select2(); });
</script>
@endsection

@section('content')
<!-- Page Content -->
@include('error.error')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Add:</span>&nbsp&nbsp<h3 class="block-title">New Task</h3>
        </div>
        <div class="block-content">
            <form action="/tasks" method="POST">
            @csrf
                <h2 class="content-heading pt-0">Basic
                <div class="input-group-append" style="float:right;">
                    <button type="submit" class="btn btn-hero-primary">Add Task</button>
                </div>
                </h2>
                <div class="row push">
                    <div class="col-lg-8" style="padding-left: 50px;">                      
                        <div class="form-group">
                            <label for="example-text-input">Task Name</label>
                            <input type="text" class="form-control input {{$errors->has('title') ? 'is-danger' : ''}}" placeholder="" name="task_name" required>
                        </div>                                              
                    </div>                   
                    <div class="col-lg-4" style="padding-left: 50px;">                      
                        <div class="form-group">
                            <label for="example-text-input">Task Type</label>
                            <select  class="form-control task_type " name="task_type" required>
                                <option value="L">Lift Task</option>
                                <option value="E">Escalator Task</option>
                            </select>
                        </div>                                              
                    </div>                   

                </div>  
                <h2 class="content-heading pt-0">Schedule</h2>
                <div class="row push">
                    <div class="col-lg-12" style="padding-left: 50px;">                      
                        <div class="form-group">
                            <label for="example-text-input">Monthly</label>
                            <select id="months_select" class="form-control month_select multiple" name="task_months[]" required multiple="multiple">
                                <option value="1">January</option>
                                <option value="2">Feburary</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">Agust</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>                                              
                    </div>                   
                </div>                  
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".month_select").select2({ multiple:true});
    });
</script>
<!-- END Page Content -->
@endsection
