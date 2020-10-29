<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Technician;
use App\Round;
use App\Callout;
use App\Calloutn;
use App\Job;
use App\CalloutLift;
use App\Lift;
use App\CalloutTime;
use App\File;
use App\Fault;
use App\Correction;
use App\MaintenanceN;
use App\LiftTask;
use App\ESTask;
use App\MaintenanceComplete;
use App\Http\Controllers\MaintenanceController as MaintenanceController;
use App\TechFault;
use App\Gps;
use App\Calloutreport;
use App\ChecklistActivities;
use App\ChecklistMaintenance;
use App\ChecklistMaintenances;
use App\Maintenancereport;

use PDF;
use GoogleCloudPrint;
use Illuminate\Support\Facades\Mail;
use App\Mail\CalloutMail;
use App\Mail\MaintenanceMail;
use Exception;
use Response;

class TechController extends Controller
{
    /**
     * Technician login
     * Param (email, password)
     */
    public function login(Request $request)
    {
        $email  = $request->get('email');
        $password  = $request->get('password');


        $technician = Technician::select()
            ->where('technician_email', $email)
            ->where('status_id', 1)
            ->where('technician_password', base64_encode($request['password']))->get()->first();
        if ($technician) {
            $locs = Gps::select()->where('user_id', $technician->id);
            if ($locs) $locs->delete();
            echo json_encode(['status' => 'success', 'msg' => 'Logged in', 'user' => $technician]);
        } else {
            echo json_encode(['status' => 'failed', 'msg' => 'Invalid Email or Password', 'user' => null]);
        }
    }

    public function storelocation(Request $request)
    {
        $id = $request->get('id');
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $gps = Gps::create([
            'user_id' => $id,
            'lat' => $lat,
            'lng' => $lng,
        ]);

        echo json_encode(['status' => 'success', 'msg' => 'stored gps']);
    }

    public function logout(Request $request)
    {
        $id  = $request->get('id');

        $locs = Gps::select()->where('user_id', $id);
        if ($locs) $locs->delete();
        echo json_encode(['status' => 'success', 'msg' => 'logged out']);
    }

    public function updateTechnician(Request $request)
    {
        $technician = Technician::select()->where('id', $request['id'])->get()->first();
        $technician->technician_name = $request['name'];
        $technician->technician_email = $request['email'];
        $technician->technician_phone = $request['phone'];
        if ($request['password'] != '')
            $technician->technician_password = base64_encode($request['password']);
        $technician->save();
        echo json_encode(['status' => 'success', 'msg' => 'Logged in', 'user' => $technician]);
    }

    /**
     * Technician callout list
     * Param technician_id
     */
    public function getCalloutlist(Request $request)
    {
        $technician_id = $request->get('technician_id');
        $keyword = $request->get('keyword');
        $callout_list = Calloutn::select(
            'jobs.job_name as job_name',
            'jobs.job_address as job_address',
            'jobs.job_address_number as job_address_no',
            'jobs.job_suburb as job_suburb',
            'jobs.job_latitude as job_lat',
            'jobs.job_longitude as job_long',
            'jobs.tel_phone as telphone',
            'calloutsnew.id as id',
            'calloutsnew.job_id as job_id',
            'calloutsnew.technician_id as technician_id',
            'calloutsnew.callout_status_id as callout_status_id',
            'calloutsnew.callout_time as time'
        )
            ->leftjoin('jobs', 'jobs.id', '=', 'calloutsnew.job_id')
            ->where('calloutsnew.technician_id', $technician_id)
            ->where('calloutsnew.callout_status_id', '!=', 2)
            ->where(function ($query) use ($keyword) {
                if ($keyword != '')
                    $query->where('jobs.job_name', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address_number', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address', 'like', '%' . $keyword . '%');
            })
            ->orderBy('time', 'desc')
            ->get();

        $list = [];
        foreach ($callout_list as $callout) {
            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();
            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $list[] = ['callout' => $callout, 'liftnames' => $tp_lifts, 'lifts' => $lifts];
        }

        echo json_encode(['status' => 'success', 'msg' => 'Get callout lists', 'list' => $list]);
    }
    public function getCalloutClosedlist(Request $request)
    {
        $technician_id = $request->get('technician_id');
        $keyword = $request->get('keyword');
        $callout_list = Calloutn::select(
            'jobs.job_name as job_name',
            'jobs.job_address as job_address',
            'jobs.job_address_number as job_address_no',
            'jobs.job_suburb as job_suburb',
            'jobs.job_latitude as job_lat',
            'jobs.job_longitude as job_long',
            'jobs.tel_phone as telphone',
            'calloutsnew.callout_time as time',
            'calloutsnew.id as id',
            'calloutsnew.job_id as job_id',
            'calloutsnew.technician_id as technician_id',
            'calloutsnew.callout_status_id as callout_status_id'
        )
            ->leftjoin('jobs', 'jobs.id', '=', 'calloutsnew.job_id')
            ->where('calloutsnew.technician_id', $technician_id)
            ->where('calloutsnew.callout_status_id', 2)
            ->where(function ($query) use ($keyword) {
                if ($keyword != '')
                    $query->where('jobs.job_name', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address_number', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address', 'like', '%' . $keyword . '%');
            })
            ->orderBy('time', 'desc')
            ->get();

        $list = [];
        foreach ($callout_list as $callout) {
            $lifts = CalloutLift::select('lifts.lift_name as lift_name')
                ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
                ->where('callout_lift.calloutn_id', $callout->id)->get();
            $tp_lifts = '';
            foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;
            $list[] = ['callout' => $callout, 'liftnames' => $tp_lifts, 'lifts' => $lifts];
        }

        echo json_encode(['status' => 'success', 'msg' => 'Get callout lists', 'list' => $list]);
    }
    /**
     * Technician callout detail
     * Param callout_id
     */
    public function getCalloutdetail(Request $request)
    {
        $callout_id = $request->get('callout_id');
        $callout = Calloutn::select(
            'calloutsnew.*',
            '_faults.fault_name as fault_name',
            '_technician_faults.technician_fault_name as tech_fault_name',
            '_corrections.correction_name as correction_name',
            'callout_times.time_arrival as time_arrival',
            'callout_times.start_location as start_location',
            'callout_times.toa as manual_toa',
            'callout_times.tod as manual_tod'
        )
            ->leftjoin('_faults', '_faults.id', '=', 'calloutsnew.fault_id')
            ->leftjoin('_technician_faults', '_technician_faults.id', '=', 'calloutsnew.technician_fault_id')
            ->leftjoin('_corrections', '_corrections.id', '=', 'calloutsnew.correction_id')
            ->leftjoin('callout_times', 'callout_times.calloutn_id', '=', 'calloutsnew.id')
            ->where('calloutsnew.id', $callout_id)->get()->first();

        $files = File::select()->where('calloutn_id', $callout_id)->where('status', 'verified')->get();

        $job = Job::select('jobs.*', '_contract.contract_name as contract_name', '_frequency.frequency_name as frequency_name', 'rounds.round_name as round_name')
            ->leftjoin('_contract', '_contract.id', '=', 'jobs.contract_id')
            ->leftjoin('_frequency', '_frequency.id', '=', 'jobs.frequency_id')
            ->leftjoin('rounds', 'rounds.id', '=', 'jobs.round_id')
            ->where('jobs.id', $callout->job_id)->get()->first();
        $lifts = CalloutLift::select('lifts.id as lift_id', 'lifts.lift_name as lift_name')
            ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
            ->where('callout_lift.calloutn_id', $callout->id)->get();

        $tp_lifts = '';

        foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;

        echo json_encode(['status' => 'success', 'msg' => 'Get callout detail', 'callout' => $callout, 'job' => $job, 'liftnames' => $tp_lifts, 'lifts' => $lifts, 'files' => $files]);
    }
    public function getCalloutDocketdetail(Request $request)
    {
        $callout_id = $request->get('callout_id');
        $callout = Calloutn::select('calloutsnew.*', '_faults.fault_name as fault_name', 'callout_times.toa as toa', 'callout_times.tod as tod')
            ->leftjoin('_faults', '_faults.id', '=', 'calloutsnew.fault_id')
            ->leftjoin('callout_times', 'callout_times.calloutn_id', '=', 'calloutsnew.id')
            ->where('calloutsnew.id', $callout_id)->get()->first();


        $job = Job::select('jobs.*', '_contract.contract_name as contract_name', '_frequency.frequency_name as frequency_name', 'rounds.round_name as round_name')
            ->leftjoin('_contract', '_contract.id', '=', 'jobs.contract_id')
            ->leftjoin('_frequency', '_frequency.id', '=', 'jobs.frequency_id')
            ->leftjoin('rounds', 'rounds.id', '=', 'jobs.round_id')
            ->where('jobs.id', $callout->job_id)->get()->first();
        $files = File::select()->where('calloutn_id', $callout_id)->where('status', 'verified')->get();
        $faults = TechFault::all();
        $correcitons = Correction::all();
        $docket = null;

        echo json_encode([
            'status' => 'success', 'msg' => 'Get docket detail', 'callout' => $callout, 'job' => $job,
            'docket' => $docket, 'files' => $files, 'faults' => $faults, 'corrections' => $correcitons
        ]);
    }

