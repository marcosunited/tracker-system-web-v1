<html>

<head>
    <title>Maintenance Schedule Record Log</title>
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

        * {
            font-family: sans-serif;
        }
    </style>

    <script src="{{ mix('js/dashmix.app.js') }}"></script>
    <script src="{{ mix('js/laravel.app.js') }}"></script>

</head>

<body>
    <nobr>
        <nowrap>
            <div class="pos" id="_0:0" style="top:0">
                <img name="_1170:827" src="http://cloud.unitedlifts.com.au:8070/image/custom-reports/maintenance_record_log.png" height="980" width="680" border="0" usemap="#Map">
            </div>
            <div class="pos" id="_98:141" style="top:100;left:30">
                <span id="_21.5" style="font-weight:bold; font-size:21.5px; color:#003490">
                    Maintenance Schedule Record Log </span>
            </div>
            <div class="pos" id="_334:179" style="top:134;left:200">
                <span id="_18.3" style="font-weight:bold; font-size:18.3px; color:#ffffff">
                    2.2.10 - Passenger Lifts </span>
            </div>
            <div class="pos" id="_96:206" style="top:155;left:30">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Region of Work: <span style="font-weight:normal"> {{$maintenance->lifts->contract_group_id == 1 ? 'South Western Sydney' : 'Northern Sydney' }} </span> </span>
            </div>
            <div class="pos" id="_421:206" style="top:155;left:260">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Zone of Work: <span style="font-weight:normal">{{$maintenance->lifts->zone }} </span></span>
            </div>
            <div class="pos" id="_96:230" style="top:173;left:30">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Facility / Site:<span style="font-weight:normal"> {{$maintenance->job_name}} </span></span>
            </div>
            <div class="pos" id="_96:253" style="top:188;left:30">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Facility Address:<span style="font-weight:normal"> {{$maintenance->job_address_number}} {{$maintenance->job_address}} {{$maintenance->job_suburb}} </span></span>
            </div>
            <div class="pos" id="_96:276" style="top:205;left:30">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Assessment By:<span style="font-weight:normal"> {{$maintenance->techs->technician_name}} </span></span>
            </div>
            <div class="pos" id="_421:276" style="top:205;left:260">
                <span id="_14.4" style="font-weight:bold; font-size:14.4px; color:#000000">
                    Report Date: <span style="font-weight:normal"> {{\Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y')}} </span></span>
            </div>
            <div class="pos" id="_383:299" style="top:220;left:220">
                <span id="_15.7" style="font-weight:bold; font-size:15.7px; color:#e17900">
                    Asset Details</span>
            </div>
            <div class="pos" id="_96:324" style="top:235;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Building:</span>
                <span style="font-weight:normal;font-family:Calibri; font-size:14.0px;margin-left: 10px;"> </span>
            </div>
            <div class="pos" id="_241:324" style="top:238;left:86">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->building_code}}
                </span>
            </div>
            <div class="pos" id="_334:324" style="top:237;left:200">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Room No.</span>
            </div>
            <div class="pos" id="_445:324" style="top:237;left:298">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->room_code}}
                </span>
            </div>
            <div class="pos" id="_498:324" style="top:324;left:498">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_551:324" style="top:324;left:551">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_580:324" style="top:237;left:372">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Location:</span>
            </div>
            <div class="pos" id="_714:324" style="top:237;left:444">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->location}}
                </span>
            </div>
            <div class="pos" id="_96:345" style="top:255;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Age of </span>
            </div>
            <div class="pos" id="_167:355" style="top:355;left:167">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_227:355" style="top:355;left:227">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_281:355" style="top:355;left:301">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_334:355" style="top:260;left:200">
                <span id="_14.3" style="font-weight:normal; font-size:14.3px; color:#e17900">
                    Equipment Identification Number:</span>
            </div>
            <div class="pos" id="_668:355" style="top:260;left:390">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->equipment_number == 0 ? 'N/A': $maintenance->lifts->equipment_number }}
                </span>
            </div>
            <div class="pos" id="_96:364" style="top:265;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Asset:</span>
            </div>
            <div class="pos" id="_96:386" style="top:278;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Make:</span>
                <span style="font-weight:normal;font-family:Calibri; font-size:14.0px;margin-left: 24px;"></span>
            </div>
            <div class="pos" id="_167:386" style="top:282;left:86">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->lift_brand}}
                </span>
            </div>
            <div class="pos" id="_227:386" style="top:386;left:227">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_281:386" style="top:386;left:301">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_334:386" style="top:282;left:200">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Model:<span style="font-weight:normal;font-family:Calibri; font-size:14.0px;margin-left: 10px;"></span></span>
            </div>
            <div class="pos" id="_503:386" style="top:282;left:298">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->lift_model}}
                </span>
            </div>
            <div class="pos" id="_580:386" style="top:282;left:372">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Capacity:</span>
            </div>
            <div class="pos" id="_714:386" style="top:282;left:444">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->capacity}}
                </span>
            </div>
            <div class="pos" id="_96:407" style="top:297;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Plate Id: </span>
            </div>
            <div class="pos" id="_167:417" style="top:300;left:86">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{$maintenance->lifts->lift_reg_number}}
                </span>
            </div>
            <div class="pos" id="_227:417" style="top:417;left:227">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_281:417" style="top:417;left:301">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_334:417" style="top:300;left:200">
                <span id="_14.2" style="font-weight:normal; font-size:14.2px; color:#e17900">
                    Serial No.</span>
            </div>
            <div class="pos" id="_503:417" style="top:300;left:298">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_580:417" style="top:300;left:372">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Size:</span>
            </div>
            <div class="pos" id="_714:417" style="top:300;left:444">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#000000">
                    {{ $maintenance->lifts->size_lift() }}
                </span>
            </div>
            <div class="pos" id="_96:426" style="top:307;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    No.</span>
            </div>
            <div class="pos" id="_96:491" style="top:360;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:13.5px; color:#e17900">
                    Has the service elements within the </span>
            </div>
            <div class="pos" id="_96:510" style="top:370;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:13.5px; color:#e17900">
                    Execution of Work section within </span>
            </div>
            <div class="pos" id="_357:510" style="top:510;left:357">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_96:528" style="top:380;left:30">
                <span id="_14.4" style="font-weight:normal; font-size:13.5px; color:#e17900">
                    the relevant ITP been completed?</span>
            </div>
            <div class="pos" id="_96:528" style="top:380;left:210">
                <span id="_14.4" style="font-weight:normal; font-size:13.5px; color:#000000">
                    ITP Completed </span>
            </div>
            <div class="pos" id="_96:605" style="top:435;left:30">
                <span id="_14.4" style="font-weight:normal; font-size:14.4px; color:#e17900">
                    Overall Asset Condition:</span>
            </div>
            <div class="pos" id="_549:605" style="top:605;left:549">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_96:648" style="top:462;left:30">
                <span id="_14.4" style="font-weight:normal; font-size:14.4px; color:#e17900">
                    Additional Condition Notes:</span>
            </div>
            <div class="pos" id="_96:605" style="top:462;left:210">
                <span id="_14.4" style="font-weight:normal; font-size:14.4px; color:#000000">
                    Parts required: {{ $maintenance->part_required == 1 ? 'Yes' : 'No' }}</span>
            </div>
            <div class="pos" id="_96:605" style="top:462;left:310">
                <span id="_14.4" style="font-weight:normal; font-size:14.4px; color:#000000">
                    Parts replaced: {{ $maintenance->part_replaced == 1 ? 'Yes' : 'No' }}</span>
            </div>
            <div class="pos" id="_549:648" style="top:648;left:549">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                </span>
            </div>
            <div class="pos" id="_96:718" style="top:512;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:14.5px; color:#e17900">
                    Recommended work Required: </span>
            </div>
            <div class="pos" id="_549:821" style="top:490;left:210">
                <p id="_15.0" style="font-weight: normal;
                                    font-size: 14.0px;
                                    color: #000000;
                                    width: 380px;
                                    height: 120px;
                                    display: block;
                                    word-break: break-word;
                                    position: absolute;
                                    white-space: break-spaces;
                                    text-overflow: ellipsis;">
                    {{$maintenance->part_description}}
                </p>
            </div>
            <div class="pos" id="_96:821" style="top:584;left:30">
                <span id="_15.0" style="font-weight:normal; font-size:14.0px; color:#e17900">
                    Summary:</span>
            </div>
            <div class="pos" id="_549:821" style="top:550;left:210">
                <p id="_15.0" style="font-weight: normal;
                                    font-size: 14.0px;
                                    color: #000000;
                                    width: 380px;
                                    height: 120px;
                                    display: block;
                                    word-break: break-word;
                                    position: absolute;
                                    white-space: break-spaces;
                                    text-overflow: ellipsis;">
                    {{$maintenance->maintenance_note}}
                </p>
            </div>
            <div class="pos" id="_96:891" style="top:634;left:30">
                <span id="_14.3" style="font-weight:normal; font-size:14.3px; color:#000000">
                    I have carried out all necessary </span>
            </div>
            <div class="pos" id="_96:910" style="top:648;left:30">
                <span id="_14.3" style="font-weight:normal; font-size:14.3px; color:#000000">
                    inspections and verify that the </span>
            </div>
            <div class="pos" id="_96:928" style="top:662;left:30">
                <span id="_14.3" style="font-weight:normal; font-size:14.3px; color:#000000">
                    above items/activities conform to </span>
            </div>
            <div class="pos" id="_341:924" style="top:662;left:210">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#000000">
                    Name: <span style="font-weight:normal"> {{$maintenance->techs->technician_name}}</span></span>
            </div>
            <div class="pos" id="_96:947" style="top:676;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:14.5px; color:#000000">
                    the contract specifications and are </span>
            </div>
            <div class="pos" id="_96:966" style="top:690;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:14.5px; color:#000000">
                    in accordance with the relevant </span>
            </div>
            <div class="pos" id="_96:984" style="top:704;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:14.5px; color:#000000">
                    Australian standards and </span>
            </div>
            <div class="pos" id="_341:984" style="top:702;left:210">
                <span id="_14.5" style="font-weight:bold; font-size:14.5px; color:#000000">
                    Signature:<span style="font-weight:normal"> {{$maintenance->techs->technician_name}}</span></span>
            </div>
            <div class="pos" id="_96:1003" style="top:718;left:30">
                <span id="_14.5" style="font-weight:normal; font-size:14.5px; color:#000000">
                    manufacturers recommendations</span>
            </div>
            <div class="pos" id="_341:1008" style="top:718;left:210">
                <span id="_15.0" style="font-weight:bold; font-size:14.0px; color:#000000">
                    Date: <span style="font-weight:normal"> {{\Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y')}}</span></span>
            </div>


            <div class="pos" id="_98:1110" style="top:760;left:28">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Page <span style="font-weight:bold"> 1</span> of <span style="font-weight:bold"> 1</span></span>
            </div>
            <div class="pos" id="_523:1110" style="top:760;left:300">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    OPS-CC-2.2.10-AMC- Maintenance Schedule Record Log</span>
            </div>
            <div class="pos" id="_598:1123" style="top:772;left:392">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Document Control by Operations</span>
            </div>
            <div class="pos" id="_337:1136" style="top:772;left:200">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Facilites First Australia Pty Ltd</span>
            </div>
            <div class="pos" id="_639:1136" style="top:784;left:432">
                <span id="_11.0" style=" font-size:11.0px; color:#000000">
                    Issue Date: May 2020</span>
            </div>
        </nowrap>
    </nobr>
</body>