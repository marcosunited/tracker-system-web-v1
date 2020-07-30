<script src="{{ mix('js/dashmix.app.js') }}"></script>

<!-- Laravel Scaffolding JS -->
<script src="{{ mix('js/laravel.app.js') }}"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js">
</script>

<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>

<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="/image/images/logobig.png" align="center" width="400">
    </div>

    <table width="100%" border="0" align="center">
        <tr>
            <td class="postal">A.C.N 082 447 658</td>
            <td class="postal">ABN 81 082 447 658</td>
            <td class="postal">
                <div style="">
                    Postal Address:<br> P.O.Box 280<br> KEW VIC 3101<br> Telephone: 9687 9099<br> Facsimile: 9687 9094
                </div>
            </td>
        </tr>
    </table>

    <h1>Group Report: {{$group_name}}</h1>
    <div style="text-align:center;margin:10px;">
        <h1>Callouts</h1>
    </div>
    <div style="text-align:center;margin:10px;">
        <b>Period Starting:</b>
        <?=date("d/M/Y",$start_date)?> <b>Till</b>
        <?=date("d/M/Y",$end_date)?>
    </div>

    {{\AppHelper::instance()->grapher(count($callouts),$faults)}}

    <table width="95%" border="1" style="border-collapse:collapse" id="table-g" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time of Call</th>
                <th>Arrived</th>
                <th>Finished</th>
                <th>Job No</th>
                <th>Site Name</th>
                <th>Lift Names</th>
                <th>Order Number</th>
                <th>Docket No</th>
                <th>Call Description</th>
                <th>Tech Fault</th>
                <th>Tech Description</th>
                <th>Technician</th>
                <th>Response Time Exceeded</th>
            </tr>
        </thead>
        <tbody>
            @foreach($callouts as $callout)
            <tr>
                <td>
                    {{date("d/m/y",$callout->callout_time)}}
                </td>
                <td>
                    {{\AppHelper::instance()->toTime($callout->callout_time)}}
                </td>

                <td>
                    {{\AppHelper::instance()->toTime($callout->time_of_arrival)}}
                </td>
                <td>
                    {{\AppHelper::instance()->toTime($callout->time_of_departure)}}
                </td>
                <td>
                    {{$callout->job_number}}
                </td>
                <td>
                    {{$callout->job_name}}

                </td>
                <td>
                    {{\AppHelper::instance()->liftNames($callout->lift_ids)}}
                </td>
                <td>
                    {{$callout->order_number}}

                <td>
                    {{$callout->docket_number}}
                </td>
                <td>
                    {{$callout->fault_name}}&nbsp;</td>

                <td>

                    {{$callout->technician_fault_name}}&nbsp;
                </td>
                <td>
                    {{$callout->tech_description}}
                </td>

                <td>
                    {{$callout->technician_name}}
                </td>
                <td>
                    No
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h1 id="maintenance">Maintenance</h1>
    <table width="95%" border="1" style="border-collapse:collapse" id="maintable2">
        <thead>
            <tr>
                <th>Date</th>
                <th>Job No</th>
                <th>Job Address</th>
                <th>Lifts</th>
                <th>Technician</th>
                <th>Tech Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $maintenance)
            <tr>
                <td>
                    {{date("d/m/y",$maintenance->maintenance_date)}}
                </td>
                <td>
                    {{$maintenance->job_number}}
                </td>

                <td>
                    {{$maintenance->job_address_number}}
                    {{$maintenance->job_address}}
                    {{$maintenance->job_suburb}}
                </td>
                <td>
                    {{\AppHelper::instance()->liftNames($maintenance->lift_ids)}}
                </td>
                <td>
                    {{$maintenance->technician_name}}

                </td>
                <td>
                    {{$maintenance->maintenance_notes}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



    <div style="text-align:center;padding-top:20px;">
        <b>Printed:</b>
        {{\AppHelper::instance()->toDateTime(time())}}
    </div>

    <style>
        body {
            margin: 0px;
            font-size: 12px;
        }

        td {
            font-size: 12px;
            text-align: center;
        }

        th {
            font-weight: bold;
            font-size: 12px;
        }

        * {
            font-family: sans-serif;
        }

        #topbar,
        #topbar a {
            background-color: blue;
            color: #fff;
            padding: 5px;
            background: #7abcff;
            /* Old browsers */
            background: -moz-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7abcff), color-stop(44%, #60abf8), color-stop(100%, #4096ee));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* IE10+ */
            background: linear-gradient(to bottom, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* W3C */
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#7abcff', endColorstr='#4096ee', GradientType=0);
            /* IE6-9 */
        }

        #logo {
            text-align: center;
            padding: 10px;
        }

        #disclaimer {
            padding-top: 10px;
        }

        #dear {
            padding-bottom: 10px;
        }

        .postal {
            font-weight: bold;
            text-align: center;
            vertical-align: top;
        }

        .address {
            width: 200px;
            text-align: left;
        }

        h1 {
            text-align: center;
            font-size: 28px;
        }

        #disclaimer {
            margin: 10px 0px 10px 0px;
        }

        a {
            color: #000;
            text-decoration: none
        }

    </style>
</div>
<!--End Print Area!-->



<script>
    $(document).ready(function () {
        $("#printPdf").click(function () {
            $myVar = $("#printArea").html();
            $("#frm_contents").val($myVar);
            $("#printForm").submit();
        });
    });

</script>

<script>
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var ukDatea = a.split('-');
            return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
        },

        "date-uk-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

</script>
<script>
    $(document).ready(function () {
        $('#table-g').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#maintable2').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });
</script>

<script>
    $("#hide").click(function () {
        $("#maintable2,#maintenance,#hide,#show").hide("slow", function () {
            alert("Hide complete.");
        });
    });

</script>
<script>
    $("#show").click(function () {
        $("#maintable2,#maintenance").show("slow", function () {
            alert("Show complete.");
        });
    });

</script>


