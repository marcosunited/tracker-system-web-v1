@extends('layouts.backend')
@section('css_before')
<style>
#bigmap{width:100%;height:500px}
</style>    
@endsection
@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/be_pages_dashboard.min.js') }}"></script>

    <script>
      var marker;
      let map;
      let markersArray = [];
      function initMap() {
        map = new google.maps.Map(document.getElementById('bigmap'), {
          zoom: 4,
          center: {lat: -33.8688, lng:  151.2093} 
        });

        <?php
        foreach ($markers as $marker) {
            echo 'addMarker({lat:'. $marker->lat.', lng:'.$marker->lng.'},"'.$marker->username.'","'.$marker->phone.'","'.$marker->created_at.'","'. $marker->photo.'");';
        }
        ?>
      }

      function addMarker(latLng,label, color,time='' , icon) {
        <?php echo 'let url = "'. asset('/').'";';?>
        url += icon;
        var contentString = '<div id="content">'+                
                '<div id="bodyContent">'+
                '<p><b>'+label+'</b><br>,' +
                'phone number is '+ color +
                ',<br> location time is '+ time+
                '.</p></div></div>';
        let marker = new google.maps.Marker({
            map: map,
            position: latLng,
            //title: label,
            icon: {
                url: url,
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            },                      
        });        
        let infowindow = new google.maps.InfoWindow({
            content: contentString
        });        
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });        
        //store the marker object drawn in global array
        markersArray.push(marker);
        
        }

        function reloadMarkers() {

            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray = [];


            $.ajax({
                url:'/getreloadmap',
                type:'post',
                data: {'_token':$('meta[name=csrf-token]').attr('content')},
                success:function(data) {
                    
                    var data = JSON.parse(data);
                    console.log(data);
                    for (var i=0;i<data.length;i++) {
                        //console.log(data[i].lat);
                        addMarker({lat:data[i].lat,lng:data[i].lng},data[i].username,data[i].phone,data[i].created_at,data[i].photo);
                    }
                },
                error:function() {
                    Alert('loading error');
                }
            })
            
        }
        $('#reloadmarkers').click(function(){
            reloadMarkers();
        })
        var tmp;
        //function f1() {
            
        //}
        function clickreload() {
            console.log(1);
            document.getElementById("reloadmarkers").click();
        }     
 </script>
 <script>
     $(document).ready(function(){
        setInterval("clickreload()", 5000*60);
    });
 </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU&callback=initMap">
    </script>

    <!-- Page JS Helpers (Slick Slider Plugin) -->
    <script>jQuery(function(){ Dashmix.helpers('slick'); });</script>

        
@endsection

