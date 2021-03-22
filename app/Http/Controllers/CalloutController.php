<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use App\Callout;
use App\Calloutn;
use App\CalloutLift;
use App\Calloutreport;
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
use App\Lift;
use App\CalloutTime;


use Illuminate\Support\Facades\Mail;
use App\Mail\CalloutMail;
use PDF;
use GoogleCloudPrint;

class CalloutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }

    public function open()
    {
        $openCallouts = Calloutn::where('callout_status_id', '1')
            ->orderby('callout_time', 'desc')
            ->get();

        return view('callouts.openCallouts', compact('openCallouts'));
    }

    public function closed()
    {
        $closedCallouts = Calloutn::select('calloutsnew.*', 'callout_reports.status as report_status')->where('callout_status_id', '2')
            ->leftjoin('callout_reports', 'callout_reports.calloutn_id', '=', 'calloutsnew.id')
            ->orderby('calloutsnew.callout_time', 'desc')
            ->limit(1000)
            ->get();

        return view('callouts.closedCallouts', compact('closedCallouts'));
    }

    public function followup()
    {
        $followupCallouts = Calloutn::where('callout_status_id', '4')
            ->orderby('callout_time', 'desc')
            ->get();

        return view('callouts.followupCallouts', compact('followupCallouts'));
    }

    public function shutdown()
    {
        $shutdownCallouts = Calloutn::where('callout_status_id', '3')
            ->orderby('callout_time', 'desc')
            ->get();

        return view('callouts.shutdownCallouts', compact('shutdownCallouts'));
    }

    public function underrepair()
    {
        $underrepairCallouts = Calloutn::where('callout_status_id', '5')
            ->orderby('callout_time', 'desc')
            ->get();

        return view('callouts.underrepairCallouts', compact('underrepairCallouts'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function selectedJob(Request $request)
    {
        $selectedJob = Job::find($request->message);

        Session::put('selectedJob', $selectedJob);
        $response = [];

        $response['lifts'] = LIft::select()->where('job_id', $selectedJob->id)->get();
        $response['technician'] =  DB::table('technicians')
            ->select(['technicians.id', 'technicians.technician_name'])
            ->leftJoin('jobs', 'jobs.round_id', '=', 'technicians.round_id')
            ->where('jobs.id', '=', $selectedJob->id)
            ->where('technicians.status_id', '=', 1)
            ->where('technicians.id', '>', 0)
            ->orderBy('technicians.updated_at', 'DESC')
            ->get()->first();

        echo json_encode($response);
    }

    public function create()
    {
        $faults = Fault::all();
        $jobs = Job::where('status_id', 1)->get();
        $lifts = "";
        $technicians = Technician::where('status_id', 1)->get();
        $selectedTech = array();
        if (Session::has('selectedJob')) {
            $selectedJob = Session::get('selectedJob');
            $lifts = Job::findorfail($selectedJob->id)->lifts;
            $selectedTech = Job::findorfail($selectedJob->id)->rounds->techs;
        }
        return view('callouts.createCallouts', compact('faults', 'jobs', 'technicians', 'lifts', 'selectedTech'));
    }

    public function store(Request $request)
    {
        $callout = Calloutn::create([

            'job_id' => request('job_id'),
            'technician_id' => request('technician_id'),
            'callout_status_id' => request('callout_status_id'),
            'callout_time' => request('callout_time'),
            'floor_no' => request('floor_no'),
            'fault_id' => request('fault_id'),
            'priority_id' => request('priority_id'),
            'callout_description' => request('callout_description'),
            'order_number' => request('order_number'),
            'contact_details' => request('contact_details'),
            // 'notify_email' => request('notify_email'),
            'reported_customer' => request('reported_customer'),

        ]);

        $callout->lifts()->sync($request->lift_id, false);

        $callouttime = CalloutTime::create([

            'calloutn_id' => $callout->id,
            'technician_id' => request('technician_id'),
        ]);

        flash('Callout Successfully Created!')->success();
        return back();
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Calloutn $callout)
    {
        $jobs = Job::where('status_id', 1)->get();
        $selectedjob = $callout->jobs;
        $faults = Fault::all();
        $lifts = $selectedjob->lifts;
        $technicians = Technician::all();

        return view('callouts.showCallouts', compact('callout', 'jobs', 'lifts', 'faults', 'technicians', 'selectedjob'));
    }

    public function techdetails(Calloutn $callout)
    {
        $techfaults = TechFault::all();
        $corrections = Correction::all();
        $callouttime = CalloutTime::select()->where('calloutn_id', $callout->id)->get()->first();

        $accept_lat = $callouttime != null && ($callouttime->accept_location != null || $callouttime->accept_location != '') ? json_decode($callouttime->accept_location)->lat : '';
        $accept_lng = $callouttime != null && ($callouttime->accept_location != null || $callouttime->accept_location != '') ? json_decode($callouttime->accept_location)->lng : '';
        $decline_lat = $callouttime != null && ($callouttime->decline_location != null || $callouttime->decline_location != '') ? json_decode($callouttime->decline_location)->lat : '';
        $decline_lng = $callouttime != null && ($callouttime->decline_location != null || $callouttime->decline_location != '') ? json_decode($callouttime->decline_location)->lng : '';

        $start_lat = $callouttime != null && ($callouttime->start_location != null || $callouttime->start_location != '') ? json_decode($callouttime->start_location)->lat : '';
        $start_lng = $callouttime != null && ($callouttime->start_location != null || $callouttime->start_location != '') ? json_decode($callouttime->start_location)->lng : '';
        $finish_lat = $callouttime != null && ($callouttime->finish_location != null || $callouttime->finish_location != '') ? json_decode($callouttime->finish_location)->lat : '';
        $finish_lng = $callouttime != null && ($callouttime->finish_location != null || $callouttime->finish_location != '') ? json_decode($callouttime->finish_location)->lng : '';


        //dd($callout);;;
        return view('callouts.showCalloutsTechDetails', compact(
            'callout',
            'techfaults',
            'corrections',
            'callouttime',
            'accept_lat',
            'accept_lng',
            'decline_lat',
            'decline_lng',
            'start_lat',
            'start_lng',
            'finish_lat',
            'finish_lng'
        ));
    }

    public function techupdate(Request $request, Calloutn $callout)
    {
        $callout->update([
            'time_of_arrival' => request('time_of_arrival') ? date('Y-m-d H:i:s', strtotime(request('time_of_arrival'))) : NULL,
            'time_of_departure' =>   request('time_of_departure') ? date('Y-m-d H:i:s', strtotime(request('time_of_departure'))) : NULL,
            'rectification_time' =>  request('rectification_time') ? date('Y-m-d H:i:s', strtotime(request('rectification_time'))) : NULL,
            'technician_fault_id' => request('technician_fault_id'),
            'correction_id' => request('correction_id'),
            'tech_description' => request('tech_description'),
            'attributable_id' => request('attributable_id'),
            'chargeable_id' => request('chargeable_id'),
            'part_description' => request('part_description'),
            'part_required' => request('part_required'),
            'part_replaced' => request("part_replaced"),

        ]);

        $callouttime = CalloutTime::select()->where('calloutn_id', $callout->id)->get()->first();

        if (isset($callouttime)) {
            $callouttime->update([

                'accept_time' =>  request('time_of_callout_start') ? date('Y-m-d H:i:s', strtotime(request('time_of_callout_start'))) : NULL,
                'toa' =>  request('mtime_of_arrival') ? date('Y-m-d H:i:s', strtotime(request('mtime_of_arrival'))) : NULL,
                'tod' =>  request('mtime_of_departure') ? date('Y-m-d H:i:s', strtotime(request('mtime_of_departure'))) : NULL,
            ]);
            flash('Callout Tech Details Successfully Updated!')->success();
            return back();
        } else {
            flash('Error updating callout')->error();
            return back();
        }
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
    public function update(Request $request, Calloutn $callout)
    {
        $callout->update([

            'technician_id' => request('technician_id'),
            'callout_status_id' => request('callout_status_id'),
            'callout_time' => request('callout_time'),
            'floor_no' => request('floor_no'),
            'fault_id' => request('fault_id'),
            //'priority_id' => request('priority_id'),
            //'attributable_id' => request('attributable_id'),
            'callout_description' => request('callout_description'),
            'order_number' => request('order_number'),
            'chargeable_id' => request('chargeable_id'),
            'part_description' => request('part_description'),
            'contact_details' => request('contact_details'),
            'notify_email' => request('notify_email'),
            'reported_customer' => request('reported_customer'),

        ]);

        $callout->lifts()->sync($request->lift_id, true);

        flash('Callout Successfully Updated!')->success();
        return back();
    }

    public function calloutjob(Calloutn $callout)
    {
        $job = $callout->jobs;
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

        return view('callouts.showCalloutJob', compact('callout', 'job', 'selectedRound', 'rounds', 'selectedFrequency', 'frequency', 'selectedAgent', 'agents', 'selectedContract', 'contract', 'status', 'selectedStatus'));
    }

    public function round(Calloutn $callout)
    {
        $round = $callout->jobs->rounds;
        return view('callouts.roundtable', compact('callout', 'round'));
    }

    public function file(Calloutn $callout)
    {
        return view('callouts.fileupload', compact('callout'));
    }

    public function uploadfile(Calloutn $callout, Request $request)
    {
        $file = $request->file('file');
        // $validator = Validator::make($request->all(), [
        //     'file' => 'max:2060', //2MB 
        // ]);

        if ($file) {
            $fileName = $file->getClientOriginalName();
            $file->move('callouts', $fileName);
            $filePath = "/callouts/$fileName";
            $callout->files()->create([
                'title' => $fileName,
                'path' => $filePath
            ]);
        }
        flash('File Successfully Uploaded!')->success();
        return back();
    }

    public function deletefile(Calloutn $callout, File $file)
    {
        $file->delete();
        unlink(public_path($file->path));
        flash('File Successfully Deleted!')->success();
        return back();
    }

    public function notes(Calloutn $callout)
    {
        $notes = $callout->notes;
        return view('callouts.calloutNotes', compact('callout', 'notes'));
    }

    public function addnotes(Calloutn $callout, Request $request)
    {
        Note::create([
            'description' => request('description'),
            'user_id' => Auth::user()->id,
            'calloutn_id' => $callout->id,
        ]);

        flash('Notes Successfully Added!')->success();
        return back();
    }

    public function deletenote(Calloutn $callout, Note $note)
    {
        $note->delete();
        flash('Note Successfully Deleted!')->success();
        return back();
    }

    public function print($id)
    {
        $logo =  storage_path() . '/logo.png';
        $callout = Calloutn::select()->where('id', $id)->get()->first();
        $callouttime = CalloutTime::select()
            ->where('calloutn_id', $callout->id)
            ->where('technician_id', $callout->technician_id)
            ->orderBy('updated_at', 'desc')
            ->get()->first();
        $files = File::select()->where('calloutn_id', $id)->get();
        return view('callouts.printCallout', compact('callout', 'logo', 'callouttime', 'files'));
    }

    public function pdf($id)
    {
        $callout = Calloutn::select()->where('id', $id)->get()->first();
        $job = $callout->jobs->job_name;
        $callout_time = $callout->callout_time;
        $job_address = $callout->jobs->job_address;
        $callouttime = CalloutTime::select()
            ->where('calloutn_id', $callout->id)
            ->where('technician_id', $callout->technician_id)
            ->orderBy('updated_at', 'desc')
            ->get()->first();
        $logo =  storage_path() . '/logo.png';
        $files = File::select()->where('calloutn_id', $id)->get();
        $pdf = PDF::loadView('callouts.printCallout', compact('callout', 'logo', 'callouttime', 'files'))->setPaper('a4', 'portrait');;

        return $pdf->download($id . "-" . $job . "-" . $callout_time . ".pdf");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $callout = Calloutn::findorfail($request->callout_id);
        $callout->lifts()->detach();
        $callout->files()->delete();
        $callout->delete();
        flash('Callout Successfully Deleted!')->success();
        return back();
    }


    /**
     * Additional functions for Print/Send email
     * 
     *
     */

    public function calloutSendEmail(Request $request)
    {
        $path = storage_path() . '/pdf/callout/';
        $calloutid = $request['callout_id'];
        $callout = Calloutn::select()->where('id', $calloutid)->get()->first();
        $callouttime = CalloutTime::select()->where('calloutn_id', $calloutid)->get()->first();
        $files = File::select()->where('calloutn_id', $calloutid)->get();

        $filename = str_replace(':', ' ', (string)$callout->callout_time);
        $logo =  storage_path() . '/logo.png';

        //generate pdf file
        $pdf = PDF::loadView('callouts.printCallout', compact('callout', 'logo', 'callouttime', 'files'));
        $pdf->save($path . $filename . '.pdf');

        $technician = Technician::select()->where('id', $callout->technician_id)->get()->first();
        $fault = Fault::select()->where('id', $callout->fault_id)->get()->first();
        $tech_fault = TechFault::select()->where('id', $callout->technician_fault_id)->get()->first();
        $correction = Correction::select()->where('id', $callout->correction_id)->get()->first();
        //Send email to job creator with attachments
        //Generate Pdf file
        $job = Job::select()->where('id', $callout->job_id)->get()->first();

        if ($job) {
            $email = explode(';', $job->job_email);

            if (count($email) > 0) {
                $address = $job->job_address_number . " " . $job->job_address;
                $subject = "United Lifts Call Report";
                $description = str_replace("\r\n", "<br>", $callout->callout_description);
                $fault = $fault->fault_name;

                $technician_fault = '';
                if (isset($tech_fault)) {
                    $technician_fault = $tech_fault->technician_fault_name;
                }

                $correction_name = '';
                if (isset($correction)) {
                    $correction_name = $correction->correction_name;
                }

                $tech_description = str_replace("\r\n", "<br>", $callout->tech_description);
                $toc = date("d-m-Y G:i:s", strtotime($callout->callout_time));
                $toa = date("d-m-Y G:i:s", strtotime($callout->time_of_arrival));
                $tod = date("d-m-Y G:i:s", strtotime($callout->time_of_departure));
                $order_number = $callout->order_number;

                $lift_names = '';
                $lifts = CalloutLift::select('lifts.lift_name as lift_name')->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                    ->where('callout_lift.calloutn_id', $callout->id)->get();
                foreach ($lifts as $lift) {
                    $lift_names .= $lift->lift_name . ', ';
                }
                $lift_names = substr($lift_names, 0, strlen($lift_names) - 2);

                $user_email = $technician->technician_email;
                if ($order_number == "") {
                    $order_number = "N/A";
                }

                $link = url("/callouts/" . $calloutid . "/print");

                $myID = $callout->docket_number;


                $message = "                  
                    <p>This notification is to advise completion of your call out (Docket Number: $myID, Order Number: $order_number) to Unit('s)<br>&nbsp;<br>
                    <b>$lift_names</b> at <b>$address</b> on <b>$toc</b>.</p>
                    <p>The fault as reported to us was '<b>$fault</b>' - '<b>$description</b>'. Our technician attended at <b>$toa</b>.</p>
                    <p>The cause of the fault was '<b>$technician_fault</b>', and the technicians rectification was <b>'$correction_name'</b> - '<b>$tech_description</b>'.</p>
                    Our technician departed at <b>$tod</b>.</p>
                    <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                    <p>Thank you for your continued patronage.</p>
                    <p>$link</p>
                    <p>United Lift Services</p>               
                ";



                $from = "call@unitedlifts.com.au";
                $domain  = "unitedlifts.com.au";
                Mail::to($email)->send(new CalloutMail($from, $domain, $subject, $message, $filename));


                $report = Calloutreport::select()->where('calloutn_id', $callout->id)->get()->first();

                if ($report) {
                    $report->status = 'both';
                    $report->save();
                } else {
                    Calloutreport::create([
                        'calloutn_id' => $callout->id,
                        'status' => 'sent'
                    ]);
                }
                flash('Callout Successfully Emailed!')->success();
                return redirect('/callouts/closedcallouts');
            }
        }
    }

    public function calloutPrint(Request $request)
    {

        // echo phpinfo();
        //  exit;
        $printerId = 'c93cc4db-d76e-1f12-3364-86dc9d640884';
        $calloutid = request('callout_id');

        $report = Calloutreport::select()->where('calloutn_id', $calloutid)->get()->first();

        if ($report) {
            if ($report->status == 'sent') {
                $callout = Calloutn::select()->where('id', $calloutid)->get()->first();
                $path = storage_path() . '/pdf/callout/';
                $filename = str_replace(':', ' ', (string)$callout->callout_time);


                GoogleCloudPrint::asPdf()
                    ->file($path . $filename . '.pdf')
                    ->printer($printerId)
                    ->send();
                $report->status = 'both';
                $report->save();
            }
        } else {

            $callout = Calloutn::select()->where('id', $calloutid)->get()->first();

            $path = storage_path() . '/pdf/callout/';
            $filename = str_replace(':', ' ', (string)$callout->callout_time);
            $logo =  storage_path() . '/logo.png';

            //generate pdf file
            $pdf = PDF::loadView('callouts.printCallout', compact('callout', 'logo'));
            $pdf->save($path . $filename . '.pdf');

            GoogleCloudPrint::asPdf()
                ->file($path . $filename . '.pdf')
                ->printer($printerId)
                ->send();

            Calloutreport::create([
                'calloutn_id' => $callout->id,
                'status' => 'print'
            ]);
        }
        flash('Callout Successfully Printed!')->success();
        return redirect('/callouts/closedcallouts');
    }
}
