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

</style>
<a href="/repairs/{{$repair->id}}/pdf">Print As PDF</a>
<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{$logo}}">
        </div>
        <div id="company">
            <h2 class="name">United Lift Services</h2>
            <div>Unit 6, 38 Raymond Avenue,Matraville
            </div>
            <div>1300 161 740</div>
            <div>
                <a href="mailto:company@example.com">sydney@unitedlifts.com.au</a>
            </div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">Customer Details:</div>
                <h2 class="name">
                  {{$repair->jobs->job_number}} - 
                  {{$repair->jobs->job_name}}
                </h2>
                <div class="address">
                    {{$repair->jobs->job_address_number}}
                    {{$repair->jobs->job_address}}
                    {{$repair->jobs->job_surburb}}
                </div>
                <div class="email">
                    <a href="mailto:{{$repair->jobs->job_email}}">
                        {{$repair->jobs->job_email}}
                    </a>
                </div>
            </div>
            <div id="invoice">
          <h1>Repair ID:
            <?=$repair["id"]?>
          </h1>
          <h2>Quote No:
            <?=$repair["quote_no"]?>
          </h2>
          <div class="date">Notice Time:
            {{$repair->repair_time}}
          </div>
        </div>
      </div>
      <table>
        <tr>
          <td colspan="2">
            <div style="border:0px solid black;height:300px;padding:10px;">
			
              <p>
                <b style="color:#0087C3">
                  <u>Repairs DETAILS</u>
                </b>
              </p>
                <b>For Lift(s): </b>
                @foreach($repair->lifts as $lift)
                    {{$lift->lift_name}}
                @endforeach
              </p>
			   <p>			  
			   <b>Order Number:</b>
                <?=$repair["order_no"]?>

			
              <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;"></div>
				
              <p>
                <b style="color:#0087C3">
                  <u>DESCRIPTION OF WORK</u>
                </b>
              </p>
              <p>
                <b>Part Required:</b>
                
                <?=$repair["parts_description"]?>
              </p>
              <p>
                <b>Work Description:</b>
                
                <?=$repair["repair_description"]?>
              </p>
            </div>
          </td>
        </tr>
      </table>
      <table style="margin-top:80px;">
      <tr>
        <td style="width:300px">
            <p><b>Service Technician</b></p>
            {{$repair->techs->technician_name}}       
        </td>
        </tr>
      </table>
      </main>
    <div style="margin-bottom:10px; position: absolute;">
    <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;"></div>
        <b>Thank you for choosing our company, 24 Hour Service, Phone 1300161740</b>
    </div>
</body>
</html>
