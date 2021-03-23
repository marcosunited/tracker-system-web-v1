<html>

<head>
    <title></title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        .pos {
            position: absolute;
            z-index: 0;
            left: 0px;
            top: 0px
        }
    </style>

    <script src="{{ mix('js/dashmix.app.js') }}"></script>
    <script src="{{ mix('js/laravel.app.js') }}"></script>
</head>

<body>
    <nobr>
        <nowrap>
            <div class="pos" id="_0:0" style="top:0">
                <img name="_1170:828" src="http://cloud.unitedlifts.com.au:8070/image/images/invoice.jpg" height="980" width="680" border="0" usemap="#Map">
            </div>
            <div class="pos" id="_64:60" style="top:35;left:44">
                <span id="_27.1" style="font-weight:bold;  font-size:27.1px; color:#000000">
                    United Lift Services Pty Ltd</span>
            </div>
            <div class="pos" id="_675:73" style="top:35;left:420">
                <span id="_10.8" style="font-weight:bold;  font-size:10.8px; color:#000000">
                    ACN 082 447 658</span>
            </div>
            <div class="pos" id="_62:126" style="top:80;left:35">
                <span id="_12.2" style="font-weight:bold;  font-size:12.2px; color:#000000">
                    Postal Address</span>
            </div>
            <div class="pos" id="_471:114" style="top:70;left:280">
                <span id="_28.2" style="font-weight:bold; font-family:Times New Roman; font-size:26.2px; color:#000000">
                    TAX INVOICE</span>
            </div>
            <div class="pos" id="_62:150" style="top:94;left:35">
                <span id="_13.3" style="font-weight:bold;  font-size:13.3px; color:#000000">
                    P. O. BOX 280 KEW </span>
            </div>
            <div class="pos" id="_563:150" style="top:94;left:320">
                <span id="_10.6" style="font-weight:bold;  font-size:10.6px; color:#000000">
                    ABN</span>
            </div>
            <div class="pos" id="_683:150" style="top:94;left:420">
                <span id="_10.6" style="font-weight:bold;  font-size:10.6px; color:#000000">
                    81 082 447 658</span>
            </div>
            <div class="pos" id="_62:170" style="top:108;left:35">
                <span id="_13.3" style="font-weight:bold;  font-size:13.3px; color:#000000">
                    VIC 3101</span>
            </div>
            <div class="pos" id="_547:173" style="top:106;left:320">
                <span id="_11.1" style="  font-size:11.1px; color:#000000">
                    Invoice No.</span>
            </div>
            <div class="pos" id="_700:173" style="top:106;left:420">
                <span id="_11.1" style="font-weight:bold;  font-size:11.1px; color:#000000">
                    {{ 'FFA' . $maintenance->invoice_number() }}</span>
            </div>
            <div class="pos" id="_62:190" style="top:122;left:35">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    Ph: 03 9687 9099 - Fax: 03 9687 9094</span>
            </div>
            <div class="pos" id="_563:196" style="top:120;left:320">
                <span id="_10.7" style="  font-size:10.7px; color:#000000">
                    Date</span>
            </div>
            <div class="pos" id="_694:196" style="top:120;left:420">
                <span id="_10.7" style="font-weight:bold;  font-size:10.7px; color:#000000">
                    {{ \Carbon\Carbon::parse(Carbon\Carbon::now())->format('d/m/Y') }}</span>
            </div>
            <div class="pos" id="_559:219" style="top:136;left:320">
                <span id="_10.7" style="  font-size:10.7px; color:#000000">
                    Terms</span>
            </div>
            <div class="pos" id="_691:219" style="top:136;left:420">
                <span id="_10.7" style="font-weight:bold;  font-size:10.7px; color:#000000">
                    Net 30 Days</span>
            </div>
            <div class="pos" id="_61:231" style="top:140;left:35">
                <span id="_13.4" style="  font-size:13.4px; color:#000000">
                    <U>I</U><U>N</U><U>V</U><U>O</U><U>I</U><U>C</U><U>E</U> </span>
            </div>
            <div class="pos" id="_61:247" style="top:155;left:35">
                <span id="_13.4" style="  font-size:13.4px; color:#000000">
                    <U>T</U><U>o</U><U>:</U></span>
            </div>
            <div class="pos" id="_129:256" style="top:155;left:70">
                <span id="_16.0" style="font-weight:bold;  font-size:15.0px; color:#202020">
                    Facilities First Australia</span>
            </div>
            <div class="pos" id="_538:258" style="top:166;left:320">
                <span id="_10.7" style="  font-size:10.7px; color:#000000">
                    Customer ABN No.</span>
            </div>
            <div class="pos" id="_689:259" style="top:166;left:420">
                <span id="_10.7" style="font-weight:bold;  font-size:10.7px; color:#000000">
                    68 084 820 468</span>
            </div>
            <div class="pos" id="_129:276" style="top:170;left:70">
                <span id="_16.0" style="  font-size:15.0px; color:#202020">
                    PO Box 1987, Macquarie Centre Post Office </span>
            </div>
            <div class="pos" id="_551:289" style="top:180;left:320">
                <span id="_10.7" style="  font-size:10.7px; color:#000000">
                    Order No.</span>
            </div>
            <div class="pos" id="_681:289" style="top:180;left:420">
                <span id="_11.0" style="  font-size:11.0px; color:#000000">
                    {{$maintenance->order_no == '' ? 'Not defined' : $maintenance->order_no }}</span>
            </div>
            <div class="pos" id="_129:296" style="top:185;left:70">
                <span id="_16.5" style="  font-size:15.0px; color:#202020">
                    Macquarie Park NSW 2113</span>
            </div>
            <div class="pos" id="_545:309" style="top:192;left:320">
                <span id="_11.0" style="  font-size:11.0px; color:#000000">
                    Account No.</span>
            </div>
            <div class="pos" id="_694:309" style="top:192;left:420">
                <span id="_11.0" style="font-weight:bold;  font-size:11.0px; color:#000000">
                    {{$maintenance->job_number }}</span>
            </div>
            <div class="pos" id="_61:318" style="top:204;left:35">
                <span id="_13.8" style="  font-size:13.0px; color:#000000">
                    Maintenance & Reactive to </span><a href="mailto:psm@facilitiesfirst.com.au" style="font-size:12.0px;text-decoration: underline;color:blue">psm@facilitiesfirst.com.au</a>
            </div>
            <div class="pos" id="_61:338" style="top:216;left:35">
                <span id="_13.8" style="  font-size:13.0px; color:#000000">
                    Call out invoice to </span> <a href="mailto:ersclaims@facilitiesfirst.com.au" style="font-size:12.0px;text-decoration: underline;color:blue">ersclaims@facilitiesfirst.com.au</a>
            </div>
            <div class="pos" id="_503:336" style="top:232;left:320">
                <span id="_16.1" style="font-weight:bold;  font-size:16.1px; color:#202020">
                    Attention: Accounts</span>
            </div>
            <div class="pos" id="_61:364" style="top:230;left:35">
                <span id="_13.4" style="  font-size:13.0px; color:#000000">
                    Premises:</span>
            </div>
            <div class="pos" id="_61:385" style="top:242;left:35">
                <span id="_13.4" style="  font-size:13.0px; color:#000000">
                    Address : {{$maintenance->job_name}}</span>
            </div>
            <div class="pos" id="_90:411" style="top:260;left:44">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    Item</span>
            </div>
            <div class="pos" id="_404:411" style="top:260;left:210">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    Description</span>
            </div>
            <div class="pos" id="_673:411" style="top:260;left:424">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    Amount</span>
            </div>
            <div class="pos" id="_127:454" style="top:278;left:86">
                <span id="_13.4" style="  font-size:13.0px; color:#000000; text-decoration: underline;">
                    Chargeable service at premises address
                </span>
            </div>
            <div class="pos" id="_90:505" style="top:298;left:50">
                <span id="_14.7" style="  font-size:14.0px; color:#000000">
                    1</span>
            </div>
            <div class="pos" id="_130:504" style="top:298;left:86">
                <span id="_13.4" style="  font-size:13.4px; color:#202020">
                    Attend Maintenance at {{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y') }}.</span>
            </div>
            <div class="pos" id="_741:505" style="top:298;left:430">
                <span id="_14.7" style="  font-size:14.7px; color:#000000">
                    160.00</span>
            </div>
            <div class="pos" id="_131:526" style="top:312;left:86">
                <span id="_13.4" style="  font-size:13.4px; color:#202020">
                    (1 unit served)</span>
            </div>
            <div class="pos" id="_63:867" style="top:546;left:40">
                <span id="_10.7" style="font-weight:bold;  font-size:9.0px; color:#000000">
                    Payment can be made by CHEQUE to the above address or Direct Transfer to:</span>
            </div>
            <div class="pos" id="_513:883" style="top:554;left:320">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    SUBTOTAL</span>
            </div>
            <div class="pos" id="_656:882" style="top:554;left:400">
                <span id="_14.7" style="  font-size:14.7px; color:#000000">
                    $</span>
            </div>
            <div class="pos" id="_743:882" style="top:554;left:430">
                <span id="_14.7" style="  font-size:14.7px; color:#000000">
                    160.00</span>
            </div>
            <div class="pos" id="_64:893" style="top:560;left:40">
                <span id="_16.1" style="font-weight:bold;  font-size:16.1px; color:#ff0000">
                    NAB</span>
            </div>
            <div class="pos" id="_130:893" style="top:560;left:80">
                <span id="_16.1" style="font-weight:bold;  font-size:16.1px; color:#ff0000">
                    BSB: 083346 -Account: 848 317 830</span>
            </div>
            <div class="pos" id="_64:921" style="top:575;left:40">
                <span id="_16.1" style="font-weight:normal;  font-size:15.0px; color:#000000">
                    Mail Remittance To: P. O. Box 280, Kew 3101</span>
            </div>
            <div class="pos" id="_64:946" style="top:590;left:40">
                <span id="_16.1" style="font-weight:normal;  font-size:15.0px; color:#000000">
                    or E-mail to: </span><a href="mailto:accounts@unitedlifts.com.au" style="text-decoration: underline;color:blue">accounts@unitedlifts.com.au</a>
            </div>
            <div class="pos" id="_513:948" style="top:594;left:320">
                <span id="_13.4" style="font-weight:bold;  font-size:13.4px; color:#000000">
                    GST TOTAL</span>
            </div>
            <div class="pos" id="_656:947" style="top:594;left:400">
                <span id="_14.7" style="  font-size:14.7px; color:#000000">
                    $</span>
            </div>
            <div class="pos" id="_751:947" style="top:594;left:430">
                <span id="_14.7" style="  font-size:14.7px; color:#000000">
                    16.00</span>
            </div>
            <div class="pos" id="_504:1003" style="top:630;left:320">
                <span id="_16.1" style="font-weight:bold;  font-size:16.1px; color:#000000">
                    TOTAL</span>
            </div>
            <div class="pos" id="_658:1001" style="top:630;left:400">
                <span id="_18.8" style="font-weight:bold;  font-size:18.8px; color:#000000">
                    $</span>
            </div>
            <div class="pos" id="_730:1001" style="top:630;left:430">
                <span id="_18.8" style="font-weight:bold;  font-size:18.8px; color:#000000">
                    176.00</span>
            </div>
            <div class="pos" id="_504:1031" style="top:642;left:320">
                <span id="_13.4" style="font-weight:normal;  font-size:13.4px; color:#000000">
                    Including GST</span>
            </div>
            <div class="pos" id="_111:1054" style="top:664;left:40">
                <span id="_12.5" style="font-weight:bold;font-style:italic;  font-size:12.0px; color:#ff0000">
                    This Is A Payment Claim Made Under The Building & Construction Industry Security Payment ACT 1999</span>
            </div>
            <div class="pos" id="_51:1085" style="top:684;left:35">
                <span id="_8.3" style="font-weight:bold;  font-size:9.0px; color:#000000">
                    Registered Office: Unit 3 / 260 Hyde Street, Yarraville - 3013</span>
            </div>
        </nowrap>
    </nobr>
</body>

</html>