    public function updateCalloutaction(Request $request)
    {
        $action = $request['action'];
        $callout_id = $request['callout_id'];
        //accept or decline callout
        Calloutn::select()->where('id', $callout_id)->update(['accept_decline' => $action]);

        $callout = Calloutn::select('calloutsnew.*', '_faults.fault_name as fault_name')
            ->leftjoin('_faults', '_faults.id', '=', 'calloutsnew.fault_id')
            ->where('calloutsnew.id', $callout_id)->get()->first();
        $job = Job::select('jobs.*', '_contract.contract_name as contract_name', '_frequency.frequency_name as frequency_name', 'rounds.round_name as round_name')
            ->leftjoin('_contract', '_contract.id', '=', 'jobs.contract_id')
            ->leftjoin('_frequency', '_frequency.id', '=', 'jobs.frequency_id')
            ->leftjoin('rounds', 'rounds.id', '=', 'jobs.round_id')
            ->where('jobs.id', $callout->job_id)->get()->first();
        $lifts = CalloutLift::select('lifts.id as lift_id', 'lifts.lift_name as lift_name')
            ->leftjoin('lifts', 'lifts.id', '=', 'callout_lift.lift_id')
            ->where('callout_lift.calloutn_id', $callout->id)->get();
        $tp_lifts = '';
        foreach ($lifts as $lift_one) $tp_lifts .= ' ' . $lift_one->lift_name;

        //create/update callout_time

        $exist = CalloutTime::select()->where('calloutn_id', $callout_id)->where('technician_id', $callout->technician_id)->get()->first();

        if ($exist) {
            $exist->accept_time = $action == 1 ? date('Y-m-d H:i:s') : null;
            $exist->decline_time = $action == 2 ? date('Y-m-d H:i:s') : null;
            $exist->accept_location = $action == 1 ? json_encode(['lat' => $request->get('lat'), 'lng' => $request->get('lng')]) : '';
            $exist->decline_location = $action == 2 ? json_encode(['lat' => $request->get('lat'), 'lng' => $request->get('lng')]) : '';
            $exist->save();
        } else {
            CalloutTime::create([
                'calloutn_id' => $callout_id,
                'technician_id' => $callout->technician_id,
                'accept_time' => $action == 1 ? date('Y-m-d H:i:s') : null,
                'decline_time' => $action == 2 ? date('Y-m-d H:i:s') : null,
                'accept_location' => $action == 1 ? json_encode(['lat' => $request->get('lat'), 'lng' => $request->get('lng')]) : '',
                'decline_location' => $action == 2 ? json_encode(['lat' => $request->get('lat'), 'lng' => $request->get('lng')]) : '',
            ]);
        }
        echo json_encode(['status' => 'success', 'msg' => 'action done', 'callout' => $callout, 'job' => $job, 'liftnames' => $tp_lifts, 'lifts' => $lifts]);
    }
    public function updateCalloutDocektaction(Request $request)
    {
        $action = $request['action'];
        $callout_id = $request['callout_id'];

        $lat = $request->get('lat') ? $request->get('lat') : 0;
        $lng = $request->get('lng') ? $request->get('lng') : 0;

        $calloutn = Calloutn::select()->where('id', $callout_id)->get()->first();
        if ($calloutn) {
            $callout_time = CalloutTime::select()->where('calloutn_id', $calloutn->id)->get()->first();

            if ($action == 1) { //start
                $calloutn->time_of_arrival = date('Y-m-d H:i:s');
                $callout_time->time_arrival = date('Y-m-d H:i:s');
                $callout_time->start_location = json_encode(['lat' => $lat, 'lng' => $lng]);
            }
            if ($action == 2) {
                $calloutn->time_of_departure = date('Y-m-d H:i:s');
                $callout_time->time_departure = date('Y-m-d H:i:s');
                $callout_time->finish_location = json_encode(['lat' => $lat, 'lng' => $lng]);
                // $tp_toa_date  =  substr($request['toa'],0,10).' '.substr($request['toa'],11,8);
                $callout_time->toa = date('Y-m-d H:i:s', strtotime(substr($request['toa'], 0, 10) . ' ' . substr($request['toa'], 11, 8)));
                $callout_time->tod = date('Y-m-d H:i:s', strtotime(substr($request['tod'], 0, 10) . ' ' . substr($request['tod'], 11, 8)));
            }
            if ($action == 2) { // finish
                $calloutn->callout_status_id = $request['status_id'];
                $calloutn->order_number = $request['order_no'];
                $calloutn->docket_number = $request['docket_no'];
                $calloutn->technician_fault_id  = $request['fault_id'];
                $calloutn->callout_description = $request['callout_description'];
                $calloutn->tech_description = $request['tech_description'];
                $calloutn->part_description = $request['part_description'];
                $calloutn->correction_id = $request['correction'];
                $calloutn->chargeable_id = $request['chargeable'] == 'true' ? 1 : 2;
                $calloutn->part_required = $request['part_required'] == 'true' ? 1 : 0;
                $calloutn->part_replaced = $request['part_replaced'] == 'true' ? 1 : 0;

                $deleted_imgs = File::select()->where('calloutn_id', $calloutn->id)->where('status', 'deleted');
                $deleted_imgs->delete();

                $new_imgs = File::select()->where('calloutn_id', $calloutn->id)->where('status', 'new');
                $new_imgs->update([
                    'status' => 'verified'
                ]);
            }
            $calloutn->save();
            $callout_time->save();
        }


        $callout = Calloutn::select('calloutsnew.*', '_faults.fault_name as fault_name')
            ->leftjoin('_faults', '_faults.id', '=', 'calloutsnew.fault_id')
            ->where('calloutsnew.id', $callout_id)->get()->first();
        $job = Job::select('jobs.*', '_contract.contract_name as contract_name', '_frequency.frequency_name as frequency_name', 'rounds.round_name as round_name')
            ->leftjoin('_contract', '_contract.id', '=', 'jobs.contract_id')
            ->leftjoin('_frequency', '_frequency.id', '=', 'jobs.frequency_id')
            ->leftjoin('rounds', 'rounds.id', '=', 'jobs.round_id')
            ->where('jobs.id', $callout->job_id)->get()->first();
        $docket = null;
        $files = File::select()->where('calloutn_id', $callout_id)->get();
        $faults = Fault::all();
        $corrections = Correction::all();

        echo json_encode([
            'status' => 'success', 'msg' => 'action done', 'callout' => $callout, 'job' => $job,
            'docket' => $docket, 'files' => $files, 'faults' => $faults, 'corrections' => $corrections
        ]);
    }

