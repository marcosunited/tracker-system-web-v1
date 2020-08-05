<script src="{{ mix('js/dashmix.app.js') }}"></script>

<!-- Laravel Scaffolding JS -->
<script src="{{ mix('js/laravel.app.js') }}"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>

<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>

<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="/image/images/logobig.png" align="center" width="400">>
    </div>

    <h1>Period Callout Report: {{ $start_date }} to {{ $end_date }}</h1>
    <input id="startDate" type="hidden" value="{{ $start_date }}">
    <input id="endDate" type="hidden" value="{{ $end_date }}">

    <table width="100%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0" id="maintable">
        <thead>
            <tr>
                <td align="center"><strong>Job No</strong></td>
                <td align="center"><strong>Job Name</strong></td>
                <td align="center"><strong>Callout Description</strong></td>
                <td align="center"><strong>Date Of Call</strong></td>
                <td align="center"><strong>Time Of Call</strong></td>
                <td align="center"><strong>Lift Number</strong></td>
                <td align="center"><strong>Docket No</strong></td>
                <td align="center"><strong>Chargeable</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach($final_callouts as $callout)
            <tr>
                <td>{{$callout['callout']->job_number}}</td>
                <td>{{$callout['callout']->job_name}}</td>
                <td>{{$callout['callout']->callout_description}}</td>
                <td>{{date('Y-m-d',strtotime($callout['callout']->callout_time))}}</td>
                <td>{{$callout['callout']->callout_time}}</td>
                <td>
                    {{$callout['lift']}}
                </td>
                <td>{{$callout['callout']->docket_number}}</td>
                <td>
                    @if($callout['callout']->chargeable_id == 1)
                    Yes
                    @else
                    No
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        body {
            margin: 0px;
            font-size: 12px;
        }

        td {
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
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7abcff', endColorstr='#4096ee', GradientType=0);
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
    $(document).ready(function() {
        $("#printPdf").click(function() {
            $myVar = $("#printArea").html();
            $("#frm_contents").val($myVar);
            $("#printForm").submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#maintable').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'copy'
            }, {
                extend: 'excel',
                title:'Period callout report: ' + $('#startDate').val() + '-' + $('#endDate').val()
            }],
            columnDefs: [{
                type: 'date-dd-mmm-yyyy',
                targets: 3
            }],


        });
    });
</script>