<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Correction;

class CorrectionController extends Controller
{
    public function index()
    {
        $corrections = Correction::all();
        return view('correction.allCorrections',compact('corrections'));
    }

    public function show(Correction $correction)
    {
        return view('correction.showCorrection',compact('correction'));
    }

    public function update(Correction $correction,Request $request)
    {
        $correction->update([

            'correction_name' => request('correction_name'),
            'type' => request('type'),
        ]);

        flash('Correction Successfully Updated!')->success();
        return back();
    }

    public function create()
    {
        return view('correction.addCorrection');
    }

    public function store(Request $request)
    {
        Correction::create([
            'correction_name' => request('correction_name'),
            'type' => request('type'),
        ]);

        flash('Correction Successfully Added!')->success();
        return back();

    }

    public function destroy(Request $request)
    {
        $correction = Correction::findorfail($request->correction_id);
        $correction->delete();
        flash('Correction Successfully Deleted!')->error();
        return back();
    }

}