    public function getLiftdetail(Request $request)
    {
        $lift = Lift::select()->where('id', $request->get('lift_id'))->get()->first();
        echo json_encode(['status' => 'success', 'msg' => 'action done', 'lift' => $lift]);
    }

    /**
     *  Maintenance Functions 
     * 
     * */
    public function getMaintenanceList(Request $request)
    {
        $technician_id = $request->get('technician_id');
        $keyword = $request->get('keyword');

        $related_jobs = MaintenanceN::select('maintenancenew.job_id as job_id')
            ->join('jobs', 'jobs.id', '=', 'maintenancenew.job_id')
            ->where(function ($query) use ($keyword) {
                if ($keyword != '')
                    $query->where('jobs.job_name', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address_number', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address', 'like', '%' . $keyword . '%');
            })
            ->where('maintenancenew.technician_id', '=', $technician_id)
            ->groupBy('maintenancenew.job_id')
            ->where('maintenancenew.completed_id', '=', 1)
            ->limit(20)
            ->get();

        $loop = [];
        foreach ($related_jobs as $one_job) {
            $tp_loop = [];
            $tp_loop['mainId'] = $one_job->id;
            $tp_loop['liftId'] = $one_job->lift_id;
            $loop[] = $tp_loop;
        }


        $retval = [];
        foreach ($related_jobs as $one_job) {
            $lifts = MaintenanceN::select('lift_id')
                ->where('technician_id', $technician_id)
                ->where('maintenancenew.completed_id', '=', 1)
                ->where('job_id', $one_job->job_id)
                ->groupBy('lift_id')->get();

            foreach ($lifts as $lift) {
                $tmp = [];
                $list_base_job = MaintenanceN::select()->where('technician_id', $technician_id)
                    ->where('job_id', $one_job->job_id)
                    ->where('lift_id', $lift->lift_id)
                    ->orderBy('yearmonth', 'asc')
                    ->get();
                $job = Job::select()->where('id', $one_job->job_id)->get()->first();
                $tmp['job_id'] = $job->id;
                $tmp['job_name'] = $job->job_name;
                $tmp['lift'] = Lift::select('lift_type', 'id', 'lift_name')->where('id', $lift->lift_id)->get()->first();
                $tmp['tasks'] = [];
                $tmp['tasks']['n_months'] = [];
                $tmp['tasks']['index_months'] = [];
                $tmp['tasks']['months'] = [];
                //dd($list_base_job);

                foreach ($list_base_job as $one_base_job) {
                    $yearmonth = $one_base_job->yearmonth;
                    $month_key = (int)substr($yearmonth, 4, 2);

                    if (!in_array($yearmonth, $tmp['tasks']['index_months'])) {
                        $tmp['tasks']['index_months'][] = $yearmonth;
                        $tp_month = [];
                        $tp_month['month_index'] = $yearmonth;
                        $tp_month['total_tasks'] = $this->getTotalTasks($one_base_job->lift_id, $month_key);
                        $tp_month['completed_tasks'] = $this->getCompletedTasks($job->id, $one_base_job->lift_id, $yearmonth);
                        $tmp['tasks']['n_months'][] = $tp_month;
                    }
                }

                foreach ($tmp['tasks']['n_months'] as $one_n_month) {
                    $tmp['tasks']['months'][] = [
                        'year' => (int)substr($one_n_month['month_index'], 0, 4),
                        'month' => (int)substr($one_n_month['month_index'], 4, 2),
                        'month_label' => $this->getMonthLabel((int)substr($one_n_month['month_index'], 4, 2)),
                        'mainteances' => $this->getMaintenacesIds($tmp['job_id'], $lift->lift_id, (int)substr($one_n_month['month_index'], 0, 4), substr($one_n_month['month_index'], 4, 2)),
                        'total_tasks' => $one_n_month['total_tasks'],
                        'completed_tasks' => $one_n_month['completed_tasks']
                    ];
                }

                $retval[] = $tmp;
            }
        }

        echo json_encode(['status' => 'success', 'msg' => 'Get Maintenance lists', 'list' => $retval]);
    }

