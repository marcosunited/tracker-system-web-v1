<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="">

<head>
    <title></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <br />
    <style type="text/css">
        body {
            font-size: 20.1px;
            margin: 0px;
        }

        .pos {
            position: absolute;
            z-index: 0;
            left: 0px;
            top: 0px
        }

        p {
            margin: 0;
            padding: 0;
        }

        .ft13 {
            font-size: 12px;
            font-family: sans-serif;
            color: #000000;
        }

        .ft14 {
            font-size: 20px;
            font-family: sans-serif;
            color: #003591;
        }

        .ft15 {
            font-size: 12px;
            font-family: sans-serif;
            color: #e07900;
        }

        .ft17 {
            font-size: 12px;
            font-family: sans-serif;
            color: #000000;
        }

        .ft18 {
            font-size: 13px;
            font-family: sans-serif;
            color: #000000;
        }

        .ft19 {
            font-size: 13px;
            font-family: sans-serif;
            color: #e07900;
        }
    </style>

    <script src="{{ mix('js/dashmix.app.js') }}"></script>
    <script src="{{ mix('js/laravel.app.js') }}"></script>
</head>

<body>
    <div id="page1-div" style="position:relative;width:980px;height:650px;">
        <img width="980" height="640" src="http://cloud.unitedlifts.com.au:8070/image/custom-reports/checklist-001.png" alt="background image" />
        <p style="position:absolute;top:100px;left:50px;white-space:nowrap" class="ft14"><b>Inspection and Test Plan Checklist</b></p>
        <p style="position:absolute;top:100px;left:600px;white-space:nowrap" class="ft14"><b>2.2.10 – Passenger Lifts</b></p>
        <p style="position:absolute;top:136px;left:400px;white-space:nowrap" class="ft15"><b>Inspection and Test Plan – CHECKLIST</b></p>
        <p style="position:absolute;top:146px;left:300px;white-space:nowrap" class="ft15"><b>(To be completed by the person(s) directly responsible for the work - Supervisor)</b></p>
        <p style="position:absolute;top:166px;left:55px;white-space:nowrap" class="ft17"><b>Contract Name:</b>Whole of Government Facilities Management Services Contract</p>
        <p style="position:absolute;top:166px;left:555px;white-space:nowrap" class="ft17"><b>ContractNo.: </b>{{$maintenance->lifts->contract_group_id == '2' ? '7061005' : '7061007' }}</p>
        <p style="position:absolute;top:190px;left:55px;white-space:nowrap" class="ft17"><b>Facility/Site:</b><span style="font-weight:normal"> {{$maintenance->job_name}} </span></p>
        <p style="position:absolute;top:190px;left:555px;white-space:nowrap" class="ft17"><b>Category of Work: 2.2.10 Passenger Lifts</b></p>
        <p style="position:absolute;top:212px;left:55px;white-space:nowrap" class="ft17"><b>Contractor:</b> United Lift Services</p>
        <p style="position:absolute;top:212px;left:555px;white-space:nowrap" class="ft17"><b>Competent Person:</b> <span style="font-weight:normal"> {{$maintenance->techs->technician_name}}</span></p>

        <p style="position:absolute;top:252px;left:80px;white-space:nowrap" class="ft19"><b>WORK</b></p>
        <p style="position:absolute;top:252px;left:190px;white-space:nowrap" class="ft19"><b>ITEMS/ACTIVITIES TO BE VERIFIED </b></p>
        <p style="position:absolute;top:238px;left:470px;white-space:nowrap" class="ft19"><b>TICK THE </b></p>
        <p style="position:absolute;top:250px;left:466px;white-space:nowrap" class="ft19"><b>RELEVANT</b></p>
        <p style="position:absolute;top:262px;left:484px;white-space:nowrap" class="ft19"><b>BOX</b></p>
        <p style="position:absolute;top:252px;left:680px;white-space:nowrap" class="ft19"><b>COMMENTS/DEFECTS</b></p>

        <p style="position:absolute;top:340px;left:68px;white-space:nowrap" class="ft18">PRE-WORK</p>
        <p style="position:absolute;top:356px;left:52px;white-space:nowrap" class="ft18">REQUIREMENTS</p>
        <p style="position:absolute;top:500px;left:56px;white-space:nowrap" class="ft18">EXECUTION OF</p>
        <p style="position:absolute;top:516px;left:64;white-space:nowrap" class="ft18">WORK</p>

        <?php
        $index = 0;
        $style_tops_first = array(
            array(1, 292),
            array(2, 314),
            array(3, 336),
            array(4, 354),
            array(5, 386),
            array(6, 418),
            array(7, 464),
            array(8, 496),
            array(9, 526),
            array(10, 560),
            array(11, 582),
            array(12, 604)
        );

        ?>
        @if(count($checklist) > 0)

        @foreach($checklist as $activity)

        @if($activity->id <= 12) <p style="position:absolute;top:<?= $style_tops_first[$index][1] ?>px;left:164px;width: 280px;
                                            height: auto;
                                            display: block;
                                            word-break: break-word;
                                            white-space: break-spaces;
                                            text-overflow: ellipsis;" class="ft13">
            {{$activity->name}}
            </p>
            <p style="position:absolute;top:<?= $style_tops_first[$index][1] ?>px;left:500px;white-space:nowrap" class="ft13">
                @if($activity->value == 1)
                <span style="font-family:'DeJaVu Sans Mono',monospace;font-size:14px;">✓</span>
                @endif
            </p>

            <?php
            $index++;
            ?>
            @endif
            @endforeach
            @endif

            <div class="pos" id="_98:1110" style="position:absolute;top:642px;left:50px;white-space:nowrap;font-family: sans-serif;">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Page <span style="font-weight:bold"> 1</span> of <span style="font-weight:bold"> 1</span></span>
            </div>
            <div class="pos" id="_523:1110" style="position:absolute;top:642px;left:737px;white-space:nowrap;font-family: sans-serif;">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    OPS-ITP-2.2.10-AMC- Inspection and Test Plan</span>
            </div>
            <div class="pos" id="_598:1123" style="position:absolute;top:654px;left:816px;white-space:nowrap;font-family: sans-serif;">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Document Control by Operations</span>
            </div>
            <div class="pos" id="_337:1136" style="position:absolute;top:654px;left:405px;white-space:nowrap;font-family: sans-serif;">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Facilites First Australia Pty Ltd</span>
            </div>
            <div class="pos" id="_639:1136" style="position:absolute;top:666px;left:867px;white-space:nowrap;font-family: sans-serif;">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Issue Date: May 2020</span>
            </div>

    </div>

    <div id="page2-div" style="position:relative;width:980px;height:640px;">
        <img width="980" height="640" src="http://cloud.unitedlifts.com.au:8070/image/custom-reports/checklist-002.png" alt="background image" />
        <p style="position:absolute;top:460px;left:54px;white-space:nowrap" class="ft18">PRE-HANDOVER</p>
        <p style="position:absolute;top:476px;left:70px;white-space:nowrap" class="ft18">ACTIVITIES</p>

        <?php
        $index = 0;
        $style_tops_second = array(
            array(13, 114),
            array(14, 138),
            array(15, 160),
            array(16, 190),
            array(17, 226),
            array(18, 250),
            array(19, 300),
            array(20, 370),
            array(21, 410),
            array(22, 532)
        );

        ?>

        @if(count($checklist) > 0)

        @foreach($checklist as $activity)

        @if($activity->id > 12) <p style="position:absolute;top:<?= $style_tops_second[$index][1] ?>px;left:164px;width: 280px;
                                    height: auto;
                                    display: block;
                                    word-break: break-word;
                                    white-space: break-spaces;
                                    text-overflow: ellipsis;" class="ft13">
            {{$activity->name}}
        </p>
        <p style="position:absolute;top:<?= $style_tops_second[$index][1] ?>px;left:500px;" class="ft13">
            @if($activity->value == 1)
            <span style="font-family:'DeJaVu Sans Mono',monospace;font-size:14px;">✓</span>
            @endif
        </p>

        <?php
        $index++;
        ?>
        @endif
        @endforeach
        @endif



        <p style="position:absolute;top:560px;left:55px;white-space:nowrap" class="ft13"><b>I have carried out all necessary inspections and verify that the <br />above items/activities conform to the contract specifications and <br />are in accordance with the relevant Australian standards and <br />manufacturers recommendations</b></p>
        <p style="position:absolute;top:562px;left:460px;white-space:nowrap" class="ft13"><b>Name:</b> <span style="font-weight:normal"> {{$maintenance->techs->technician_name}}</span></p>

        <p style="position:absolute;top:584px;left:460px;white-space:nowrap" class="ft13"><b>Signature:</b> <span style="font-weight:normal"> {{$maintenance->techs->technician_name}}</span></p>
        <p style="position:absolute;top:606px;left:460px;white-space:nowrap" class="ft13"><b>Date:</b> <span style="font-weight:normal"> {{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y')}}</span></p>

        <div class="pos" id="_98:1110" style="position:absolute;top:642px;left:50px;white-space:nowrap;font-family: sans-serif;">
            <span id="_11.0" style=" font-size:11.0px; color:#000000">
                Page <span style="font-weight:bold"> 1</span> of <span style="font-weight:bold"> 1</span></span>
        </div>
        <div class="pos" id="_523:1110" style="position:absolute;top:642px;left:737px;white-space:nowrap;font-family: sans-serif;">
            <span id="_11.0" style=" font-size:11.0px; color:#000000">
                OPS-ITP-2.2.10-AMC- Inspection and Test Plan</span>
        </div>
        <div class="pos" id="_598:1123" style="position:absolute;top:654px;left:816px;white-space:nowrap;font-family: sans-serif;">
            <span id="_11.0" style=" font-size:11.0px; color:#000000">
                Document Control by Operations</span>
        </div>
        <div class="pos" id="_337:1136" style="position:absolute;top:654px;left:405px;white-space:nowrap;font-family: sans-serif;">
            <span id="_11.0" style=" font-size:11.0px; color:#000000">
                Facilites First Australia Pty Ltd</span>
        </div>
        <div class="pos" id="_639:1136" style="position:absolute;top:666px;left:867px;white-space:nowrap;font-family: sans-serif;">
            <span id="_11.0" style=" font-size:11.0px; color:#000000">
                Issue Date: May 2020</span>
        </div>
    </div>

</body>

</html>