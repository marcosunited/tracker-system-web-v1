<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;
use App\Round;
use Illuminate\Support\Facades\Input;
use Exception;

class TechController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $techs = Technician::select()->where('is_deleted', '=', '0')->get();
        return view('techs.allTechs', compact('techs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rounds = Round::all();
        return view('techs.createTech', compact('rounds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = Input::file('technician_photo');
        $avatar = 'default.png';
        if ($file != null) {
            $imagname = 'profile_' . $file->getClientOriginalName();
            $file->move(public_path('avatar/'), $imagname);
            $avatar = 'avatar/' . $imagname;
        }

        Technician::create([

            'status_id' => request('status_id'),
            'technician_name' => request('technician_name'),
            'technician_phone' => request('technician_phone'),
            'technician_email' => request('technician_email'),
            'round_id' => request('round_id'),
            'technician_password' => base64_encode(request('technician_password')),
            'photo' => $avatar,
        ]);

        flash('Technician Successfully Created!')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Technician $tech)
    {
        $rounds = Round::all();
        $selectedRound = $tech->rounds;
        return view('techs.showTech', compact('tech', 'selectedRound', 'rounds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technician $tech)
    {
        //dd($request);
        $file = Input::file('technician_photo');
        $avatar = $tech->photo;
        if ($file != null) {
            $imagname = 'profile_' . $file->getClientOriginalName();
            $file->move(public_path('avatar/'), $imagname);
            $avatar = 'avatar/' . $imagname;
        }

        $tech->update([

            'status_id' => request('status_id'),
            'technician_name' => request('technician_name'),
            'technician_phone' => request('technician_phone'),
            'technician_email' => request('technician_email'),
            'round_id' => request('round_id'),
            'technician_password' => base64_encode(request('technician_password')),
            'photo' => $avatar,
        ]);

        flash('Technician Successfully Updated!')->success();
        return back();
    }

    public function jobs(Technician $tech)
    {
        $techJob = $tech->rounds->jobs;
        return view('techs.techJob', compact('techJob', 'tech'));
    }

    public function callouts(Technician $tech)
    {
        $techcallouts = $tech->callouts;
        return view('techs.techcallouts', compact('techcallouts', 'tech'));
    }

    public function maintenances(Technician $tech)
    {
        $techmaintenances = $tech->maintenances;
        return view('techs.techmaintenanceTable', compact('techmaintenances', 'tech'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $technician = Technician::findorfail($id);
            if (isset($technician)) {
                $technician->update([

                    'is_deleted' => 1,
                    'status_id' => 2
                ]);
            }
            flash('Technician deleted successfully')->success();
            return back();
        } catch (Exception $e) {
            flash('Error deleting technician')->error();
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }
}
