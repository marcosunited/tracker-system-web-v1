@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
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
    $(document).ready(function () {
        $(".job_select").select2();
    });
    $(document).ready(function () {
        $(".tech_select").select2();
    });
    $(document).ready(function () {
        $(".lift_select").select2();
    });

</script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".job_select").change(function () {
            $.ajax({
                /* the route pointing to the post function */
                url: '/callouts/selectedJob',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    message: $(".job_select").select2("val")
                },
                dataType: 'JSON',
                success:function(data) {
                    $('.lift_select').empty();  
                    for (var i=0;i<data.length;i++) {     
                        var html='<option value="'+data[i]['id']+'" data-type="'+data[i]['lift_type']+'">'+data[i]['lift_name']+'('+data[i]['lift_type']+')'+'</option>';           
                        $(".lift_select").append(html);             
                    }        
                    $('.lift_select').select2();  
                },
                failure:function() {

                }
            });

        });

        $('#checkall1').change(function () {
            $('.checkitem1').prop("checked", $(this).prop("checked"))
        });
    });

</script>
<script>
    $(document).ready(function () {
        function getMonthName(i) {
            switch (i) {
                case 0: return "January"; break;
                case 1: return "Feburary";break;
                case 2: return "March";break;
                case 3: return "April";break;
                case 4: return "May";break;
                case 5: return "June";break;
                case 6: return "July";break;
                case 7: return "August";break;
                case 8: return "September";break;
                case 9: return "October";break;
                case 10: return "November";break;
                case 11: return "December";      break;                                          
            }
        }
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#liftcheck").click(function () {
            $.ajax({
                /* the route pointing to the post function */
                url: '/maintenances/selecttasks',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    message: $(".lift_select").select2("val")
                },
                dataType: 'JSON',
                success:function(data) {          
                    $('#task_info_panel').empty();
                    for (i=0;i<data.length;i++) {
                        var html='';
                        var active_pan = '';
                        if (i==0) active_pan = 'active';
                        html='<div class="tab-pane' +active_pan+'" id="btabs-static-'+i+'">';
                            html+='<h4 class="font-w400">' + getMonthName(i) +' Task</h4>';
                            html+='<table class="table table-bordered table-striped table-vcenter">';
                                html+='<thead>';
                                    html+='<tr>';
                                        html+='<th class="text-center">Task Name</th>';
                                        html+='<th class="text-left">';
                                        html+='<div ';
                                                html+='class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">';
                                                html+='<input type="checkbox" class="custom-control-input checkitem1 example-cb-custom-square-selectall"';
                                                    html+='id="example-cb-custom-square-selectall_'+i;
                                                    html+='">';
                                                html+='<label class="custom-control-label"';
                                                    html+='for="example-cb-custom-square-selectall_'+i+'">Select All</label>';
                                            html+='</div>';                                                                                
                                        html+='</th>';
                                    html+='</tr>';
                                html+'</thead>';
                                var one_month = data[i];
                                html+='<tbody>';
                                for (var j=0;j<one_month.length;j++) {
                                    html+='<tr>';
                                        html+='<td>';
                                            html+=one_month[j]['task_name'];
                                        html+='</td>';
                                        html+='<td>';
                                            html+='<div ';
                                                html+='class="custom-control custom-checkbox custom-checkbox-square custom-control-lg custom-control-primary mb-1">';
                                                html+='<input type="checkbox" class="custom-control-input checkitem1"';
                                                    html+='id="example-cb-custom-square-lg_'+i+'_'+j+'"';
                                                    html+='name="task_month'+(i+1)+'[]" value="'+one_month[j]['task_id']+'">';
                                                html+='<label class="custom-control-label"';
                                                    html+='for="example-cb-custom-square-lg_'+i+'_'+j+'"></label>';
                                            html+='</div>';
                                        html+='</td>';
                                    html+='</tr>';
                                }
                                html+='</tbody>';
                            html+='</table>';
                        html+='</div>';
                        $('#task_info_panel').append(html);
                    }               
                },
                failure:function() {

                }
            });        
        });

        $(document).on('change','.example-cb-custom-square-selectall',function(){
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
    });

</script>
<script>
    function change(month) {
        var selected = month;
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

        if (selected === '1') {
            jan.style.display = "block";
        } else {
            jan.style.display = "none";
        }
        if (selected === '2') {
            feb.style.display = "block";
        } else {
            feb.style.display = "none";
        }
        if (selected === '3') {
            mar.style.display = "block";
        } else {
            mar.style.display = "none";
        }
        if (selected === '4') {
            apr.style.display = "block";
        } else {
            apr.style.display = "none";
        }
        if (selected === '5') {
            may.style.display = "block";
        } else {
            may.style.display = "none";
        }
        if (selected === '6') {
            june.style.display = "block";
        } else {
            june.style.display = "none";
        }
        if (selected === '7') {
            july.style.display = "block";
        } else {
            july.style.display = "none";
        }
        if (selected === '8') {
            aug.style.display = "block";
        } else {
            aug.style.display = "none";
        }
        if (selected === '9') {
            sep.style.display = "block";
        } else {
            sep.style.display = "none";
        }
        if (selected === '10') {
            oct.style.display = "block";
        } else {
            oct.style.display = "none";
        }
        if (selected === '11') {
            nov.style.display = "block";
        } else {
            nov.style.display = "none";
        }
        if (selected === '12') {
            dec.style.display = "block";
        } else {
            dec.style.display = "none";
        }
      
    }
</script>


<!-- Page JS Helpers (BS Notify Plugin) -->

<script>
    jQuery(function () {
        Dashmix.helpers('notify');
    });

</script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>
    jQuery(function () {
        Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']);
    });

</script>
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
            <span class="badge badge-pill badge-success">Add:</span>&nbsp&nbsp<h3 class="block-title">New Maintenance
            </h3>
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
                            <label for="example-text-input">Lift: Click button to getting Task</label>
                            <select class="form-control lift_select col-md-8" name="lift_id" required>
                            </select>
                            <button style="float:right;" type="button" class="btn btn-warning offset-md-1 col-md-3" id="liftcheck">Get Tasks</button>                            
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
                                <option value="{{ $data->id }}">{{ $data->technician_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div id="where">

                    <h2 class="content-heading">Task Info</h2>
                    <div class="col-lg-12">
                        <div class="block block-rounded block-bordered">
                            <select id="active_month" name="active_month" class="form-control" onchange="change(this.value)">
                                <option value="">Select montly tasks:</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>    
                        <div class="block-content" id="task_info_panel">
                           
                        </div>                     
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- END Page Content -->
@endsection

