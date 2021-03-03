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
<script src="{{ asset('js/plugins/checklifttask/lifttask.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/datetime.min.js') }}"></script>


<script>
    $(document).ready(function() { $(".job_select").select2(); });
    $(document).ready(function() { $(".tech_select").select2(); });
    $(document).ready(function() { $(".lift_select").select2({
        multiple: true,
    }); });
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

        $('#checkall1').change(function(){
            $('.checkitem1').prop("checked", $(this).prop("checked"))
        });
   });
</script>

<script>
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#liftcheck").click(function(){
            $.ajax({
                /* the route pointing to the post function */
                url: '/maintenances/selecttasks',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN,
                        message:$(".lift_select").select2("val")},
                dataType: 'JSON',
            });

            //Session::put('selectedJob',$(".job_select").select2("val"));
            //$selectedJob = Session::get('selectedJob');
            //window.location.reload(true);
            $( "#where" ).load(window.location.href + " #where" );
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
            <form action="/Fmaintenances/add" method="POST">
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
                            <label for="example-text-input">Lift:Refresh the page While getting Task</label>
                            <button style="float:right;" type="button" class="btn btn-warning" id="liftcheck">Check
                                Tasks</button>
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
                <div id="where">
                    @if($selectlifts)
                    <h2 class="content-heading">Task Info</h2>
                    <div class="col-lg-12">
                        <!-- Block Tabs Default Style -->
                        <div class="block block-rounded block-bordered">
                            <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#btabs-static-jan">Janurary</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-feb">Februry</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-mar">March</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-apr">April</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-may">May</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-june">June</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-july">July</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-aug">August</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-sep">September</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-oct">Octubar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-nov">Novenber</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#btabs-static-dec">December</a>
                                </li>
                            </ul>
                            <div class="block-content tab-content">
                                <div class="tab-pane active" id="btabs-static-jan" role="tabpanel">
                                    <h4 class="font-w400">Jan Task</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center"><input type="checkbox" id="checkall1">Check All</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks1 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-feb" role="tabpanel">
                                    <h4 class="font-w400">Feb Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks2 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-mar" role="tabpanel">
                                    <h4 class="font-w400">Mar Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks3 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-apr" role="tabpanel">
                                    <h4 class="font-w400">Apr Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks4 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-may" role="tabpanel">
                                    <h4 class="font-w400">May Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks5 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-june" role="tabpanel">
                                    <h4 class="font-w400">June Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks6 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-july" role="tabpanel">
                                    <h4 class="font-w400">July Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks7 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-aug" role="tabpanel">
                                    <h4 class="font-w400">Aug Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks8 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-sep" role="tabpanel">
                                    <h4 class="font-w400">Sep Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks9 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-oct" role="tabpanel">
                                    <h4 class="font-w400">Oct Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks10 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-nov" role="tabpanel">
                                    <h4 class="font-w400">Nov Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks11 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
                                                    <label class="custom-control-label" for="example-cb-custom-square-lg{{$task->task_id}}"></label>
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="btabs-static-dec" role="tabpanel">
                                    <h4 class="font-w400">Dec Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        @foreach($selecttasks12 as $task)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                    <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg{{$task->task_id}}"
                                                        name="task[]" value="{{$task->task_id}}">
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
                        @endif
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection
