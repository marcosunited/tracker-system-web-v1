<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fault;

class FaultController extends Controller
{
    public function index()
    {
        $faults = Fault::all();
        return view('fault.allFault',compact('faults'));
    }

    public function show(Fault $fault)
    {
        return view('fault.showFault',compact('fault'));
    }

    public function update(Fault $fault,Request $request)
    {
        $fault->update([

            'fault_name' => request('fault_name'),
            'type' => request('type'),
        ]);

        flash('Fault Successfully Updated!')->success();
        return back();
    }

    public function create()
    {
        return view('fault.addFault');
    }

    public function store(Request $request)
    {
        Fault::create([
            'fault_name' => request('fault_name'),
            'type' => request('type'),
        ]);

        flash('Fault Successfully Added!')->success();
        return back();

    }

    public function destroy(Request $request)
    {
        $fault = Fault::findorfail($request->fault_id);
        $fault->delete();
        flash('Fault Successfully Deleted!')->error();
        return back();
    }
}
