<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Round;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rounds = Round::all();

        return view('rounds.allRound',compact('rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rounds.createRound');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Round::create([

            'status_id' => request('status_id'),
            'round_name' => request('round_name'),
            'round_colour' => request('round_colour'),
        ]);

        flash('Round Successfully Created!')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round)
    {
        return view('rounds.showRound' ,compact('round'));
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
    public function update(Request $request, Round $round)
    {
        $round->update([

            'status_id' => request('status_id'),
            'round_name' => request('round_name'),
            'round_colour' => request('round_colour'),
        ]);

        flash('Round Successfully Updated!')->success();
        return back();
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

    public function jobs(Round $round)
    {
        $jobRounds = $round->jobs;

        return view('rounds.jobRound' ,compact('jobRounds','round'));
    }

    public function techs(Round $round)
    {
        $techRounds = $round->techs;

        return view('rounds.techRound' ,compact('techRounds','round'));
    }
}