    public function getMaintenanceClosedList(Request $request)
    {
        $technician_id = $request->get('technician_id');
        $keyword = $request->get('keyword');
        // $related_jobs = MaintenanceN::select('job_id')->where('technician_id',$technician_id)
        //                 ->groupBy('job_id')
        //                 ->orderBy('maintenance_date','desc')
        //                 ->limit(10)
        //                 ->get();
        $related_jobs = MaintenanceN::select('maintenancenew.job_id as job_id')
            ->leftjoin('jobs', 'jobs.id', '=', 'maintenancenew.job_id')
            ->where(function ($query) use ($keyword) {
                if ($keyword != '')
                    $query->where('jobs.job_name', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address_number', 'like', '%' . $keyword . '%')
                        ->orWhere('jobs.job_address', 'like', '%' . $keyword . '%');
            })
            ->where('maintenancenew.technician_id', $technician_id)
            ->groupBy('maintenancenew.job_id')
            ->where('maintenancenew.completed_id', 2)
            ->limit(20)
            ->get();

        $loop = [];
        foreach ($related_jobs as $one_job) {
            $tp_loop = [];
            $tp_loop['mainId'] = $one_job->id;
            $tp_loop['liftId'] = $one_job->lift_id;
            $loop[] = $tp_loop;
        }


        $retval = [];
        foreach ($related_jobs as $one_job) {
            $lifts = MaintenanceN::select('lift_id')->where('technician_id', $technician_id)->where('job_id', $one_job->job_id)->groupBy('lift_id')->get();
            foreach ($lifts as $lift) {
                $tmp = [];
                $list_base_job = MaintenanceN::select()->where('technician_id', $technician_id)
                    ->where('job_id', $one_job->job_id)
                    ->where('lift_id', $lift->lift_id)
                    ->orderBy('yearmonth', 'asc')
                    ->get();
                $job = Job::select()->where('id', $one_job->job_id)->get()->first();
                $tmp['job_id'] = $job->id;
                $tmp['job_name'] = $job->job_name;
                $tmp['lift'] = Lift::select('lift_type', 'id', 'lift_name')->where('id', $lift->lift_id)->get()->first();
                $tmp['tasks'] = [];
                $tmp['tasks']['n_months'] = [];
                $tmp['tasks']['index_months'] = [];
                $tmp['tasks']['months'] = [];


                foreach ($list_base_job as $one_base_job) {
                    $yearmonth = $one_base_job->yearmonth;
                    $month_key = (int)substr($yearmonth, 4, 2);
                    if (!in_array($yearmonth, $tmp['tasks']['index_months'])) {
                        $tmp['tasks']['index_months'][] = $yearmonth;
                        $tp_month = [];
                        $tp_month['month_index'] = $yearmonth;
                        $tp_month['total_tasks'] = $this->getTotalTasks($one_base_job->lift_id, $month_key);
                        $tp_month['completed_tasks'] = $this->getCompletedTasks($job->id, $one_base_job->lift_id, $yearmonth);
                        $tmp['tasks']['n_months'][] = $tp_month;
                    }
                }

                foreach ($tmp['tasks']['n_months'] as $one_n_month) {
                    $tmp['tasks']['months'][] = [
                        'year' => (int)substr($one_n_month['month_index'], 0, 4),
                        'month' => (int)substr($one_n_month['month_index'], 4, 2),
                        'month_label' => $this->getMonthLabel((int)substr($one_n_month['month_index'], 4, 2)),
                        'mainteances' => $this->getMaintenacesIds($tmp['job_id'], $lift->lift_id, (int)substr($one_n_month['month_index'], 0, 4), substr($one_n_month['month_index'], 4, 2)),
                        'total_tasks' => $one_n_month['total_tasks'],
                        'completed_tasks' => $one_n_month['completed_tasks']
                    ];
                }
                $retval[] = $tmp;
            }
        }

        echo json_encode(['status' => 'success', 'msg' => 'Get Maintenance lists', 'list' => $retval]);
    }

    public function getTotalTasks($liftid, $month_key)
    {
        $lift = Lift::select()->where('id', $liftid)->get()->first();
        if ($lift->lift_type == 'L') {
            $tasks_monthly  = LiftTask::select()->where('month' . $month_key, 1)->get()->count();
        } else {
            $tasks_monthly  = ESTask::select()->where('month' . $month_key, 1)->get()->count();
        }

        return $tasks_monthly;
    }

    public function getCompletedTasks($jobid, $liftid, $yearmonth)
    {
        $exist = MaintenanceComplete::select()
            ->where('job_id', $jobid)
            ->where('lift_id', $liftid)
            ->where('yearmonth', $yearmonth)
            ->get()
            ->first();
        if ($exist)
            return $exist->completed_tasks;
        else
            return 0;
    }

    public function getMaintenacesIds($jobid, $liftid, $year, $month)
    {
        $mains = MaintenanceN::select()->where('job_id', $jobid)->where('lift_id', $liftid)->where('yearmonth', $year . $month)->orderBy('maintenance_date', 'desc')->get();
        $retval = [];
        foreach ($mains as $main) {
            $tp = [];
            $tp['mainId'] = $main->id;
            $yearmonth = $main->yearmonth;
            $month_key = (int)substr($yearmonth, 4, 2);
            $arrayTasks = json_decode($main->task_ids);

            if (!is_array($arrayTasks)) {
                $tp['tasks'] = count($arrayTasks->{$this->getMonthKey($month_key)});
            }

            $tp['start_flag'] = $main->maintenance_toa != '' ? true : false;
            $tp['finish_flag'] = $main->maintenance_tod != '' ? true : false;
            $tp['date'] = $main->maintenance_date;
            $retval[] = $tp;
        }
        return $retval;
    }

    public function getTasksAmount($lift_id, $flag)
    {

        return $retval;
    }

    public function getMonthKey($month)
    {
        $key = '';
        switch ($month) {
            case 1:
                $key = 'jan';
                break;
            case 2:
                $key = 'feb';
                break;
            case 3:
                $key = 'mar';
                break;
            case 4:
                $key = 'apr';
                break;
            case 5:
                $key = 'may';
                break;
            case 6:
                $key = 'jun';
                break;
            case 7:
                $key = 'jul';
                break;
            case 8:
                $key = 'aug';
                break;
            case 9:
                $key = 'sep';
                break;
            case 10:
                $key = 'oct';
                break;
            case 11:
                $key = 'nov';
                break;
            case 12:
                $key = 'dec';
                break;
        }
        return $key;
    }

    public function getMonthLabel($month)
    {
        $key = '';
        switch ($month) {
            case 1:
                $key = 'January';
                break;
            case 2:
                $key = 'Feburary';
                break;
            case 3:
                $key = 'March';
                break;
            case 4:
                $key = 'April';
                break;
            case 5:
                $key = 'May';
                break;
            case 6:
                $key = 'June';
                break;
            case 7:
                $key = 'July';
                break;
            case 8:
                $key = 'August';
                break;
            case 9:
                $key = 'September';
                break;
            case 10:
                $key = 'October';
                break;
            case 11:
                $key = 'November';
                break;
            case 12:
                $key = 'December';
                break;
        }
        return $key;
    }

    public function getTasksById($ids, $lift_id)
    {
        $retval = [];
        $lift = Lift::select()->where('id', $lift_id)->get()->first();

        foreach ($ids as $one_id) {
            if ($lift->lift_type == 'L')
                $task = LiftTask::select('task_id', 'task_name')->where('task_id', $one_id)->get()->first();
            else
                $task = ESTask::select('task_id', 'task_name')->where('task_id', $one_id)->get()->first();
            $retval[] = $task;
        }
        return $retval;
    }

    public function getMaintenanceDetail(Request $request)
    {
        $maintenance = MaintenanceN::select()->where('id', $request['maintenance_id'])->get()->first();
        $job = Job::select()->where('id', $maintenance->job_id)->get()->first();
        $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();
        $yearmonth = $maintenance->yearmonth;
        $month_key = (int)substr($yearmonth, 4, 2);

        $arrayTasks = json_decode($maintenance->task_ids);
        $tasks = [];

        if (!is_array($arrayTasks)) {
            $task_ids = $arrayTasks->{$this->getMonthKey($month_key)};
            $tasks = $this->getTasksById($task_ids,  $maintenance->lift_id);
        }

        $sopa_tasks = DB::table('tasks_sopa')
            ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
            ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
            ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
            ->where('tasks_sopa.type', '=', $lift->lift_type)
            ->where('maintenancenew.id', '=', $maintenance->id)
            ->orderBy('tasks_sopa.name', 'asc')
            ->get();

        $files = File::select()->where('maintenance_n_id', $request['maintenance_id'])->where('status', 'verified')->get();

        echo json_encode([
            'status' => 'success', 'msg' => 'Get Maintenance detail',
            'maintenance' => $maintenance,
            'job' => $job,
            'lift' => $lift,
            'tasks' => $tasks,
            'SOPATasks' => $sopa_tasks,
            'files' => $files
        ]);
    }

    public function getMonthTaskIDs($taskids, $key)
    {
        return $taskids->$key;
    }

    public function maintenanceUpdate(Request $request)
    {
        $mainID = $request['maintenance_id'];
        $action = $request['action_flag'];
        $pos_lat = $request['pos_lat'];
        $pos_lng = $request['pos_lng'];
        $note = $request['note'];
        $isPartRequired = $request['part_required'];
        $isPartReplaced = $request['part_replaced'];
        $partDescription = $request['part_description'];

        $maintenance = MaintenanceN::select()->where('id', $mainID)->get()->first();

        $jobid = $maintenance->job_id;
        $liftid = $maintenance->lift_id;
        $yearmonth = $maintenance->yearmonth;
        $month_key = (int)substr($yearmonth, 4, 2);

        $arrayTasks = json_decode($maintenance->task_ids);
        $completed_tasks = 0;

        if (!is_array($arrayTasks)) {
            $completed_tasks = count($arrayTasks->{$this->getMonthKey($month_key)});
        }

        $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();

        if ($lift->lift_type == 'L') {
            $tasks_monthly  = LiftTask::select()->where('month' . $month_key, 1)->get()->count();
        } else {
            $tasks_monthly  = ESTask::select()->where('month' . $month_key, 1)->get()->count();
        }

        if ($action == 'start') {

            $maintenance->maintenance_toa = date('Y-m-d H:i');
            $maintenance->start_pos = json_encode(['lat' => $pos_lat, 'lng' => $pos_lng]);

            if ($request['toa'] != '') {
                $maintenance->toa = date('Y-m-d H:i:s', strtotime(substr($request['toa'], 0, 10) . ' ' . substr($request['toa'], 11, 8)));
            } else {
                $maintenance->toa =  date('Y-m-d H:i:s');
            }

            if ($request['tod'] != '') {
                $maintenance->tod = date('Y-m-d H:i:s', strtotime(substr($request['tod'], 0, 10) . ' ' . substr($request['tod'], 11, 8)));
            } else {
                $maintenance->tod = date('Y-m-d H:i:s');
            }

            $maintenance->save();
        }

        if ($action == 'complete') {

            $maintenance->maintenance_tod = date('Y-m-d H:i');
            $maintenance->completed_id = 2;
            $maintenance->finish_pos = json_encode(['lat' => $pos_lat, 'lng' => $pos_lng]);
            $maintenance->maintenance_note = $note;

            if ($request['toa'] != '') {
                $maintenance->toa = date('Y-m-d H:i:s', strtotime(substr($request['toa'], 0, 10) . ' ' . substr($request['toa'], 11, 8)));
            } else {
                $maintenance->toa =  date('Y-m-d H:i:s');
            }

            if ($request['tod'] != '') {
                $maintenance->tod = date('Y-m-d H:i:s', strtotime(substr($request['tod'], 0, 10) . ' ' . substr($request['tod'], 11, 8)));
            } else {
                $maintenance->tod = date('Y-m-d H:i:s');
            }

            $maintenance->part_description = $partDescription;
            $maintenance->part_required = $isPartRequired;
            $maintenance->part_replaced = $isPartReplaced;

            $maintenance->save();
            $status = $tasks_monthly == $completed_tasks ? 'complete' : 'working';

            /** Check completion table **/
            $exist = MaintenanceComplete::select()
                ->where('technician_id', $maintenance->technician_id)
                ->where('job_id', $maintenance->job_id)
                ->where('lift_id', $maintenance->lift_id)
                ->where('yearmonth', $maintenance->yearmonth)
                ->get()
                ->first();

            if ($exist) {
                $exist->completed_tasks += $completed_tasks;
                $exist->status = $status;
                $exist->save();
            } else {
                $exist = MaintenanceComplete::create([
                    'technician_id' => $maintenance->technician_id,
                    'job_id' => $jobid,
                    'lift_id' => $liftid,
                    'yearmonth' => $yearmonth,
                    'month' => $month_key,
                    'completed_tasks' => $completed_tasks,
                    'status' => $status
                ]);
            }

            /*Pictures*/
            $deleted_imgs = File::select()->where('maintenance_n_id', $mainID)->where('status', 'deleted');
            $deleted_imgs->delete();

            $new_imgs = File::select()->where('maintenance_n_id', $mainID)->where('status', 'new');
            $new_imgs->update([
                'status' => 'verified'
            ]);

            /*Start integraction FFA*/

            if ($exist) {
                $this->customReportSendEmail($mainID);
            }

            /*End integration*/
        }

        echo json_encode(
            [
                'status' => 'success',
                'msg' => 'Updated Maintenance'
            ]
        );
    }

    public function getCreationMaintenance(Request $request)
    {
        $jobid = $request['jobid'];
        $liftid = $request['liftid'];
        $year = $request['year'];
        $month = $request['month'];
        $month_key = $month;
        $job = Job::select()->where('id', $jobid)->get()->first();
        $lift = Lift::select('lift_type', 'id', 'lift_name')->where('id', $liftid)->get()->first();

        $yearmonth = $year . ($month < 10 ? '0' . $month : $month);
        $completed_tasks = [];
        /**get existing maintenances */
        $exists = MaintenanceN::select()->where('job_id', $jobid)->where('lift_id', $liftid)->where('yearmonth', $yearmonth)->get();
        foreach ($exists as $one_exist) {
            $task_ids = $one_exist->task_ids;
            $tp_tasks = json_decode($one_exist->task_ids)->{$this->getMonthKey($month_key)};
            foreach ($tp_tasks as $one) {
                $completed_tasks[] = $one;
            }
        }
        if ($lift->lift_type == 'L') {
            $tasks_monthly  = LiftTask::select()->where('month' . $month_key, 1)->get();
        } else {
            $tasks_monthly  = ESTask::select()->where('month' . $month_key, 1)->get();
        }

        $tasks = [];
        foreach ($tasks_monthly as $one_task) {
            if (!in_array($one_task->task_id, $completed_tasks)) {
                $tp = [];
                $tp['task_id'] = $one_task->task_id;
                $tp['task_name'] = $one_task->task_name;
                $tasks[] = $tp;
            }
        }
        $month_label = $this->getMonthLabel($month_key);
        echo json_encode(
            [
                'status' => 'success',
                'msg' => 'Updated Maintenance',
                'job' => $job,
                'lift' => $lift,
                'tasks' => $tasks,
                'monthLabel' => $month_label,
                'completed' => $completed_tasks
            ]
        );
    }

    public function postCreateMaintenance(Request $request)
    {
        $tech = $request['user'];
        $job_id = $request['job_id'];
        $lift_id = $request['lift_id'];
        $year = $request['year'];
        $month = $request['month'];
        $date  = date('Y-m-d', strtotime(substr($request['date'], 0, 10)));
        $ids = explode(',', $request['ids']);
        $pos_lat = $request['pos_lat'];
        $pos_lng = $request['pos_lng'];
        $task_ids = [];
        foreach ($ids as $id) {
            $task_ids[$this->getMonthKey($month)][] = $id;
        }
        $newMain = MaintenanceN::create(
            [
                'job_id' => $job_id,
                'maintenance_date' => $date,
                'technician_id' => $tech,
                'lift_id' => $lift_id,
                'maintenance_note' => '',
                'completed_id' => 1,
                'maintenance_toa' => date('Y-m-d H:i'),
                'yearmonth' => $year . ($month < 10 ? '0' . $month : $month),
                'task_ids' => json_encode($task_ids),
                'start_pos' => json_encode(['lat' => $pos_lat, 'lng' => $pos_lng]),
            ]
        );

        echo json_encode(
            ['status' => 'success', 'msg' => 'Get Maintenance detail', 'maintenance' => $newMain]
        );
    }

    public function getJobsList(Request $request)
    {
        $keyword = $request['keyword'];
        $tech_id = $request['tech_id'];

        //created callouts , maintenaces
        $created_callouts = Calloutn::select('job_id')->where('technician_id', $tech_id)->get();
        $created_maintenances = MaintenanceN::select('job_id')->where('technician_id', $tech_id)->get();
        $exist_callout_arr = [];

        $exist_main_arr = [];
        foreach ($created_callouts as $one) {
            $exist_callout_arr[] = $one->job_id;
        }
        foreach ($created_maintenances as $one) {
            $exist_main_arr[] = $one->job_id;
        }

        $list = Job::select()->where('job_name', 'like', '%' . $keyword . '%')->where('status_id', 1)->orWhere('job_address', '%' . $keyword . '%')->orWhere('job_address_number', '%' . $keyword . '%')
            //->whereNotIn('id',$exist_main_arr)
            ->get();

        echo json_encode(['status' => 'success', 'msg' => 'Get Job list', 'list' => $list]);
    }

    public function getJobDetail(Request $request)
    {
        $jobid = $request['jobid'];
        $job = Job::select()->where('id', $jobid)->get()->first();
        $lifts = Lift::select()->where('job_id', $jobid)->get();
        $faults = Fault::all();

        echo json_encode(['status' => 'success', 'msg' => 'Get Maintenance detail', 'job' => $job, 'lifts' => $lifts, 'faults' => $faults]);
    }

    public function getJobMoreDetail(Request $request)
    {
        $jobid = $request['jobid'];
        $job = Job::select(
            'jobs.*',
            'agents.agent_name as agent_name',
            '_contract.contract_name as contract_name',
            '_frequency.frequency_name as frequency_name',
            'rounds.round_name as round_name'
        )
            ->leftjoin('agents', 'agents.id', '=', 'jobs.agent_id')
            ->leftjoin('_contract', '_contract.id', '=', 'jobs.contract_id')
            ->leftjoin('_frequency', '_frequency.id', '=', 'jobs.frequency_id')
            ->leftjoin('rounds', 'rounds.id', '=', 'jobs.round_id')
            ->where('jobs.id', $jobid)->get()->first();

        echo json_encode(['status' => 'success', 'msg' => 'Get Job detail', 'job' => $job]);
    }

    public function getMaintenanceTasks(Request $request)
    {
        $job_id = $request['job_id'];
        $lift_id = $request['lift_id'];
        $yearmonth = explode('-', $request['month'])[0] . explode('-', $request['month'])[1];
        $lift = Lift::select()->where('id', $lift_id)->get()->first();
        $completed_tasks = [];
        $month_key = (int)explode('-', $request['month'])[1];

        $exists = MaintenanceN::select()
            ->where('job_id', $job_id)
            ->where('lift_id', $lift_id)
            ->where('yearmonth', $yearmonth)
            ->get();
        foreach ($exists as $one_exist) {
            $task_ids = $one_exist->task_ids;
            $tp_tasks = json_decode($one_exist->task_ids)->{$this->getMonthKey($month_key)};
            foreach ($tp_tasks as $one) {
                $completed_tasks[] = $one;
            }
        }
        if ($lift->lift_type == 'L') {
            $tasks_monthly  = LiftTask::select()->where('month' . $month_key, 1)->get();
        } else {
            $tasks_monthly  = ESTask::select()->where('month' . $month_key, 1)->get();
        }

        $tasks = [];
        foreach ($tasks_monthly as $one_task) {
            if (!in_array($one_task->task_id, $completed_tasks)) {
                $tp = [];
                $tp['task_id'] = $one_task->task_id;
                $tp['task_name'] = $one_task->task_name;
                $tasks[] = $tp;
            }
        }

        echo json_encode(['status' => 'success', 'msg' => 'Get Maintenance detail', 'tasks' => $tasks]);
    }

    public function postCreateJobMaintenanceTasks(Request $request)
    {
        $tech = $request['user'];
        $job_id = $request['job_id'];
        $lift_id = $request['lift_id'];
        $year = explode('-', $request['month'])[0];
        $month = (int)explode('-', $request['month'])[1];
        $date  = date('Y-m-d', strtotime(substr($request['month'], 0, 10)));
        $ids = explode(',', $request['ids']);
        $pos_lat = $request['pos_lat'];
        $pos_lng = $request['pos_lng'];

        $task_ids = [];
        foreach ($ids as $id) {
            $task_ids[$this->getMonthKey($month)][] = $id;
        }
        $newMain = MaintenanceN::create(
            [
                'job_id' => $job_id,
                'maintenance_date' => $date,
                'technician_id' => $tech,
                'lift_id' => $lift_id,
                'maintenance_note' => '',
                'completed_id' => 1,
                'maintenance_toa' => date('Y-m-d H:i'),
                'yearmonth' => $year . ($month < 10 ? '0' . $month : $month),
                'task_ids' => json_encode($task_ids),
                'start_pos' => json_encode(['lat' => $pos_lat, 'lng' => $pos_lng]),
            ]
        );

        echo json_encode(
            ['status' => 'success', 'msg' => 'Get Maintenance detail', 'maintenance' => $newMain]
        );
    }
    public function postCreateJobCallout(Request $request)
    {
        $jobid = $request['jobid'];
        $selected_lifts = $request['selected_lifts'];
        $timeofcall = $request['timeofcall'];
        $callreport = $request['callreport'];
        $callstatus = $request['callstatus'];
        $prioritystatus = $request['prioritystatus'];
        $contact = $request['contact'];
        $floor = $request['floor'];
        $fault = $request['fault'];
        $description = $request['description'];
        $orderno = $request['orderno'];
        $tech = $request['user'];
        $pos_lat = $request['pos_lat'];
        $pos_lng = $request['pos_lng'];

        $timeofcall = str_replace('T', ' ', $timeofcall);
        $callout = Calloutn::create([
            'job_id' => $jobid,
            'technician_id' => $tech,
            'callout_status_id' => $callstatus,
            'callout_time' => date('Y-m-d H:i:s', strtotime(substr($timeofcall, 0, 19))),
            'floor_no' => $floor,
            'fault_id' => $fault,
            'priority_id' => $prioritystatus,
            'callout_description' => $description,
            'order_number' => $orderno,
            'contact_details' => $contact,
            'reported_customer' => $callreport,
            //'time_of_arrival'=>date('Y-m-d H:i:s')
        ]);

        $callout->lifts()->sync(explode(',', $selected_lifts), false);


        echo json_encode(
            ['status' => 'success', 'msg' => 'Get Maintenance detail', 'callout' => $callout]
        );
    }

    public function calloutSendEmail(Request $request)
    {
        $path = storage_path() . '/pdf/callout/';
        $calloutid = request('id');

        $callout_report = Calloutreport::select()->where('calloutn_id', $calloutid)->get()->first();

        if ($callout_report && $callout_report->status == 'sent' || $callout_report->status == 'both') {
            echo json_encode(
                ['status' => 'failure', 'msg' => 'Already exist report']
            );
        } else {
            $callout = Calloutn::select()->where('id', $calloutid)->get()->first();
            $filename = str_replace(':', ' ', (string)$callout->callout_time);
            $logo =  storage_path() . '/logo.png';

            //generate pdf file
            $pdf = PDF::loadView('callouts.printCallout', compact('callout', 'logo'));
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
                    $technician_fault = $tech_fault->technician_fault_name;
                    $correction_name = $correction->correction_name;
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
                        <p>Thankyou for your continued patronage.</p>
                        <p>$link</p>
                        <p>United Lift Services</p>               
                    ";





                    $from = "call@unitedlifts.com.au";
                    $domain  = "unitedlifts.com.au";
                    Mail::to($email)->send(new CalloutMail($from, $domain, $subject, $message, $filename));


                    Calloutreport::create([
                        'calloutn_id' => $callout->id,
                        'status' => 'sent'
                    ]);

                    echo json_encode(
                        ['status' => 'success', 'msg' => 'Created report']
                    );
                }
            }
        }
    }
    public function calloutSendPrint(Request $request)
    {
        $printerId = 'c93cc4db-d76e-1f12-3364-86dc9d640884';
        $calloutid = request('id');


        $report = Calloutreport::select()->where('calloutn_id', $calloutid)->get()->first();

        if ($report) {
            if ($report->status == 'print' || $report->status == 'both') {
                echo json_encode(
                    ['status' => 'failure', 'msg' => 'Already exist print report']
                );
            } else {
                $callout = Calloutn::select()->where('id', $calloutid)->get()->first();
                $path = storage_path() . '/pdf/callout/';
                $filename = str_replace(':', ' ', (string)$callout->callout_time);

                GoogleCloudPrint::asPdf()
                    ->file($path . $filename . '.pdf')
                    ->printer($printerId)
                    ->send();

                $report->status = 'both';
                $report->save();


                echo json_encode(
                    ['status' => 'success', 'msg' => 'Created report']
                );
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

            echo json_encode(
                ['status' => 'success', 'msg' => 'Created report']
            );
        }
    }

    public function customReportSendEmail($maintenance_id)
    {
        $path = storage_path() . '/pdf/maintenance/';

        try {

            /*Get information*/
            $maintenance = MaintenanceN::select()
                ->join('jobs', 'jobs.id', '=', 'job_id')
                ->where('maintenancenew.id', '=', $maintenance_id)
                ->get()
                ->first();

            $month_key = (int)substr($maintenance->yearmonth, 4, 2);

            $arrayTasks = json_decode($maintenance->task_ids);
            $tasks = [];

            if (!is_array($arrayTasks) > 0) {
                $task_ids = $arrayTasks->{$this->getMonthKey($month_key)};
                $tasks = $this->getTasksById($task_ids, $maintenance->lift_id);
            }

            $month_label = $this->getMonthLabel($month_key);
            $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();

            $sopa_tasks = DB::table('tasks_sopa')
                ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
                ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
                ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
                ->where('tasks_sopa.type', '=', $lift->lift_type)
                ->where('maintenancenew.id', '=', $maintenance->id)
                ->orderBy('tasks_sopa.name', 'asc')
                ->get();

            $recipients = array();
            $files = array();

            $docketFile = $path . 'Docket maintenance - ' . $maintenance_id . '.pdf';
            $complianceFile = $path . 'Compliance Certification - ' . $maintenance_id . '.pdf';
            $scheduleFile = $path . 'Scheduled Report Log - ' . $maintenance_id . '.pdf';
            $checklistFile = $path . 'Inspection and Test Plan - Checklist - ' . $maintenance_id . '.pdf';

            if ($maintenance->job_group == 'Facilities First') {
                $checklist = DB::table('checklist_maintenance')
                    ->select(['checklist_activities.id', 'checklist_activities.name', 'checklist_maintenance.value'])
                    ->where('maintenancenew.id', '=', $maintenance_id)
                    ->leftJoin('maintenancenew', 'maintenancenew.id', '=', 'checklist_maintenance.maintenance_id')
                    ->join('checklist_activities', 'checklist_activities.id', '=', 'checklist_maintenance.activity_id')
                    ->orderBy('checklist_activities.id', 'asc')
                    ->get();


                $settings_email = DB::table('settings')
                    ->select(['value'])
                    ->where(function ($query) {
                        $query->where('key', '=', 'email_ffa_customer')
                            ->orWhere('key', '=', 'email_ffa_office');
                    })
                    ->get();


                foreach ($settings_email as $setting) {
                    array_push($recipients, $setting->value);
                }

                /*Save PDF's files*/
                $complianceReport = PDF::loadView('reportnew.custom-reports.complianceGenerate', compact('maintenance'))->setPaper('a4', 'portrait');
                $complianceReport->save($complianceFile);
                array_push($files, $complianceFile);

                $scheduleReport = PDF::loadView('reportnew.custom-reports.maintenanceRecordLogGenerate', compact('maintenance'))->setPaper('a4', 'portrait');
                $scheduleReport->save($scheduleFile);
                array_push($files, $scheduleFile);

                $checklistReport = PDF::loadView('reportnew.custom-reports.checklistGenerate', compact('maintenance', 'checklist'))->setPaper('a4', 'landscape');
                $checklistReport->save($checklistFile);
                array_push($files, $checklistFile);

                $docketReport = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'month_label', 'tasks', 'lift', 'sopa_tasks'))->setPaper('a4', 'portrait');;
                $docketReport->save($docketFile);
                array_push($files, $docketFile);
            } else {
                array_push($recipients, $maintenance->job_email);
            }

            /*Send PDF's files trought email*/
            if (count($recipients) > 0) {
                $from = "call@unitedlifts.com.au";
                $domain  = "unitedlifts.com.au";
                $subject = "ULS Service - Maintenance finished";
                $message = "Hello, <br/><br/> Our technical team have finished the maintenance " . $maintenance_id . " in " . $maintenance->job_address_number . "," . $maintenance->job_address . "," . $maintenance->job_suburb . " (" . $maintenance->job_name . ")<br/><br/> Thanks! <br/><br/> United Lift Services";
                Mail::to($recipients)->send(new MaintenanceMail($from, $domain, $subject, $message, $files));
            }

            /*Delete files*/
            if (File::exists($complianceFile)) {
                \Illuminate\Support\Facades\File::delete($complianceFile);
            }
            if (File::exists($scheduleFile)) {
                \Illuminate\Support\Facades\File::delete($scheduleFile);
            }
            if (File::exists($checklistFile)) {
                \Illuminate\Support\Facades\File::delete($checklistFile);
            }
            if (File::exists($docketFile)) {
                \Illuminate\Support\Facades\File::delete($docketFile);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function maintenanceSendEmail(Request $request)
    {
        $path = storage_path() . '/pdf/maintenance/';
        $mainid = $request['id'];

        $main_report = Maintenancereport::select()->where('main_id', $mainid)->get()->first();

        if ($main_report && ($main_report->status == 'sent' || $main_report->status == 'both')) {
            echo json_encode(
                ['status' => 'failure', 'msg' => 'Already exist report']
            );
        } else {
            $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
            $filename = str_replace(':', ' ', (string)$main->maintenance_date);
            $month_key = (int)substr($main->yearmonth, 4, 2);

            $arrayTasks = json_decode($main->task_ids);
            $tasks = [];

            if (!is_array($arrayTasks)) {
                $task_ids = $arrayTasks->{$this->getMonthKey($month_key)};
                $tasks = $this->getTasksById($task_ids, $main->lift_id);
            }

            $month_label = $this->getMonthLabel($month_key);
            $lift = Lift::select()->where('id', $main->lift_id)->get()->first();
            $maintenance = $main;
            $sopa_tasks = DB::table('tasks_sopa')
                ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
                ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
                ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
                ->where('tasks_sopa.type', '=', $lift->lift_type)
                ->where('maintenancenew.id', '=', $maintenance->id)
                ->orderBy('tasks_sopa.name', 'asc')
                ->get();
            $pdf = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'month_label', 'tasks', 'lift', 'sopa_tasks'));
            $pdf->save($path . $filename . '.pdf');

            $job = Job::select()->where('id', $main->job_id)->get()->first();
            $technician = Technician::select()->where('id', $main->technician_id)->get()->first();

            $address = $job->job_address_number . " " . $job->job_address;
            $subject = "United Lifts Maintenance Report";

            $toc = date("d-m-Y G:i:s", strtotime($main->maintenance_date));
            $toa = date("d-m-Y G:i:s", strtotime($main->maintenance_toa));
            $tod = date("d-m-Y G:i:s", strtotime($main->maintenance_tod));
            $order_number = $main->order_no;
            $lift_names = Lift::select()->where('id', $main->lift_id)->get()->first()->lift_name;

            $user_email = $technician->technician_email;
            $email = explode(';', $job->job_email);
            if ($order_number == "") {
                $order_number = "N/A";
            }

            $myID = $main->docket_no;
            if ($myID == "") {
                $myID = "N/A";
            }
            $message = "
                
                <p>This notification is to advise completion of your Maintenance (Docket Number: $myID, Order Number: $order_number) to Unit('s)<br>&nbsp;<br>
                <b>$lift_names</b> at <b>$address</b> on <b>$toc</b>.</p>
                
                Our technician departed at <b>$tod</b>.</p> .
                <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                <p>Thankyou for your continued patronage.</p>
                <p>United Lift Services</p>               
            ";

            $from = "call@unitedlifts.com.au";
            $domain  = "unitedlifts.com.au";
            Mail::to($email)->send(new MaintenanceMail($from, $domain, $subject, $message, $filename));

            Maintenancereport::create([
                'main_id' => $main->id,
                'status' => 'sent'
            ]);

            echo json_encode(
                ['status' => 'success', 'msg' => 'Success. Sent email successfully']
            );
        }
    }

    public function maintenanceSendPrint(Request $request)
    {
        $printerId = 'c93cc4db-d76e-1f12-3364-86dc9d640884';
        $mainid = $request['id'];

        $report = Maintenancereport::select()->where('main_id', $mainid)->get()->first();

        if ($report) {
            if ($report->status == 'print' || $report->status == 'both') {
                echo json_encode(
                    ['status' => 'failure', 'msg' => 'Already exist print report']
                );
            } else {
                $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
                $path = storage_path() . '/pdf/maintenance/';
                $filename = str_replace(':', ' ', (string)$main->maintenance_date);

                GoogleCloudPrint::asPdf()
                    ->file($path . $filename . '.pdf')
                    ->printer($printerId)
                    ->send();

                $report->status = 'both';
                $report->save();

                echo json_encode(
                    ['status' => 'success', 'msg' => 'Print success']
                );
            }
        } else {
            $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
            $maintenance = $main;
            $path = storage_path() . '/pdf/maintenance/';
            $filename = str_replace(':', ' ', (string)$main->maintenance_date);
            $logo =  storage_path() . '/logo.png';

            $lift = Lift::select()->where('id', $main->lift_id)->get()->first();
            //generate pdf file
            $pdf = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'logo', 'lift'));
            $pdf->save($path . $filename . '.pdf');

            GoogleCloudPrint::asPdf()
                ->file($path . $filename . '.pdf')
                ->printer($printerId)
                ->send();

            Maintenancereport::create([
                'main_id' => $main->id,
                'status' => 'print'
            ]);

            echo json_encode(
                ['status' => 'success', 'msg' => 'Print success']
            );
        }
    }

    public function calloutUPloadImage(Request $request)
    {
        $id = $request['id'];
        $image = $request->file('photo');
        $folder = $request['folder'];

        if ($image && $folder) {

            //upload image to file
            $imageName = basename($_FILES['photo']['name']);
            $destination_path = public_path($folder . '/');
            $target_path = $destination_path . $imageName;
            move_uploaded_file($image, $target_path);

            //updated Database 
            $file = File::create([
                'calloutn_id' => $folder == 'callouts' ? $id : null,
                'maintenance_n_id' => $folder != 'callouts' ? $id : null,
                'title' => $imageName,
                'path' => '/' . $folder . '/' . $imageName,
                'status' => 'new'
            ]);

            echo json_encode(['status' => 'success', 'result' => $file->id]);
        } else {
            echo $id;
        }
    }

    public function deleteCalloutImage(Request $request)
    {
        $file = File::select()->where('id', $request['fileid'])->get()->first();
        if ($file) {
            $file->status = 'deleted';
            $file->save();
            echo $file->id;
        } else {
            echo -1;
        }
    }

    public function getChecklistActivities(Request $request)
    {
        try {
            $maintenance_id = $request['maintenance_id'];

            $activities = ChecklistActivities::select(
                'checklist_categories.name as category_name',
                'checklist_activities.id as id',
                'checklist_activities.name as activity_name',
                'checklist_maintenance.value as value'
            )
                ->join('checklist_categories', 'checklist_categories.id', '=', 'checklist_activities.category_id')
                ->leftjoin('checklist_maintenance', function ($leftJoin) use ($maintenance_id) {
                    $leftJoin->on('checklist_activities.id', '=', 'checklist_maintenance.activity_id')
                        ->where('checklist_maintenance.maintenance_id', '=', $maintenance_id);
                })
                ->get();

            echo json_encode(['status' => 'success', 'result' => $activities]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function saveChecklistActivities(Request $request)
    {
        try {
            $activity = ChecklistMaintenance::select()
                ->where('activity_id', $request['activity_id'])
                ->where('maintenance_id', $request['maintenance_id'])
                ->where('user_id', $request['user_id'])
                ->get()->first();

            if ($activity == null) {
                $activity = ChecklistMaintenance::create(
                    [
                        'activity_id' => $request['activity_id'],
                        'maintenance_id' => $request['maintenance_id'],
                        'user_id' => $request['user_id'],
                        'value' => $request['value'] == 'true' ? 1 : 0
                    ]
                );
            } else {
                $activity->value = $request['value'] == 'true' ? 1 : 0;
                $activity->save();
            }

            echo json_encode(
                ['status' => 'success', 'msg' => 'Get Maintenance detail', 'result' => $activity]
            );
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function getSOPATasks(Request $request)
    {
        try {
            $liftType = $request['type'];

            $sopa_tasks = DB::table('tasks_sopa')
                ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'tasks_sopa.type as task_type'])
                ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
                ->where('tasks_sopa.type', '=', $liftType)
                ->orderBy('tasks_sopa.name', 'asc')
                ->get();

            echo json_encode(['status' => 'success', 'result' => $sopa_tasks]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function saveSOPATasks(Request $request)
    {
        try {

            $module =  new MaintenanceController();

            if (isset($module)) {
                $request['isFromMobile'] = true;
                $result = $module->sopaTasks($request);
            }

            if (isset($result)) {
                echo json_encode(['status' => 'success', 'result' => 'true']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }
}