@section('content')
<!-- Hero -->
<div class="bg-image" style="background-image: url('{{ asset('media/various/bg_dashboard.jpg') }}');">
    <div class="bg-white-90">
        <div class="content content-full">
            <div class="row">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-left invisible" data-toggle="appear">
                        <h1 class="font-size-h2 mb-2">Dashboard</h1>
                        <h2 class="font-size-lg font-w400 text-muted mb-0">Today is a great one!</h2>
                    </div>
                </div>
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="row w-100 text-center">
                        <div class="col-6 col-xl-4 offset-xl-4 invisible" data-toggle="appear" data-timeout="300">
                            <p class="font-size-h3 font-w600 text-body-color-dark mb-0">
                                {{count($callouts)}}
                            </p>
                            <p class="font-size-sm font-w700 text-uppercase mb-0">
                                <i class="far fa-chart-bar text-muted mr-1"></i> Callouts
                            </p>
                        </div>
                        <div class="col-6 col-xl-4 invisible" data-toggle="appear" data-timeout="600">
                            <p class="font-size-h3 font-w600 text-body-color-dark mb-0">
                                {{count($maintenances)}}
                            </p>
                            <p class="font-size-sm font-w700 text-uppercase mb-0">
                                <i class="far fa-chart-bar text-muted mr-1"></i> Maintaince
                            </p>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<!-- END Hero -->

                <!-- Page Content -->
                <div class="content">
                    <!-- Quick Stats -->
                    <!-- jQuery Sparkline (.js-sparkline class is initialized in Helpers.sparkline() -->
                    <!-- For more info and examples you can check out http://omnipotent.net/jquery.sparkline/#s-about -->
                    <div class="row">
                        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear">
                            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div>
                                        <!-- Sparkline Dashboard Users Container -->
                                        <span class="js-sparkline" data-type="line"
                                              data-points="[340,330,360,340,360,350,370,360]"
                                              data-width="90px"
                                              data-height="40px"
                                              data-line-color="#82b54b"
                                              data-fill-color="transparent"
                                              data-spot-color="transparent"
                                              data-min-spot-color="transparent"
                                              data-max-spot-color="transparent"
                                              data-highlight-spot-color="#82b54b"
                                              data-highlight-line-color="#82b54b"
                                              data-tooltip-suffix="Users"></span>
                                    </div>
                                    <div class="ml-3 text-right">
                                        <p class="text-muted mb-0">
                                            Technicians
                                        </p>
                                        <p class="font-size-h3 font-w300 mb-0">
                                            {{count($technicians)}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="200">
                            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div>
                                        <!-- Sparkline Dashboard Tickets Container -->
                                        <span class="js-sparkline" data-type="line"
                                              data-points="[21,17,19,25,24,25,18,27]"
                                              data-width="90px"
                                              data-height="40px"
                                              data-line-color="#e04f1a"
                                              data-fill-color="transparent"
                                              data-spot-color="transparent"
                                              data-min-spot-color="transparent"
                                              data-max-spot-color="transparent"
                                              data-highlight-spot-color="#e04f1a"
                                              data-highlight-line-color="#e04f1a"
                                              data-tooltip-suffix="Tickets"></span>
                                    </div>
                                    <div class="ml-3 text-right">
                                        <p class="text-muted mb-0">
                                            Repairs
                                        </p>
                                        <p class="font-size-h3 font-w300 mb-0">
                                            0
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="400">
                            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div>
                                        <!-- Sparkline Dashboard Projects Container -->
                                        <span class="js-sparkline" data-type="line"
                                              data-points="[7,9,5,2,3,4,8,3]"
                                              data-width="90px"
                                              data-height="40px"
                                              data-line-color="#3c90df"
                                              data-fill-color="transparent"
                                              data-spot-color="transparent"
                                              data-min-spot-color="transparent"
                                              data-max-spot-color="transparent"
                                              data-highlight-spot-color="#3c90df"
                                              data-highlight-line-color="#3c90df"
                                              data-tooltip-suffix="Projects"></span>
                                    </div>
                                    <div class="ml-3 text-right">
                                        <p class="text-muted mb-0">
                                            Agents
                                        </p>
                                        <p class="font-size-h3 font-w300 mb-0">
                                            24
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="600">
                            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div>
                                        <!-- Sparkline Dashboard Sales Container -->
                                        <span class="js-sparkline" data-type="line"
                                              data-points="[68,25,36,62,59,80,75,89]"
                                              data-width="90px"
                                              data-height="40px"
                                              data-line-color="#343a40"
                                              data-fill-color="transparent"
                                              data-spot-color="transparent"
                                              data-min-spot-color="transparent"
                                              data-max-spot-color="transparent"
                                              data-highlight-spot-color="#343a40"
                                              data-highlight-line-color="#343a40"
                                              data-tooltip-suffix="Sales"></span>
                                    </div>
                                    <div class="ml-3 text-right">
                                        <p class="text-muted mb-0">
                                            Jobs
                                        </p>
                                        <p class="font-size-h3 font-w300 mb-0">
                                            {{count($jobs)}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- END Quick Stats -->

                    <!-- Main Chart -->
                    <div class="block block-rounded block-mode-loading-refresh invisible" data-toggle="appear">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Callouts</h3>
                            <div class="block-options">
                                <div class="btn-group btn-group-sm btn-group-toggle mr-2" data-toggle="buttons" role="group" aria-label="Earnings Select Date Group">
                                    <label class="btn btn-light" data-toggle="dashboard-chart-set-week">
                                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-week"> Week
                                    </label>
                                    <label class="btn btn-light" data-toggle="dashboard-chart-set-month">
                                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-month"> Month
                                    </label>
                                    <label class="btn btn-light active" data-toggle="dashboard-chart-set-year">
                                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-year" checked> Year
                                    </label>
                                </div>
                                <button type="button" class="btn-block-option align-middle" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full overflow-hidden">
                            <div class="pull-x pull-b">
                                <!-- Chart.js Dashboard Earnings Container -->
                                <canvas class="js-chartjs-dashboard-earnings" style="height: 340px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- END Main Chart -->

                    <!-- Real TIme tracking -->
                    <div class="row row-deck">
                        <div class="col-xl-12" data-toggle="appear">

                        <div class="block block-rounded block-mode-loading-refresh invisible" data-toggle="appear">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Technician Geolocation tracking</h3>                          
                                <div class="block-options">
                                    <button type="button" id="reloadmarkers" class="btn-block-option align-middle" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>   
                            </div>                                
                            </div>
                            <div class="block-content block-content-full overflow-hidden">
                                <div id="bigmap"></div>
                            </div>
                        </div>                        
                            <!-- Big Google Map -->
                
                            <!-- END Big Google Map -->
                        </div>
                    </div>
                    <!-- END Users and Purchases -->
                </div>
                <!-- END Page Content -->
@endsection
