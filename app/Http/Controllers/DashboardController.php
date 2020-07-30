<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Calloutn;
use App\MaintenanceN;
use App\Technician;
use App\Job;
use App\Gps;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technicians = Technician::all();
        $callouts = Calloutn::all();
        $maintenances = MaintenanceN::all();
        $jobs = Job::all();
        /*
        $markers = Gps::select('_gps_pos.*','technicians.technician_name as username','technicians.technician_phone as phone')
                    ->leftjoin('technicians','technicians.id','=','_gps_pos.user_id')
                    ->where('_gps_pos.onoff','on')
                    ->get()->last();        
        */
        $markers = [];
        $tp_markers = Gps::select('user_id')->where('onoff','on')->groupBy('user_id')->get();

        foreach ($tp_markers as $one) {
            $userid = $one->user_id;
            $temp = [];
            $pos = Gps::select('_gps_pos.*','technicians.technician_name as username','technicians.technician_phone as phone','technicians.photo as photo')
                            ->leftjoin('technicians','technicians.id','=','_gps_pos.user_id')
                            ->where('user_id', $userid)->where('onoff','on')->orderBy('id', 'desc')->get()->first();            
            $markers[] = $pos; 
        }

        $alarms = $this->showAsidePopup();
        return view('dashboard',compact('technicians','callouts','maintenances','jobs','markers','alarms'));
    }

    public function reloadmap(Request $request) {
        $markers = [];
        $tp_markers = Gps::select('user_id')->where('onoff','on')->groupBy('user_id')->get();

        foreach ($tp_markers as $one) {
            $userid = $one->user_id;
            $temp = [];
            $pos = Gps::select('_gps_pos.*','technicians.technician_name as username','technicians.technician_phone as phone','technicians.photo as photo')
                            ->leftjoin('technicians','technicians.id','=','_gps_pos.user_id')
                            ->where('user_id', $userid)->where('onoff','on')->orderBy('id', 'desc')->get()->first();            
            $markers[] = $pos; 
        }

        echo json_encode($markers);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
