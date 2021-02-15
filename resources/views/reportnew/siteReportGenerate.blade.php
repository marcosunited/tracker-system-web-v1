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
        <img src="/image/images/logobig.png" align="center" width="400">
    </div>

    <table width="100%" border="0">
        <tr>
            <td class="postal">A.C.N 082 447 658</td>
            <td class="postal">ABN 81 082 447 658</td>
            <td class="postal">
                <div style="">
                    Postal Address:<br> P.O.Box 280<br> KEW VIC 3101<br> Telephone: (03)9687 9099
                </div>
            </td>
        </tr>
    </table>

    <h1>Site Report: <?=$job["job_name"]?></h1>


    <table width="100%" border="1" style="border-collapse:collapse">
        <tr>
            <td><strong>TO:</strong></td>
            <td>
                {{$agent->first()->agent_name}}
            </td>
            <td><strong>Fax No.:</strong></td>
            <td>
                {{$agent->first()->agent_fax}}
            </td>
        </tr>
        <tr>
            <td><strong>Attention:</strong></td>
            <td>
                {{$agent->first()->agent_phone}}
            </td>
            <td><strong>No. Of pages:</strong></td>
            <td>One</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>
            {{date('d/m/Y H:i:s a', time())}}
            </td>
        </tr>
        <tr>
            <td><strong>From:</strong></td>
            <td>Matthew Sujevic</td>
            <td><strong>Our Ref:</strong></td>
            <td> <?=$job["job_number"]?></td>
        </tr>
        <tr>
            <td><strong>Subject:</strong></td>
            <td>Monthly Reports</td>
            <td><strong>Premises:</strong></td>
            <td>
                <?=$job["job_address"]?>
            </td>
        </tr>
    </table>

    <div id="disclaimer">
        This document is confidential. It is intended exclusively for the use of the addressee. Any form of disclosure
        is unauthorised. Please advise the sender if you recieve this in error. Your reasonable cost in advising us of
        the error will be reimbursed.
    </div>

    <div id="dear">
        Dear
        <?=$job["job_contact_details"]?>,
        <p>Please find detailed below a list of the calls and routine maintenance we attended between
            <b><?=date($start_date)?></b> and <b><?=date($end_date)?></b>.</p>
    </div>


    <div style="text-align:center;margin:10px;">
        <h1>Callouts</h1>
    </div>

    <table width="95%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0" id="maintable">
        <thead>
            <tr>
                <td align="center" width="200px">Date</td>
                <td align="center" width="150px">Lifts</td>
                <td align="center" width="200px">Fault Reported</td>
                <td align="center" width="200px">Tech Reported Fault</td>
                <td align="center">Tech Description</td>
                <td align="center">Order Number</td>
                <td align="center" width="100px">Technician</td>
            </tr>
        </thead>
        <tbody>
            @foreach($final_callouts as $callout)
            <tr>
                <td align="center">
                {{date('Y-m-d',strtotime($callout['callout']->callout_time))}}
                </td>
                <td align="center">
                {{$callout['lift']}}
                </td>
                <td align="center">
                    {{$callout['callout']->fault_name}}
                </td>
                <td align="center">
                    {{$callout['callout']->technician_fault_name}}
                </td>

                <td align="center">
                    <div style="margin-left:5px;margin-right:5px">
                        {{$callout['callout']->tech_description}}
                    </div>
                </td>
                <td align="center">
                    {{$callout['callout']->order_number}}
                </td>
                <td align="center" width="15%">
                    {{$callout['callout']->technician_name}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align:center;margin:10px;">
        <h1>Maintenance</h1>
    </div>

    <table width="95%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0" id="maintenancetable">
        <thead>
            <tr>
                <th align="center">Date</th>
                <th align="center">Job No</th>
                <th align="center">Job Address</th>
                <th align="center">Lifts</th>
                <th align="center">Technician</th>
                <th align="center">Tech Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $maintenance)
            <tr>
                <td align="center">
                    {{date($maintenance->maintenance_date)}}
                </td>
                <td align="center">
                    {{$maintenance->job_number}}
                </td>

                <td align="center">
                    {{$maintenance->job_address_number}}
                    {{$maintenance->job_address}}
                    {{$maintenance->job_suburb}}
                </td>
                <td align="center">
                    {{$maintenance->lift_id}}
                </td>
                <td align="center">
                    {{$maintenance->technician_name}}

                </td>
                <td align="center">
                    {{$maintenance->maintenance_note}}
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
    $(document).ready(function () {
        $('#maintable').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Export table ULS Tracker'
            }, ],
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#maintenancetable').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Export table ULS Tracker'
            }, ],
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });

</script>
