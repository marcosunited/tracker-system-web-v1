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
    width: 88%;
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
    margin-bottom: 30px;
    position: absolute;
    width: 88%;
    margin-top: 8px;
  }

  footer {
    margin-top: 16px;
    position: absolute;
  }
</style>

<body>
  <a href="/maintenances/{{$maintenance->id}}/pdf">Print As PDF</a>
  <header class="clearfix">
    <div id="logo">
      <img src="http://sydney.unitedlifts.com.au/image/logo.png">
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
          <?php echo $maintenance->jobs->job_number ?> -
          <?php echo $maintenance->jobs->job_name ?>
        </h2>
        <div class="address">
          <?php echo $maintenance->jobs->job_address_number ?>
          <?php echo $maintenance->jobs->job_address ?>
          <?php echo $maintenance->jobs->job_suburb ?>
        </div>
        <div class="email">
          Contract No: <?php echo $maintenance->jobs->job_number ?>
        </div>
      </div>
      <div id="invoice">
        <h1>Maintenance:
          <?php echo $maintenance->id ?>
        </h1>
        <div class="date">Maintenance Date:
          <?php echo $maintenance->maintenance_date ?>
          </p>
        </div>
      </div>
    </div>
    <table style="width:100%">
      <tr>
        <td colspan="2">
          <div style="border:0px solid black;min-height:150px;padding:10px;">
            <p style="color:#0087C3">
              <b>
                <h2>Maintenance Details</h2>
              </b>
            </p>
            <b>Maintenance Notes: </b>
            </p>
            <p>
              <?php echo $maintenance->maintenance_note ?>
            </p>

            <div style="height:1px;width:88%;background-color:#0087C3;margin-bottom:10px;position:center;">
            </div>
          </div>
        </td>
      </tr>
    </table>
    <table style="width:100%">
      <tr>
        <td colspan="2">
          <div style="border:0px solid black;height:50px;padding:10px;">
            <p><b>Maintenance Tasks: </b></p>
            <div style="height:1px;width:88%;background-color:#0087C3;margin-bottom:10px;position:center;">
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td width="20%" style="text-align:center">Lift Name</td>
        <td width="80%" style="text-align:left">Task Name</td>
      </tr>
      @foreach ($tasks as $task)
      <tr>
        <td style="text-align:center">{{$lift->lift_name}}</td>
        <td>{{$task->task_name}}</td>
      </tr>
      @endforeach
    </table>

    <table style="width:100%">
      <tr>
        <td colspan="2">
          <div style="border:0px solid black;height:50px;padding:10px;">
            <p><b>Sydney Olimpic Park tasks: </b></p>
            <div style="height:1px;width:88%;background-color:#0087C3;margin-bottom:10px;position:center;">
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td width="100%" style="text-align:left">Task Name</td>
        <td width="100%" style="text-align:center">Completed</td>
      </tr>
      @foreach ($sopa_tasks as $task)
      <tr>
        <td width="100%" style="text-align:left">{{$task->task_name}}</td>
        <td width="100%" style="text-align:center">{{ $task->checked == $maintenance->id ? 'Yes' : '' }}</td>
      </tr>
      @endforeach
    </table>

    <div style="height:1px;width:88%;background-color:#0087C3;margin-bottom:10px;position:center;">
    </div>
    <table style="width:100%">
      <tr rowspan="2">
        <td style="width:300px; vertical-align:top">
          <div>
            <b>Service Technician</b></br>
            {{$maintenance->techs->technician_name}}
          </div>
        </td>
        <td style="width:300px; vertical-align:top">
          <div>
            <b>Customer Email</b></br>
            {{$maintenance->reported_customer}}
          </div>
        </td>
      </tr>
    </table>
  </main>
  <div id="line">
  </div>
  <footer>
    Thank you for choosing United Lifts Services, 24 Hour Service, Phone 1300161740
  </footer>
</body>

</html>