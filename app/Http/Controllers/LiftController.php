<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Lift;

class LiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job)
    {
        $lifts = $job->lifts;
        return view('lifts.allLifts', compact('job', 'lifts'));
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
    public function store(Request $request, Job $job)
    {
        $attributes = request()->validate([
            'lift_name' => 'required',
            'lift_status_id' => 'required',
            'lift_type' => 'required',

        ]);

        $job->addLift($attributes);

        flash('Lift Successfully Added!')->success();
        return back();
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
    public function edit(Job $job, Lift $lift)
    {
        return view('lifts.liftForm', compact('job', 'lift'));
    }

    public function callouts(Job $job, Lift $lift)
    {
        $liftcallouts = $lift->callouts;
        return view('lifts.liftcallouts', compact('job', 'lift', 'liftcallouts'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job, Lift $lift)
    {
        $lift->update([
            'lift_name' => request('lift_name'),
            'lift_status_id' => request('lift_status_id'),
            'lift_type' => request('lift_type'),
            'lift_phone' => request('lift_phone'),
            'lift_brand' => request('lift_brand'),
            'lift_reg_number' => request('lift_reg_number'),
            'lift_model' => request('lift_model'),
            'lift_speed' => request('lift_speed'),
            'lift_floor' => request('lift_floor'),
            'lift_installed_date' => request('lift_installed_date'),
            'function' => request('function'),
            'capacity' => request('capacity'),
            'location' => request('location'),
            'room_code' => request('room_code'),
            'building_code' => request('building_code'),
            'contract_group_id' => request('contract_group_id'),
            'equipment_number' => request('equipment_number'),
            'zone' => request('zone'),
        ]);

        flash('Lift Successfully Updated!')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job, Lift $lift)
    {
        $lift->delete();
        flash('Lift Successfully Deleted!')->success();
        return back();
    }
}
