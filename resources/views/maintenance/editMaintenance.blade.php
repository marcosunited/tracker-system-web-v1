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
    $(document).ready(function() {
        $(".job_select").select2();
    });
    $(document).ready(function() {
        $(".tech_select").select2();
    });
    $(document).ready(function() {
        $(".lift_select").select2({});
    });


    function change(month) {
        var jan = document.getElementById("btabs-static-0");
        var feb = document.getElementById("btabs-static-1");
        var mar = document.getElementById("btabs-static-2");
        var apr = document.getElementById("btabs-static-3");
        var may = document.getElementById("btabs-static-4");
        var june = document.getElementById("btabs-static-5");
        var july = document.getElementById("btabs-static-6");
        var aug = document.getElementById("btabs-static-7");
        var sep = document.getElementById("btabs-static-8");
        var oct = document.getElementById("btabs-static-9");
        var nov = document.getElementById("btabs-static-10");
        var dec = document.getElementById("btabs-static-11");

        if (month == 1) {
            jan.style.display = "block";
        } else {
            jan.style.display = "none";
        }
        if (month == 2) {
            feb.style.display = "block";
        } else {
            feb.style.display = "none";
        }
        if (month == 3) {
            mar.style.display = "block";
        } else {
            mar.style.display = "none";
        }
        if (month == 4) {
            apr.style.display = "block";
        } else {
            apr.style.display = "none";
        }
        if (month == 5) {
            may.style.display = "block";
        } else {
            may.style.display = "none";
        }
        if (month == 6) {
            june.style.display = "block";
        } else {
            june.style.display = "none";
        }
        if (month == 7) {
            july.style.display = "block";
        } else {
            july.style.display = "none";
        }
        if (month == 8) {
            aug.style.display = "block";
        } else {
            aug.style.display = "none";
        }
        if (month == 9) {
            sep.style.display = "block";
        } else {
            sep.style.display = "none";
        }
        if (month == 10) {
            oct.style.display = "block";
        } else {
            oct.style.display = "none";
        }
        if (month == 11) {
            nov.style.display = "block";
        } else {
            nov.style.display = "none";
        }
        if (month == 12) {
            dec.style.display = "block";
        } else {
            dec.style.display = "none";
        }

    }

    $(document).ready(function() {
        var jobGroup = <?php echo '"' . $maintenance->jobs->job_group . '"' ?>;

        if (jobGroup && jobGroup !== '' && jobGroup == 'Facilities First')
            $('#menu-forms').removeClass('hidden');
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
<script>
    $(document).ready(function() {
        $(document).on('change', '.example-cb-custom-square-selectall', function() {
            //alert();
            if ($(this).is(":checked")) {
                var active_pan_table = $(this).closest('table');

                active_pan_table.find('tr').each(function() {
                    var checkbox = $(this).find('td:eq(1) input');
                    checkbox.prop('checked', true);
                });
            } else {
                var active_pan_table = $(this).closest('table');
                active_pan_table.find('tr').each(function() {
                    var checkbox = $(this).find('td:eq(1) input');
                    checkbox.prop('checked', false);
                });
            }
        })
    })
</script>
@endsection

@section('content')
<!-- Page Content -->

@section('content')
@include('error.error')
<div class="bg-white">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerMaintenanceNav')
        <!-- END Main Navigation -->
    </div>
</div>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">Edit:</span>&nbsp&nbsp<h3 class="block-title">Maintenance {{$maintenance->jobs->job_name}}</h3>
        </div>
        <div class="block-content">
            <form action="/maintenances/{{$maintenance->id}}" method="POST">
                {{method_field('PATCH')}}
                @csrf
                <h2 class="content-heading pt-0">Maintenance Details
                    <div class="input-group-append" style="float:right;">
                        <button type="submit" class="btn-hero-primary">Update Maintenance</button>
                    </div>
                </h2>
                <div class="row push">
                    <div class="col-lg-4" style="padding-left: 50px;">
                        <div class="form-group">
                            <label for="example-text-input">Job Name</label>
                            <select class="form-control job_select" name="job_id" required disabled>
                                <option value="">--- Select Job ---</option>
                                @foreach ($jobs as $data)
                                <option value="{{ $data->id }}" @if($maintenance->jobs->id == $data->id) selected @endif>{{
                                    $data->job_address_number }} {{
                                    $data->job_address }} {{ $data->job_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="there">
                            <label for="example-text-input">Lift</label>
                            <select class="form-control lift_select" name="lift_id" required>
                                @foreach ($lifts as $data)
                                <option value="{{ $data->id }}" @if($maintenance->lifts->id == $data->id) selected @endif>{{ $data->lift_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Maintenance Date</label>
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="maintenance_date" value="{{$maintenance->maintenance_date}}">
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
                                <option value="1" @if($maintenance->completed_id == 1) selected @endif>Pending</option>
                                <option value="2" @if($maintenance->completed_id == 2) selected @endif>Completed</option>
                            </select>
                        </div>
                        <div class="form-group" id="here">
                            <label for="example-text-input">Technician</label>
                            <!-- <button style="float:right;" type="button" id="techcheck" class="btn btn-warning">Check Tech</button> -->
                            <select class="form-control tech_select" name="technician_id" required>
                                <option value="">--- Select Technician ---</option>
                                @foreach ($technicians as $data)
                                <option value="{{ $data->id }}" @if($maintenance->techs->id == $data->id) selected
                                    @endif>{{ $data->technician_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div id="where">
                    <h2 class="content-heading">Task Info</h2>
                    <div class="col-lg-12">
                        <!-- Block Tabs Default Style -->
                        <div class="block block-rounded block-bordered">
                            <select id="active_month" name="active_month" class="form-control" onchange="change(this.value)">
                                <option value="">Select montly tasks:</option>
                                <option value="1" {{$selected_task_month==1?'selected':''}}>January</option>
                                <option value="2" {{$selected_task_month==2?'selected':''}}>February</option>
                                <option value="3" {{$selected_task_month==3?'selected':''}}>March</option>
                                <option value="4" {{$selected_task_month==4?'selected':''}}>April</option>
                                <option value="5" {{$selected_task_month==5?'selected':''}}>May</option>
                                <option value="6" {{$selected_task_month==6?'selected':''}}>June</option>
                                <option value="7" {{$selected_task_month==7?'selected':''}}>July</option>
                                <option value="8" {{$selected_task_month==8?'selected':''}}>August</option>
                                <option value="9" {{$selected_task_month==9?'selected':''}}>September</option>
                                <option value="10" {{$selected_task_month==10?'selected':''}}>October</option>
                                <option value="11" {{$selected_task_month==11?'selected':''}}>November</option>
                                <option value="12" {{$selected_task_month==12?'selected':''}}>December</option>
                            </select>
                            <div class="block-content tab-content">
                                @foreach ($selecttasks as $key=>$select_month_task)
                                @if ($key==$selected_task_month-1)
                                <div class="tab-pane {{$key==$selected_task_month-1?'active':''}}" id="btabs-static-{{$key}}" role="tabpane{{$key}}">
                                    <h4 class="font-w400">{{$months[$key]}} Tasks</h4>
                                    <table class="table table-bordered table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Task Name</th>
                                                <th class="text-left">
                                                    <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                        <input type="checkbox" class="custom-control-input checkitem1 example-cb-custom-square-selectall" id="example-cb-custom-square-selectall" />
                                                        <label class="custom-control-label" for="example-cb-custom-square-selectall">Select All</label>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($select_month_task as $jkey=>$task)
                                            <tr>
                                                <td>
                                                    {{$task->task_name}}
                                                </td>
                                                <td>
                                                    <?php
                                                    $task_arr = json_decode($maintenance->task_ids);
                                                    if (in_array($task->task_id, $task_arr->{$keymonth[$key]}))
                                                        $checked = 'checked';
                                                    else
                                                        $checked = '';
                                                    ?>
                                                    <div class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">
                                                        <input type="checkbox" class="custom-control-input checkitem1" id="example-cb-custom-square-lg_{{$key}}_{{$jkey}}" name="task_month{{($key+1)}}[]" value="{{$task->task_id}}" {{$checked}}>
                                                        <label class="custom-control-label" for="example-cb-custom-square-lg_{{$key}}_{{$jkey}}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection