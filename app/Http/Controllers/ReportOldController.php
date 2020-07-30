<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Job;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Agent;
use App\Fault;
use App\TechFault;

class ReportOldController extends Controller
{

    public function selectedJob(Request $request)
    {
        $selectedJob = Job::find($request->message);
        Session::put('selectedJob',$selectedJob);
        return back();
    }

    public function sitereport()
    {
        $lifts = "";
        if(Session::has('selectedJob')){
        $selectedJob = Session::get('selectedJob');
        $lifts = Job::findorfail($selectedJob->id)->lifts;
        }
        $jobs = Job::where('status_id', 1)->get();

        return view('reportsold.siteReport',compact('jobs','lifts'));
    }


    public function sitereportgenerate(Request $request)
    {
        $job_id = $request->job_id;
        $job = Job::findorfail($job_id);
        
        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);
        

        $callouts = DB::table('callouts')
                    ->whereBetween('callout_time', [$start_date, $end_date])
                    ->where('job_id','=',$job_id)
                    ->join('_faults', 'callouts.fault_id', '=', '_faults.id')
                    ->join('_technician_faults', 'callouts.technician_fault_id', '=', '_technician_faults.id')
                    ->join('technicians', 'callouts.technician_id', '=', 'technicians.id')
                    ->get();

        $maintenances = DB::table('maintenance')
                    ->whereBetween('maintenance_date', [$start_date, $end_date])
                    ->where('job_id','=',$job_id)
                    ->join('jobs','maintenance.job_id','=','jobs.id')
                    ->join('technicians', 'maintenance.technician_id', '=', 'technicians.id')
                    ->get();
        
        $agent_id = $job->agent_id;
        $agent = Agent::where('id', $agent_id)->get();

        $faults = array();  
        $results = json_decode($callouts, true);  
			
        foreach($results as $row)
        {
            if(!isset($faults[$row['fault_name']]))
                            $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportsold.siteReportGenerate',compact('job','callouts','agent','start_date','end_date','faults','maintenances'));
    }

    public function groupreport()
    {

        $group_list = DB::select("select distinct job_group from jobs where status_id = 1");

        return view('reportsold.groupReport',compact('group_list'));
    }

    public function groupreportgenerate(Request $request)
    {      

        $group_name = $request->job_group;
        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);
        
        $callouts = DB::table('callouts')
                    ->whereBetween('callout_time', [$start_date, $end_date])
                    ->join('jobs','callouts.job_id','=','jobs.id')
                    ->where('job_group','like', $group_name)
                    ->join('_faults', 'callouts.fault_id', '=', '_faults.id')
                    ->join('_technician_faults', 'callouts.technician_fault_id', '=', '_technician_faults.id')
                    ->join('technicians', 'callouts.technician_id', '=', 'technicians.id')
                    ->get();

        $maintenances = DB::table('maintenance')
                    ->whereBetween('maintenance_date', [$start_date, $end_date])
                    ->join('jobs','maintenance.job_id','=','jobs.id')
                    ->where('job_group','like', $group_name)
                    ->join('technicians', 'maintenance.technician_id', '=', 'technicians.id')
                    ->get();

        $faults = array();  
        $results = json_decode($callouts, true);  
			
        foreach($results as $row)
        {
            if(!isset($faults[$row['fault_name']]))
                            $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportsold.groupReportGenerate',compact('callouts','faults','group_name','start_date','end_date','maintenances'));
    }

    public function calloutreport()
    {
        $lifts = "";
        if(Session::has('selectedJob')){
        $selectedJob = Session::get('selectedJob');
        $lifts = Job::findorfail($selectedJob->id)->lifts;
        }
        $jobs = Job::where('status_id', 1)->get();

        return view('reportsold.calloutReport',compact('jobs','lifts'));
    }

    public function calloutreportgenerate(Request $request)
    {      

        $job_id = $request->job_id;
        $job = Job::findorfail($job_id);
        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);
        
        $callouts = DB::table('callouts')
                    ->whereBetween('callout_time', [$start_date, $end_date])
                    ->where('job_id','=',$job_id)
                    ->join('_faults', 'callouts.fault_id', '=', '_faults.id')
                    ->join('_technician_faults', 'callouts.technician_fault_id', '=', '_technician_faults.id')
                    ->join('technicians', 'callouts.technician_id', '=', 'technicians.id')
                    ->get();

        $agent_id = $job->agent_id;
        $agent = Agent::where('id', $agent_id)->get();

        $faults = array();  
        $results = json_decode($callouts, true);  
			
        foreach($results as $row)
        {
            if(!isset($faults[$row['fault_name']]))
                            $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }
        
        return view('reportsold.calloutReportGenerate',compact('callouts','faults','agent','start_date','end_date','job'));
    }

    public function maintenancereport()
    {
        $lifts = "";
        if(Session::has('selectedJob')){
        $selectedJob = Session::get('selectedJob');
        $lifts = Job::findorfail($selectedJob->id)->lifts;
        }
        $jobs = Job::where('status_id', 1)->get();

        return view('reportsold.maintenanceReport',compact('jobs','lifts'));
    }

    public function maintenanecreportgenerate(Request $request)
    {
        $job_id = $request->job_id;
        $job = Job::findorfail($job_id);
        
        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);

        $maintenances = DB::table('maintenance')
        ->whereBetween('maintenance_date', [$start_date, $end_date])
        ->where('job_id','=',$job_id)
        ->join('jobs','maintenance.job_id','=','jobs.id')
        ->join('technicians', 'maintenance.technician_id', '=', 'technicians.id')
        ->get();

        $agent_id = $job->agent_id;
        $agent = Agent::where('id', $agent_id)->get();

        return view('reportsold.maintenanceReportGenerate',compact('job','maintenances','agent','start_date','end_date'));
    }

    public function pitcleaning()
    {
        return view('reportsold.pitcleaningReport',compact('lifts'));
    }

    public function pitcleaninggenerate(Request $request)
    {

        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);

        $maintenances = DB::table('maintenance')
        ->whereBetween('maintenance_date', [$start_date, $end_date])
        ->join('jobs','maintenance.job_id','=','jobs.id')
        ->where('job_group','like', '%Pit Clean%')
        ->join('technicians', 'maintenance.technician_id', '=', 'technicians.id')
        ->get();

        return view('reportsold.pitcleaningReportGenerate',compact('maintenances','agent','start_date','end_date'));
    }

    public function period()
    {
        return view('reportsold.peroidReport',compact('lifts'));
    }

    public function periodgenerate(Request $request)
    {
        
        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);
        
        $callouts = DB::table('callouts')
                    ->whereBetween('callout_time', [$start_date, $end_date])
                    ->join('jobs','callouts.job_id','=','jobs.id')
                    ->join('_faults', 'callouts.fault_id', '=', '_faults.id')
                    ->join('_technician_faults', 'callouts.technician_fault_id', '=', '_technician_faults.id')
                    ->join('technicians', 'callouts.technician_id', '=', 'technicians.id')
                    ->get();

        $faults = array();  
        $results = json_decode($callouts, true);  
			
        foreach($results as $row)
        {
            if(!isset($faults[$row['fault_name']]))
                            $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }
        
        return view('reportsold.peroidGenerate',compact('callouts','faults','start_date','end_date'));

    }
}
