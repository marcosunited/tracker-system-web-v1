<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Frequency;
use App\Round;
use App\Agent;
use App\Contract;
use App\JobStatus;
use App\File;
use App\Note;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJob;
use Illuminate\Support\Facades\Auth;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = DB::select("select *, 
                            case 
                                when contract_flag = 2 then 'contract_ok.svg'
                                when contract_flag = 1 then 'contract_coming_due.svg'
                                when contract_flag = 0 then 'contract_overdue.svg'
                                else 'no_information.svg'
                            end as contract_icon
                            FROM (
                            select 
                                jobs.id,
                                job_suburb,
                                job_number,
                                job_name,
                                job_floors,
                                job_address,
                                job_address_number,
                                job_contact_details,
                                job_owner_details,
                                job_group,
                                status_name,
                                round_name,
                                round_colour,
                                f.frequency_name,
                                (select count(*) from lifts where lifts.job_id= jobs.id) as lift_count,
                                case 
                                    when DATE_SUB(STR_TO_DATE(finish_time, '%Y-%m-%d'), INTERVAL 30 DAY) >= NOW() then 2
                                    when DATE_SUB(STR_TO_DATE(finish_time, '%Y-%m-%d'), INTERVAL 30 DAY) < NOW() AND STR_TO_DATE(finish_time, '%Y-%m-%d') > DATE_SUB(NOW(), INTERVAL 1 DAY) then 1
                                    when DATE_SUB(STR_TO_DATE(finish_time, '%Y-%m-%d'), INTERVAL 30 DAY) < NOW() then 0
                                else -1
                                end as contract_flag
                            from jobs 
                            inner join rounds on jobs.round_id = rounds.id
                            inner join _frequency f on frequency_id = f.id
                            left join _jobstatus j on jobs.status_id = j.id
                            ) as jobs;");

        return view('jobs.allJobs', compact('jobs'));
    }

    public function callouts(Job $job)
    {
        $callouts = $job->callouts;

        return view('jobs.calloutsTable', compact('callouts', 'job'));
    }

    public function maintenances(Job $job)
    {
        $maintenances = $job->maintenances;

        return view('jobs.maintenanceTable', compact('maintenances', 'job'));
    }

    public function repairs(Job $job)
    {
        $closedrepairs = $job->repairs;

        return view('jobs.repairTable', compact('closedrepairs', 'job'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rounds = Round::all();
        $frequency = Frequency::all();
        $agents = Agent::all();
        $contract = Contract::all();
        $status = JobStatus::all();
        return view('jobs.createJob', compact('rounds', 'frequency', 'agents', 'contract', 'status'));
    }

    /**
     * Store the incoming Job
     *
     * @param  StoreJob  $request
     * @return Response
     */
    public function store(StoreJob $request)
    {
        $validated = $request->validated();
        Job::create([

            'agent_id' => request('agent_id'),
            'contract_id' => request('contract_id'),
            'frequency_id' => request('frequency_id'),
            'start_time' => request('start_time'),
            'finish_time' => request('finish_time'),
            'cancel_time' => request('cancel_time'),
            'status_id' => request('status_id'),
            'active_time' => request('active_time'),
            'inactive_time' => request('inactive_time'),
            'job_number' => request('job_number'),
            'job_name' => request('job_name'),
            'price' => request('price'),
            'cpi' => request('cpi'),
            'job_floors' => request('job_floors'),
            'job_address' => request('job_address'),
            'job_address_number' => request('job_address_number'),
            'job_suburb' => request('job_suburb'),
            'job_contact_details' => request('job_contact_details'),
            'job_email' => request('job_email'),
            'job_owner_details' => request('job_owner_details'),
            'job_group' => request('job_group'),
            'round_id' => request('round_id'),
            'job_agent_contact' => request('job_agent_contact'),
            'job_key_access' => request('job_key_access'),
            'notify_instant' => '0',
            'tel_phone' => request('tel_phone'),
            'note' => request('note'),

        ]);

        flash('Job Successfully Added!')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
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

        return view('jobs.jobDetails', compact('job', 'selectedRound', 'rounds', 'selectedFrequency', 'frequency', 'selectedAgent', 'agents', 'selectedContract', 'contract', 'status', 'selectedStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Job $job)
    {
        try {

            $rules = array(
                'agent_id' => 'required',
                'contract_id' => 'required',
                'status_id' => 'required',
                'job_number' => 'required',
                'job_name' => 'required',
                'job_floors' => 'required',
                'job_address' => 'required',
                'job_address_number' => 'required',
                'job_suburb' => 'required',
                'job_email' => 'required',
                'job_group' => 'required',
                'round_id' => 'required',
                'job_address_number' => 'required',
                'job_key_access' => 'required'
            );

            $request->validate(
                $rules
            );

            $job->update([

                'agent_id' => request('agent_id'),
                'contract_id' => request('contract_id'),
                'frequency_id' => request('frequency_id'),
                'start_time' => request('start_time'),
                'finish_time' => request('finish_time'),
                'cancel_time' => request('cancel_time'),
                'status_id' =>  request('status_id'),
                'active_time' => request('active_time'),
                'inactive_time' => request('inactive_time'),
                'job_number' => request('job_number'),
                'job_name' => request('job_name'),
                'price' => request('price'),
                'cpi' => request('cpi'),
                'job_floors' => request('job_floors'),
                'job_address' => request('job_address'),
                'job_address_number' => request('job_address_number'),
                'job_suburb' => request('job_suburb'),
                'job_contact_details' => request('job_contact_details'),
                'job_email' => request('job_email'),
                'job_owner_details' => request('job_owner_details'),
                'job_group' => request('job_group'),
                'round_id' => request('round_id'),
                'job_agent_contact' => request('job_agent_contact'),
                'job_key_access' => request('job_key_access'),
                'notify_instant' => '0',
                'tel_phone' => request('tel_phone'),
                'note' => request('note'),
            ]);

            flash('Job Successfully Updated!')->success();
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $message = json_encode($exception->validator->getMessageBag()->getMessages());
            flash('Error saving job: ' . $message)->error();
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validated();
        $job->update([

            'agent_id' => request('agent_id'),
            'contract_id' => request('contract_id'),
            'frequency_id' => request('frequency_id'),
            'start_time' => request('start_time'),
            'finish_time' => request('finish_time'),
            'cancel_time' => request('cancel_time'),
            'status_id' =>  request('status_id'),
            'active_time' => request('active_time'),
            'inactive_time' => request('inactive_time'),
            'job_number' => request('job_number'),
            'job_name' => request('job_name'),
            'price' => request('price'),
            'cpi' => request('cpi'),
            'job_floors' => request('job_floors'),
            'job_address' => request('job_address'),
            'job_address_number' => request('job_address_number'),
            'job_suburb' => request('job_suburb'),
            'job_contact_details' => request('job_contact_details'),
            'job_email' => request('job_email'),
            'job_owner_details' => request('job_owner_details'),
            'job_group' => request('job_group'),
            'round_id' => request('round_id'),
            'job_agent_contact' => request('job_agent_contact'),
            'job_key_access' => request('job_key_access'),
            'notify_instant' => '0',
            'tel_phone' => request('tel_phone'),
            'note' => request('note'),
        ]);

        flash('Job Successfully Updated!')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function file(Job $job)
    {
        return view('jobs.fileupload', compact('job'));
    }

    public function round(Job $job)
    {
        $round = $job->rounds;
        return view('jobs.jobround', compact('job', 'round'));
    }

    public function uploadfile(Job $job, Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $fileName = $file->getClientOriginalName();
            $file->move('jobs', $fileName);
            $filePath = "/jobs/$fileName";
            $job->files()->create([
                'title' => $fileName,
                'path' => $filePath
            ]);
        }
        // flash('File Successfully Uploaded!')->success();
        // return back();
    }

    public function deletefile(Job $job, File $file)
    {
        $file->delete();
        unlink(public_path($file->path));
        flash('File Successfully Deleted!')->success();
        return back();
    }

    public function notes(Job $job)
    {
        $notes = $job->notes;
        return view('jobs.jobnotes', compact('job', 'notes'));
    }

    public function addnotes(Job $job, Request $request)
    {
        Note::create([
            'description' => request('description'),
            'user_id' => Auth::user()->id,
            'job_id' => $job->id,
        ]);

        flash('Notes Successfully Added!')->success();
        return back();
    }

    public function deletenote(Job $job, Note $note)
    {
        $note->delete();
        flash('Note Successfully Deleted!')->success();
        return back();
    }

    public function destroy($id)
    {
        //
    }
}
