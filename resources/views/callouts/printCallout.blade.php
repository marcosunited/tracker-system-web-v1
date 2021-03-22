<html>
<style>

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  margin: 0 auto;
  color: #555555;
  background: #FFFFFF;
  font-family: sans-serif;
  font-size: 12px;
  font-family: SourceSansPro;
  width: 21cm;
  height: 29.7cm;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}


#logo {
  float: left;
}

#logo img {
  margin-top: 8px;
  float: left;
}

#company {
  text-align: right;
  margin-right: 80px;
  margin-top: 8px;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  padding-right: 6px;
  text-align: right;
  margin-right: 80px;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0 0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

#line {
  height: 1px;
  width: 100%;
  background-color: #0087C3;
  margin-bottom: 10px;
  position: absolute;
}

serviceTechnician {
  position: absolute;
  bottom: 70px;
}

#line {
  height: 1px;
  width: 100%;
  background-color: #0087C3;
  margin-bottom: 30px;
  position: absolute;
  bottom: 10px;
  width:88%;
}

footer {
  position: absolute;
  bottom: 19px;
}

</style>
<a href="/callouts/{{$callout->id}}/pdf">Print As PDF</a>
<body>
    <header class="clearfix">
        <div id="logo">
            <img src="http://cloud.unitedlifts.com.au:8070/image/logo.png">
        </div>
        <div id="company">
            <h2 class="name">United Lift Services</h2>
            <div>Unit 6, 38 Raymond Avenue, Matraville
            </div>
            <div>1300 161 740</div>
            <div>
                <a href="mailto:sydney@unitedlifts.com.au">sydney@unitedlifts.com.au</a>
            </div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">Customer Details:</div>
                <h2 class="name">
                    {{$callout->jobs->job_number . ' ' . $callout->jobs->job_name}}
                </h2>
                <div class="address">
                    {{$callout->jobs->job_address_number}}
                    {{$callout->jobs->job_address}}
                    {{$callout->jobs->job_surburb}}
                </div>
                <div class="email">
                    <a href="mailto:{{$callout->jobs->job_email}}">
                        {{$callout->jobs->job_email}}
                    </a>
                </div>
            </div>
            <div id="invoice">
                <h1>Callout:
                    {{$callout->id}}
                </h1>
                <div class="date">Date of Call:
                     {{date('d-m-yy',strtotime($callout->callout_time))}}
                </div>
                <div class="date">Time of Arrival:
                @if($callouttime === NULL || $callouttime->toa === NULL)
                {{date('d-m-yy H:i:s',strtotime($callout->time_of_arrival))}}
                @else
                {{date('d-m-yy H:i:s',strtotime($callouttime->toa))}}
                @endif
                </div>
                <div class="date">Time of Departure:
                @if($callouttime === NULL || $callouttime->tod === NULL)
                {{date('d-m-yy H:i:s',strtotime($callout->time_of_departure))}}
                @else
                {{date('d-m-yy H:i:s',strtotime($callouttime->tod))}}
                @endif
                </div>
            </div>
        </div>
        <table>
            <tr>
                <td colspan="2">
                    <div style="border:0px solid black;height:300px;padding:10px;width:80%;">
                        <p>
                            <b style="color:#0087C3">
                                <u>CALLOUT DETAILS</u>
                            </b>
                        </p>

                        <!-- <p>
                            <b>Reported Fault (COMPLAINT): </b>
                            {{$callout->faults->fault_name}}
                        </p>
                        <p>
                            <b>For Lifts: </b>
                            @foreach ($callout->lifts as $lift)
                            {{$lift->lift_name != null ? $lift->lift_name : ''}}</a>
                            @endforeach
                        </p>

                        <p>
                            <b>Call Description:</b>
                            {{$callout->callout_description != null ? $callout->callout_description : ''}}
                        </p> -->
                        <p>
                        On <b style="color:blue;">{{date('d-m-y',strtotime($callout->callout_time))}}</b> the customer reported the fault for   @foreach ($callout->lifts as $lift)
                            <b style="color:blue;">{{$lift->lift_name}}</b>
                            @endforeach  {{$callout->faults->fault_name}}
                            @if($callouttime === NULL || $callouttime->toa === NULL)
                                N/A
                            @else
                                We attended to the call at  <b style="color:blue;">{{date('H:i:s',strtotime($callouttime->toa))}} </b> and found <b style="color:red;">{{$callout->correction!=null?$callout->correction->correction_name:''}} </b>.
                                and rectified the fault,
                                Lift mechanic completed the inspection of the lift, ran and checked all operations.
                            @endif
                        </p>

                        <p>
                            <b>Order No:</b>
                            {{$callout->order_number}}
                        </p>

						  <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;position:center;">
						  </div>

                        <p>
                            <b style="color:#0087C3">
                                <u>DESCRIPTION OF WORK</u>
                            </b>
                        </p>
                        <p>
                            <b>Fault Found (CAUSE):</b>
                            {{$callout->techfault !=null ? $callout->techfault->technician_fault_name : ''}}
                        </p>
                        <p>
                            <b>Work Action (CORRECTION):</b>
                            {{$callout->correction != null ? $callout->correction->correction_name: ''}}
                        </p>
                        <p>
                            <b>Work Description:</b>
                            <br>
                            {{$callout->tech_description != null ? $callout->tech_description: ''}}
                        </p>
                        <p>
                        <p>
                            <b>Part Description:</b>
                            <br>
                            @if($callout->part_description === NUll)
                            <b>No parts used</b>
                            @else
                            {{$callout->part_description != null ? $callout->part_description : ''}}
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
        </table>
        <table style="margin-top:80px;">
            <tr>
                <td style="width:300px">
                <b>Part Required?</b>
                            <br>
                            @if($callout->part_required == 0)
                            No
                            @else
                            Yes
                            @endif
                </td>
                <td style="width:300px">
                <b>Part Replaced?</b>
                            <br>
                            @if($callout->part_replaced == 0)
                            No
                            @else
                            Yes
                            @endif
                </td>
            </tr>
        </table>
        <table style="margin-top:20px;">
            <tr>
                <td style="width:300px">
                    <p><b>Service Technician:</b></p>
                    {{$callout->techs->technician_name}}
                </td>
                <td style="width:300px">
                    <p><b>Customer Signature:</b></p>
                    {{$callout->reported_customer}}
                </td>
            </tr>
        </table>
        <table style="margin-top:20px;">
            <tr>
                <td style="width:600px">
                    <p><b>Files:</b></p>
                </td>
            </tr>
        </table>
		<table style="margin-top:20px;">
			@foreach ($files as $file)

				@if(($loop->index + 1) % 2 == 1)
					<tr>
				@endif

				<td>
					<img style="width:290px;height:350px" src="{{ public_path("callouts\\".$file->title) }}" />
				</td>


			@endforeach
		</table>
    </main>
    <div id="line">
	</div>
    <footer>
      Thank you for choosing  United Lifts Services, 24 Hour Service, Phone 1300161740
    </footer>
</body>
</html>
