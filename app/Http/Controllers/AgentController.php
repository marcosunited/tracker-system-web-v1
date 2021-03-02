<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use Exception;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::all();
        return view('agents.allAgents', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agents.createAgent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            Agent::create([

                'agent_name' => request('agent_name'),
                'agent_phone' => request('agent_phone'),
                'agent_address' => request('agent_address'),
                'agent_fax' => request('agent_fax')
            ]);

            flash('Agent added successfully!')->success();
            return back();
        } catch (Exception $e) {
            flash('Error deleting agent')->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        return view('agents.showAgents', compact('agent'));
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
    public function update(Request $request, Agent $agent)
    {
        try {
            $agent->update([

                'agent_name' => request('agent_name'),
                'agent_phone' => request('agent_phone'),
                'agent_address' => request('agent_address'),
                'agent_fax' => request('agent_fax')
            ]);

            flash('Agent updated successfully!')->success();
            return back();
        } catch (Exception $e) {
            flash('Error updating agent')->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        try {
            $agent->delete();
            flash('Agent deleted successfully')->success();
            return back();
        } catch (Exception $e) {
            flash('Error deleting agent')->error();
        }
    }

    public function jobs(Agent $agent)
    {
        $agentJobs = $agent->jobs;

        return view('agents.agentJob', compact('agentJobs', 'agent'));
    }
}
