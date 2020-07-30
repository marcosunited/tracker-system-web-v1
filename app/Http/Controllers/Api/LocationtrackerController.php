<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Technician;
use App\Gps;
use Response;

class LocationtrackerController extends Controller
{
    public function start(Request $request)
    {
        $userid = $request->get('tech_id');
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        $gps= Gps::create([
            'user_id'=>$userid,
            'lat'=>$lat,
            'lng'=>$lng,
            'onoff'=>'on',
        ]);
        echo json_encode($gps);
    }
    public function stop(Request $request)
    {
        $userid = $request->get('tech_id');
        $locs = Gps::select()->where('user_id',$userid);
        $locs->update([
            'onoff'=>'off'
        ]);
        echo 1; //true
    }

    public function removehistory(Request $request)
    {
        //Gps::deleteAll();
    }
}