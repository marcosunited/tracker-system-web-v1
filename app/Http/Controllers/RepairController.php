<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use App\Callout;
use App\Calloutn;
use Illuminate\Support\Facades\DB;
use App\Fault;
use App\Job;
use App\Technician;
use App\TechFault;
use App\Correction;
use App\Frequency;
use App\Round;
use App\Agent;
use App\Contract;
use App\JobStatus;
use App\File;
use App\Note;
use Session;
use App\Repair;
use PDF;


class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function open()
    {
        $openrepairs = Repair::where('repair_status_id','1')
        ->get();
        
        return view('repairs.openRepairs',compact('openrepairs'));
    }

    public function closed()
    {
        $closedrepairs = Repair::where('repair_status_id','2')
        ->limit(1000)
        ->get();
 
        return view('repairs.closedRepairs',compact('closedrepairs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function selectedJob(Request $request)
    {
        $selectedJob = Job::find($request->message);
        Session::put('selectedJob',$selectedJob);
        return back();
    }
    
    public function create()
    {
        $faults = Fault::all();
        $jobs = Job::where('status_id', 1)->get();
        $lifts = "";
        $technicians = Technician::all();
        $selectedTech = array();
        if(Session::has('selectedJob')){
        $selectedJob = Session::get('selectedJob');
        $lifts = Job::findorfail($selectedJob->id)->lifts;
        $selectedTech = Job::findorfail($selectedJob->id)->rounds->techs;
        }
        return view('repairs.createRepairs',compact('faults','jobs','technicians','lifts','selectedTech'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $repair = Repair::create([

            'job_id' => request('job_id'),
            'technician_id' => request('technician_id'),
            'repair_status_id' => request('repair_status_id'),
            'repair_time' => request('repair_time'),
            'chargeable_id' => request('chargeable_id'),
            'repair_description' => request('repair_description'),
            'parts_description' => request('parts_description'),
            'order_no' => request('order_no'),
            'quote_no' => request('quote_no'),
        ]);
        
        $repair->lifts()->sync($request->lift_id,false);

        flash('Repair Successfully Created!')->success();
        return back();
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        $jobs = Job::where('status_id', 1)->get();
        $selectedjob = $repair->jobs;
        $lifts = $selectedjob->lifts;
        $technicians = Technician::all();
        
        return view('repairs.showRepairs',compact('repair','jobs','lifts',
        'technicians','selectedjob'));
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
    public function update(Request $request, Repair $repair)
    {
        $repair->update([

            'technician_id' => request('technician_id'),
            'repair_status_id' => request('repair_status_id'),
            'repair_time' => request('repair_time'),
            'chargeable_id' => request('chargeable_id'),
            'repair_description' => request('repair_description'),
            'order_no' => request('order_no'),
            'quote_no' => request('quote_no'),
            'parts_description' => request('parts_description'),

        ]);
        
        $repair->lifts()->sync($request->lift_id,true);

        flash('Repair Successfully Updated!')->success();
        return back();
    }

    public function techdetails(Repair $repair)
    {
        return view('repairs.showTechdetails',compact('repair'));
    }

    public function techupdate(Request $request, Repair $repair)
    {
        $repair->update([

            'time_of_arrival' => request('time_of_arrival'),
            'time_of_departure' => request('time_of_departure'),
            'parts_required' => request('parts_required')      

        ]);

        flash('Repair Tech Details Successfully Updated!')->success();
        return back();
    }

    public function repairjob(Repair $repair)
    {
        $job = $repair->jobs;
        $rounds = Round::all();
        $frequency = Frequency::all();
        $agents = Agent::all();
        $contract = Contract::all();
        $status = JobStatus::all();
        $selectedFrequency = $job->frequency;
        $selectedRound = $job->rounds;
        $selectedAgent = $job->agents;
        $selectedContract = $job->contract;
        $selectedStatus = $job->status;
        
        return view('repairs.showRepairJob',compact
        ('repair','job','selectedRound','rounds','selectedFrequency','frequency','selectedAgent','agents','selectedContract','contract','status','selectedStatus'));
    }

    public function round(Repair $repair)
    {
        $round = $repair->jobs->rounds;
        return view('repairs.roundtable',compact('repair','round'));
    }

    public function file(Repair $repair)
    {
        return view('repairs.fileupload',compact('repair'));
    }

    public function uploadfile(Repair $repair,Request $request)
    {
        $file = $request->file('file');
        // $validator = Validator::make($request->all(), [
        //     'file' => 'max:2060', //2MB 
        // ]);

        if($file){
            $fileName = $file->getClientOriginalName();
            $file->move('repairs',$fileName);
            $filePath = "/repairs/$fileName";
            $repair->files()->create([
                'title' => $fileName,
                'path' => $filePath
            ]);
        }
        // flash('File Successfully Uploaded!')->success();
        // return back();
    }

    public function deletefile(Repair $repair,File $file)
    {
        $file->delete();
        unlink(public_path($file->path));
        flash('File Successfully Deleted!')->error();
        return back();
    }

    public function notes(Repair $repair)
    {
        $notes = $repair->notes;
        return view('repairs.repairNotes',compact('repair','notes'));
    }

    public function print($id)
    {
        $logo =  storage_path().'/logo.png';
        $repair = Repair::select()->where('id',$id)->get()->first();        
        return view('repairs.printRepairs',compact('repair','logo'));
    }

    public function pdf($id)
    {
        $logo =  storage_path().'/logo.png';
        $repair = Repair::select()->where('id',$id)->get()->first(); 
        $job = $repair->jobs->job_name;
        $pdf = PDF::loadView('repairs.printRepairs',compact('repair','logo'))->setPaper('a4', 'portrait');;

        return $pdf->download($id."-".$job.".pdf");
    }

    public function addnotes(Repair $repair,Request $request)
    {
        Note::create([
            'description' => request('description'),
            'user_id' => Auth::user()->id,
            'repair_id' => $repair->id,
        ]);

        flash('Notes Successfully Added!')->success();
        return back();
    }

    public function deletenote(Repair $repair,Note $note)
    {
        $note->delete();
        flash('Note Successfully Deleted!')->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $repair= Repair::findorfail($request->repair_id);
        $repair>lifts()->detach();
        $repair>files()->delete();
        $repair>delete();
        flash('Repair Successfully Deleted!')->error();
        return back();
    }
}
