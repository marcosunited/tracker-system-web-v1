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
use App\CalloutLift;
use PDF;
use App\TechFault;

class ReportNewController extends Controller
{
    public function selectedJob(Request $request)
    {
        $selectedJob = Job::find($request->message);

        if ($selectedJob == null && $request->message == "-1") {
            $selectedJob = $request->message;
        }

        Session::put('selectedJob', $selectedJob);
        return back();
    }

    public function sitereport()
    {
        $lifts = "";

        if (Session::has('selectedJob')) {
            $selectedJob = Session::get('selectedJob');
            if ($selectedJob != null) {
                //$lifts = Job::findorfail($selectedJob->id)->lifts;
            }
        }

        $jobs = Job::where('status_id', 1)->get();

        return view('reportnew.siteReport', compact('jobs', 'lifts'));
    }


    public function sitereportgenerate(Request $request)
    {
        $job_id = $request->job_id;
        $job = Job::findorfail($job_id);

        $start_date = date($request->start_time);
        $end_date = date($request->finish_time);


        $final_callouts = [];
        $callouts = DB::table('calloutsnew')
            ->whereBetween('calloutsnew.callout_time', [$start_date, $end_date])
            ->where('job_id', '=', $job_id)
            ->join('_faults', 'calloutsnew.fault_id', '=', '_faults.id')
            ->join('_technician_faults', 'calloutsnew.technician_fault_id', '=', '_technician_faults.id')
            ->join('technicians', 'calloutsnew.technician_id', '=', 'technicians.id')
            ->select(
                'calloutsnew.*',
                '_faults.fault_name as fault_name',
                '_technician_faults.technician_fault_name as technician_fault_name',
                'technicians.technician_name as technician_name'
            )
            ->get();


        foreach ($callouts as $callout) {

            $tp = [];
            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();

            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $tp['callout'] = $callout;
            $tp['lift'] = $tp_lifts;
            $final_callouts[] = $tp;
        }



        $maintenances = DB::table('maintenancenew')
            ->whereBetween('maintenance_date', [$start_date, $end_date])
            ->where('job_id', '=', $job_id)
            ->join('jobs', 'maintenancenew.job_id', '=', 'jobs.id')
            ->join('technicians', 'maintenancenew.technician_id', '=', 'technicians.id')
            //->join('lifts', 'maintenancenew.lift_id', '=', 'lifts.id')
            ->get();

        $agent_id = $job->agent_id;
        $agent = Agent::where('id', $agent_id)->get();

        $faults = array();
        $results = json_decode($callouts, true);

        foreach ($results as $row) {
            if (!isset($faults[$row['fault_name']]))
                $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportnew.siteReportGenerate', compact('final_callouts', 'job', 'callouts', 'agent', 'start_date', 'end_date', 'faults', 'maintenances'));
    }

    public function groupreport()
    {

        $group_list = DB::select("select distinct job_group from jobs where status_id = 1");

        return view('reportnew.groupReport', compact('group_list'));
    }

    public function groupreportgenerate(Request $request)
    {

        $group_name = $request->job_group;
        $start_date = date($request->start_time);
        $end_date = date($request->finish_time);
        $logo =  ''; //storage_path().'/logobig.png';


        $callouts = DB::table('calloutsnew')
            ->whereBetween('calloutsnew.callout_time', [$start_date, $end_date])
            ->join('jobs', 'calloutsnew.job_id', '=', 'jobs.id')
            ->where('jobs.job_group', $group_name)
            ->join('_faults', 'calloutsnew.fault_id', '=', '_faults.id')
            ->join('_technician_faults', 'calloutsnew.technician_fault_id', '=', '_technician_faults.id')
            ->join('technicians', 'calloutsnew.technician_id', '=', 'technicians.id')
            ->select(
                'calloutsnew.*',
                '_faults.fault_name as fault_name',
                '_technician_faults.technician_fault_name as technician_fault_name',
                'technicians.technician_name as technician_name',
                'jobs.job_name as job_name',
                'jobs.job_number as job_number'
            )
            ->get();

        $final_callouts = (array) null;

        foreach ($callouts as $callout) {

            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();

            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $callout->lift = $tp_lifts;
            array_push($final_callouts, $callout);
        }


        $maintenances = DB::table('maintenancenew')
            ->whereBetween('maintenance_date', [$start_date, $end_date])
            ->join('jobs', 'maintenancenew.job_id', '=', 'jobs.id')
            ->where('jobs.job_group', $group_name)
            ->join('technicians', 'maintenancenew.technician_id', '=', 'technicians.id')
            ->join('lifts', 'maintenancenew.lift_id', '=', 'lifts.id')
            ->get();

        $faults = array();
        $results = json_decode($callouts, true);

        foreach ($results as $row) {
            if (!isset($faults[$row['fault_name']]))
                $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportnew.groupReportGenerate', compact('logo', 'callouts', 'faults', 'group_name', 'start_date', 'end_date', 'maintenances', 'final_callouts',));
    }

    public function calloutreport()
    {
        $jobs = Job::where('status_id', 1)->get();

        return view('reportnew.calloutReport', compact('jobs'));
    }

    public function calloutreportgenerate(Request $request)
    {

        $job_id = $request->job_id;
        $job = null;

        if ($job_id != "-1") {
            $job = Job::findorfail($job_id);
        }

        $start_date = date($request->start_time);
        $end_date = date($request->finish_time);


        $final_callouts = [];
        $callouts = DB::table('calloutsnew')
            ->whereBetween('calloutsnew.callout_time', [$start_date, $end_date])
            ->where(function ($query) {
                if ($job_id = !"-1") {
                    $query->where("job_id", $job_id);
                }
            })
            ->join('_faults', 'calloutsnew.fault_id', '=', '_faults.id')
            ->join('_technician_faults', 'calloutsnew.technician_fault_id', '=', '_technician_faults.id')
            ->join('technicians', 'calloutsnew.technician_id', '=', 'technicians.id')
            ->join('jobs', 'calloutsnew.job_id', '=', 'jobs.id')
            ->select(
                'calloutsnew.*',
                '_faults.fault_name as fault_name',
                '_technician_faults.technician_fault_name as technician_fault_name',
                'technicians.technician_name as technician_name',
                'jobs.job_number as job_number',
                'jobs.job_name as job_name',
                'jobs.job_address as job_address',
                'jobs.job_address_number as job_address_number',
                'jobs.job_suburb as job_suburb'
            )
            ->get();


        foreach ($callouts as $callout) {

            $tp = [];
            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();

            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $tp['callout'] = $callout;
            $tp['lift'] = $tp_lifts;
            $final_callouts[] = $tp;
        }

        $agent = null;

        if ($job != null) {
            $agent_id = $job->agent_id;
            $agent = Agent::where('id', $agent_id)->get();
        }

        $faults = array();
        $results = json_decode($callouts, true);

        foreach ($results as $row) {
            if (!isset($faults[$row['fault_name']]))
                $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportnew.calloutReportGenerate', compact('final_callouts', 'faults', 'agent', 'start_date', 'end_date', 'job'));
    }

    public function maintenancereport()
    {
        $lifts = "";
        if (Session::has('selectedJob')) {
            $selectedJob = Session::get('selectedJob');
            $lifts = Job::findorfail($selectedJob->id)->lifts;
        }
        $jobs = Job::where('status_id', 1)->get();

        return view('reportnew.maintenanceReport', compact('jobs', 'lifts'));
    }

    public function maintenanecreportgenerate(Request $request)
    {
        $job_id = $request->job_id;
        $job = Job::findorfail($job_id);

        $start_date = date($request->start_time);
        $end_date = date($request->finish_time);

        $maintenances = DB::table('maintenancenew')
            ->whereBetween('maintenance_date', [$start_date, $end_date])
            ->join('jobs', 'maintenancenew.job_id', '=', 'jobs.id')
            ->where('job_id', '=', $job_id)
            ->join('technicians', 'maintenancenew.technician_id', '=', 'technicians.id')
            //->join('lifts', 'maintenancenew.lift_id', '=', 'lifts.id')
            ->get();

        $agent_id = $job->agent_id;
        $agent = Agent::where('id', $agent_id)->get();

        return view('reportnew.maintenanceReportGenerate', compact('job', 'maintenances', 'agent', 'start_date', 'end_date'));
    }

    public function pitcleaning()
    {
        return view('reportnew.pitcleaningReport', compact('lifts'));
    }

    public function pitcleaninggenerate(Request $request)
    {

        $start_date = strtotime($request->start_time);
        $end_date = strtotime($request->finish_time);

        $maintenances = DB::table('maintenancenew')
            ->whereBetween('maintenance_date', [$start_date, $end_date])
            ->join('jobs', 'maintenance.job_id', '=', 'jobs.id')
            ->where('job_group', 'like', '%Pit Clean%')
            ->join('technicians', 'maintenance.technician_id', '=', 'technicians.id')
            ->get();

        return view('reportnew.pitcleaningReportGenerate', compact('maintenances', 'agent', 'start_date', 'end_date'));
    }

    public function period()
    {
        $lifts = "";
        if (Session::has('selectedJob')) {
            $selectedJob = Session::get('selectedJob');
            $lifts = Job::findorfail($selectedJob->id)->lifts;
        }
        $jobs = Job::where('status_id', 1)->get();
        return view('reportnew.peroidReport', compact('lifts', 'jobs'));
    }

    public function periodgenerate(Request $request)
    {

        $start_date = date($request->start_time);
        $end_date = date($request->finish_time);

        $final_callouts = [];
        $callouts = DB::table('calloutsnew')
            ->whereBetween('calloutsnew.callout_time', [$start_date, $end_date])
            ->join('jobs', 'calloutsnew.job_id', '=', 'jobs.id')
            ->join('_faults', 'calloutsnew.fault_id', '=', '_faults.id')
            ->join('_technician_faults', 'calloutsnew.technician_fault_id', '=', '_technician_faults.id')
            ->join('technicians', 'calloutsnew.technician_id', '=', 'technicians.id')
            ->select(
                'calloutsnew.*',
                '_faults.fault_name as fault_name',
                '_technician_faults.technician_fault_name as technician_fault_name',
                'technicians.technician_name as technician_name',
                'jobs.job_name as job_name',
                'jobs.job_number as job_number'
            )
            ->get();


        foreach ($callouts as $callout) {

            $tp = [];
            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();

            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $tp['callout'] = $callout;
            $tp['lift'] = $tp_lifts;
            $final_callouts[] = $tp;
        }

        $faults = array();
        $results = json_decode($callouts, true);

        foreach ($results as $row) {
            if (!isset($faults[$row['fault_name']]))
                $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }

        return view('reportnew.peroidGenerate', compact('callouts', 'faults', 'start_date', 'end_date', 'final_callouts'));
    }

    public function pdf()
    {
        $group_name = $_GET['jg']; //$request->job_group;
        $start_date = $_GET['st']; //date($request->start_time);
        $end_date = $_GET['ft']; //date($request->finish_time);
        $logo =  storage_path() . '/logobig.png';


        $callouts = DB::table('calloutsnew')
            ->whereBetween('calloutsnew.callout_time', [$start_date, $end_date])
            ->join('jobs', 'calloutsnew.job_id', '=', 'jobs.id')
            ->where('jobs.job_group', $group_name)
            ->join('_faults', 'calloutsnew.fault_id', '=', '_faults.id')
            ->join('_technician_faults', 'calloutsnew.technician_fault_id', '=', '_technician_faults.id')
            ->join('technicians', 'calloutsnew.technician_id', '=', 'technicians.id')
            ->select(
                'calloutsnew.*',
                '_faults.fault_name as fault_name',
                '_technician_faults.technician_fault_name as technician_fault_name',
                'technicians.technician_name as technician_name',
                'jobs.job_name as job_name',
                'jobs.job_number as job_number'
            )
            ->get();

        $final_callouts = (array) null;

        foreach ($callouts as $callout) {

            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();

            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $callout->lift = $tp_lifts;
            array_push($final_callouts, $callout);
        }


        $maintenances = DB::table('maintenancenew')
            ->whereBetween('maintenance_date', [$start_date, $end_date])
            ->join('jobs', 'maintenancenew.job_id', '=', 'jobs.id')
            ->where('jobs.job_group', $group_name)
            ->join('technicians', 'maintenancenew.technician_id', '=', 'technicians.id')
            ->join('lifts', 'maintenancenew.lift_id', '=', 'lifts.id')
            ->get();

        $faults = array();
        $results = json_decode($callouts, true);

        foreach ($results as $row) {
            if (!isset($faults[$row['fault_name']]))
                $faults[$row['fault_name']] = 0;
            $faults[$row['fault_name']]++;
        }
        $pdf = PDF::loadView('reportnew.groupReportGenerate', compact('logo', 'callouts', 'faults', 'group_name', 'start_date', 'end_date', 'maintenances', 'final_callouts'))->setPaper('a3', 'landscape');

        return $pdf->download('Group Report-' . $group_name . '.pdf');
    }
}
