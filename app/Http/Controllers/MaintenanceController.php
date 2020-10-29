<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaintenanceN;
use App\MaintenanceNWeek;
use App\Maintenance;
use App\SopaTasks;
use App\Maintenancereport;
use App\Job;
use App\Technician;
use App\Lift;
use App\LiftTask;
use App\ESTask;
use App\Round;
use App\Frequency;
use App\Agent;
use App\Contract;
use App\JobStatus;
use App\File;
use App\Note;
use App\MaintenanceComplete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use PDF;
use GoogleCloudPrint;
use DateTime;
use Exception;

use Illuminate\Support\Facades\Mail;
use App\Mail\MaintenanceMail;
use phpDocumentor\Reflection\Types\Boolean;

class MaintenanceController extends Controller
{
    public function pending()
    {
        $pendingmaintenances = MaintenanceN::select('maintenancenew.*', 'maintenance_reports.status as report_status')
            ->where('maintenancenew.completed_id', '1')
            ->leftjoin('maintenance_reports', 'maintenance_reports.main_id', '=', 'maintenancenew.id')
            ->orderby('maintenancenew.maintenance_date', 'desc')
            ->get();
        return view('maintenance.pendingMaintenance', compact('pendingmaintenances'));
    }

    public function finished()
    {
        $finishedmaintenances = MaintenanceN::select('maintenancenew.*', 'maintenance_reports.status as report_status')->where('maintenancenew.completed_id', '2')
            ->leftjoin('maintenance_reports', 'maintenance_reports.main_id', '=', 'maintenancenew.id')
            ->orderby('maintenance_date', 'desc')
            ->get();

        return view('maintenance.finishMaintenance', compact('finishedmaintenances'));
    }

    public function selecttasks(Request $request)
    {
        if ($request->lift_type == 'L') {
            $month1 = LiftTask::select()->where('month1', 1)->get();
            $month2 = LiftTask::select()->where('month2', 1)->get();
            $month3 = LiftTask::select()->where('month3', 1)->get();
            $month4 = LiftTask::select()->where('month4', 1)->get();
            $month5 = LiftTask::select()->where('month5', 1)->get();
            $month6 = LiftTask::select()->where('month6', 1)->get();
            $month7 = LiftTask::select()->where('month7', 1)->get();
            $month8 = LiftTask::select()->where('month8', 1)->get();
            $month9 = LiftTask::select()->where('month9', 1)->get();
            $month10 = LiftTask::select()->where('month10', 1)->get();
            $month11 = LiftTask::select()->where('month11', 1)->get();
            $month12 = LiftTask::select()->where('month12', 1)->get();
        } else {
            $month1 = ESTask::select()->where('month1', 1)->get();
            $month2 = ESTask::select()->where('month2', 1)->get();
            $month3 = ESTask::select()->where('month3', 1)->get();
            $month4 = ESTask::select()->where('month4', 1)->get();
            $month5 = ESTask::select()->where('month5', 1)->get();
            $month6 = ESTask::select()->where('month6', 1)->get();
            $month7 = ESTask::select()->where('month7', 1)->get();
            $month8 = ESTask::select()->where('month8', 1)->get();
            $month9 = ESTask::select()->where('month9', 1)->get();
            $month10 = ESTask::select()->where('month10', 1)->get();
            $month11 = ESTask::select()->where('month11', 1)->get();
            $month12 = ESTask::select()->where('month12', 1)->get();
        }

        echo json_encode([
            $month1, $month2, $month3, $month4, $month5, $month6, $month7, $month8, $month9, $month10, $month11, $month12
        ]);
    }

    public function create()
    {
        $jobs = Job::where('status_id', 1)->get();
        $technicians = Technician::all();
        $selectedTech = array();
        $sopa_tasks = DB::table('tasks_sopa')
            ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'tasks_sopa.type as task_type'])
            ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
            ->orderBy('tasks_sopa.type', 'asc')
            ->orderBy('tasks_sopa.name', 'asc')
            ->get();

        return view('maintenance.createMaintenance', compact('jobs', 'technicians', 'selectedTech', 'sopa_tasks'));
    }

    public function store(Request $request)
    {
        try {

            $maintenance = $request->input('request');
            $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
            $finalTask = [];

            if (isset($maintenance['active_month']) && isset($maintenance['tasks'])) {
                foreach ($maintenance['tasks'] as $task) {
                    if ($task['monthId'] == $maintenance['active_month']) {
                        $monthPrefix = $months[((int)$task['monthId']) - 1];
                        $finalTask[$monthPrefix][] = $task['id'];
                    }
                }
            }

            if (isset($maintenance['maintenance_date'])) {
                $maintenanceDate = DateTime::createFromFormat("Y-m-d", $maintenance['maintenance_date']);
            }

            $maintenance = MaintenanceN::create([
                'job_id' => $maintenance['job_id'],
                'technician_id' => $maintenance['technician_id'],
                'completed_id' => $maintenance['completed_id'],
                'lift_id' => $maintenance['lift_id'],
                'maintenance_date' => $maintenance['maintenance_date'],
                'task_ids' => json_encode($finalTask),
                'yearmonth' => ($maintenanceDate->format("Y") . $maintenanceDate->format("m"))
            ]);

            flash('Maintenance Successfully Created!')->success();
            echo json_encode(
                ['status' => 'success', 'msg' => 'Callout', 'maintenanceId' => $maintenance->id]
            );
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function edit(MaintenanceN $maintenance)
    {
        $jobs = Job::where('status_id', 1)->get();
        $selectedjob = $maintenance->jobs;
        $technicians = Technician::all();
        $lifts = $selectedjob->lifts;
        $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();
        $selecttasks[] = [];

        if ($maintenance->jobs->job_group != 'SOPA' && strtolower($maintenance->jobs->job_group) != 'sydney olympic park') {

            if ($lift->lift_type == 'L') {
                $selecttasks[] = LiftTask::select()->where('month1', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month2', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month3', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month4', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month5', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month6', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month7', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month8', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month9', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month10', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month11', 1)->get();
                $selecttasks[] = LiftTask::select()->where('month12', 1)->get();
            }
            if ($lift->lift_type == 'E') {
                $selecttasks[] = ESTask::select()->where('month1', 1)->get();
                $selecttasks[] = ESTask::select()->where('month2', 1)->get();
                $selecttasks[] = ESTask::select()->where('month3', 1)->get();
                $selecttasks[] = ESTask::select()->where('month4', 1)->get();
                $selecttasks[] = ESTask::select()->where('month5', 1)->get();
                $selecttasks[] = ESTask::select()->where('month6', 1)->get();
                $selecttasks[] = ESTask::select()->where('month7', 1)->get();
                $selecttasks[] = ESTask::select()->where('month8', 1)->get();
                $selecttasks[] = ESTask::select()->where('month9', 1)->get();
                $selecttasks[] = ESTask::select()->where('month10', 1)->get();
                $selecttasks[] = ESTask::select()->where('month11', 1)->get();
                $selecttasks[] = ESTask::select()->where('month12', 1)->get();
            }
        }

        $selected_task_month = (int)substr($maintenance->yearmonth, 4, 2);
        $months = ['January', 'Feburary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $keymonth = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

        $sopa_tasks = DB::table('tasks_sopa')
            ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
            ->leftJoin('tasks_sopa_maintenance', function ($leftJoin) use ($maintenance) {
                $leftJoin->on('tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
                    ->where('tasks_sopa_maintenance.maintenanceId', '=',  $maintenance->id);
            })
            ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
            ->where('tasks_sopa.type', '=', $lift->lift_type)
            ->orderBy('tasks_sopa.name', 'asc')
            ->get();

        return view('maintenance.editMaintenance', compact('jobs', 'technicians', 'lifts', 'maintenance', 'selecttasks', 'months', 'keymonth', 'selected_task_month', 'sopa_tasks'));
    }

    public function sopaTasks(Request $request)
    {
        try {
            if (isset($request['maintenance'])) {


                $finalRequest = isset($request['isFromMobile']) && $request['isFromMobile'] ? json_decode($request['maintenance'], true) : $request['maintenance'];

                for ($i = 0; $i < count($finalRequest['tasks']); $i++) {

                    $value = $finalRequest['tasks'][$i]['value'];
                    $id = $finalRequest['tasks'][$i]['id'];

                    $exists_task = SopaTasks::select()
                        ->where('taskId', '=', $id)
                        ->where('maintenanceId', '=', $finalRequest['id'])
                        ->get()
                        ->first();

                    if ($value === 'true' || $value === true) {
                        if (!isset($exists_task)) {
                            SopaTasks::create(
                                [
                                    'taskId' => $finalRequest['tasks'][$i]['id'],
                                    'maintenanceId' =>  $finalRequest['id']
                                ]
                            );
                        }
                    } else {
                        if (isset($exists_task)) {
                            $exists_task->delete();
                        }
                    }
                }

                echo json_encode(
                    ['status' => 'success', 'msg' => 'Get Maintenance detail', 'result' => 'OK']
                );
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, MaintenanceN $maintenance)
    {

        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
        if (isset($request['task_month1'])) {
            foreach ($request['task_month1'] as $one_task) {
                $task['jan'][] = $one_task;
            }
        }
        if (isset($request['task_month2'])) {
            foreach ($request['task_month2'] as $one_task) {
                $task['feb'][] = $one_task;
            }
        }
        if (isset($request['task_month3'])) {
            foreach ($request['task_month3'] as $one_task) {
                $task['mar'][] = $one_task;
            }
        }
        if (isset($request['task_month4'])) {
            foreach ($request['task_month4'] as $one_task) {
                $task['apr'][] = $one_task;
            }
        }
        if (isset($request['task_month5'])) {
            foreach ($request['task_month5'] as $one_task) {
                $task['may'][] = $one_task;
            }
        }
        if (isset($request['task_month6'])) {
            foreach ($request['task_month6'] as $one_task) {
                $task['jun'][] = $one_task;
            }
        }
        if (isset($request['task_month7'])) {
            foreach ($request['task_month7'] as $one_task) {
                $task['jul'][] = $one_task;
            }
        }
        if (isset($request['task_month8'])) {
            foreach ($request['task_month8'] as $one_task) {
                $task['aug'][] = $one_task;
            }
        }
        if (isset($request['task_month9'])) {
            foreach ($request['task_month9'] as $one_task) {
                $task['sep'][] = $one_task;
            }
        }
        if (isset($request['task_month10'])) {
            foreach ($request['task_month10'] as $one_task) {
                $task['oct'][] = $one_task;
            }
        }
        if (isset($request['task_month11'])) {
            foreach ($request['task_month11'] as $one_task) {
                $task['nov'][] = $one_task;
            }
        }
        if (isset($request['task_month12'])) {
            foreach ($request['task_month12'] as $one_task) {
                $task['dec'][] = $one_task;
            }
        }

        $maintenance->update([
            'technician_id' => request('technician_id'),
            'completed_id' => request('completed_id'),
            'maintenance_date' => request('maintenance_date'),
            'task_ids' => json_encode($task),
            'lift_id' => request('lift_id'),
            'maintenance_tod' => date('Y-m-d H:i:s'),
        ]);

        if (request('completed_id') == 2) {
            //completion table update
            $yearmonth = $maintenance->yearmonth;
            $month_key = (int)substr($yearmonth, 4, 2);
            $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();
            if ($lift->lift_type == 'L') {
                $tasks_monthly  = LiftTask::select()->where('month' . $month_key, 0)->get()->count();
            } else {
                $tasks_monthly  = ESTask::select()->where('month' . $month_key, 0)->get()->count();
            }

            $completed_tasks = count(json_decode($maintenance->task_ids)->{$this->getMonthKey($month_key)});
            $status = $tasks_monthly == $completed_tasks ? 'complete' : 'working';
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
                MaintenanceComplete::create([
                    'technician_id' => $maintenance->technician_id,
                    'job_id' => $maintenance->job_id,
                    'lift_id' => $maintenance->lift_id,
                    'yearmonth' => $yearmonth,
                    'month' => $month_key,
                    'completed_tasks' => $completed_tasks,
                    'status' => $status
                ]);
            }
        }

        flash('Maintenance Successfully Updated!')->success();
        return back();
    }

    public function getMonthTaskIDs($taskids, $key)
    {
        return $taskids->$key;
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

    public function techdetails(MaintenanceN $maintenance)
    {
        $tasks = $maintenance->task_ids;
        $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();
        $month_key = (int)substr($maintenance->yearmonth, 4, 2);
        $task_ids = json_decode($maintenance->task_ids)->{$this->getMonthKey($month_key)};
        $tasks = $this->getTasksById($task_ids, $maintenance->lift_id);
        $selected_task_month = $month_key;
        $month_label = $this->getMonthLabel($selected_task_month);


        $start_lat = $maintenance->start_pos != null || $maintenance->start_pos != '' ? json_decode($maintenance->start_pos)->lat : '';
        $start_lng = $maintenance->start_pos != null || $maintenance->start_pos != '' ? json_decode($maintenance->start_pos)->lng : '';
        $finish_lat = $maintenance->finish_pos != null || $maintenance->finish_pos != '' ? json_decode($maintenance->finish_pos)->lat : '';
        $finish_lng = $maintenance->finish_pos != null || $maintenance->finish_pos != '' ? json_decode($maintenance->finish_pos)->lng : '';


        return view('maintenance.showMaintenanceTechDetails', compact(
            'maintenance',
            'tasks',
            'selected_task_month',
            'month_label',
            'start_lat',
            'start_lng',
            'finish_lat',
            'finish_lng'
        ));
    }

    public function techupdate(Request $request, MaintenanceN $maintenance)
    {
        $maintenance->update([

            'maintenance_toa' => request('toa_date'),
            'maintenance_tod' => request('tod_date'),
            'maintenance_note' => request('maintenance_note'),
            'order_no' => request('order_no'),
            'docket_no' => request('docket_no'),
        ]);

        // $active_week = request('active_week');
        // $year_month_week = $maintenance->year_month . $active_week;  

        // MaintenanceNweek::create([

        //     'toa_date' => request('toa_date'),
        //     'tod_date' => request('tod_date'), 
        //     'year_month_week' => $year_month_week,
        //     'maintenance_id' => $maintenance->id,
        //     'task_ids' => implode("|",$request->task)

        // ]);

        flash('Maintenance Tech Details Successfully Updated!')->success();
        return back();
    }

    public function maintenancejob(MaintenanceN $maintenance)
    {
        $job = $maintenance->jobs;
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

        return view('maintenance.maintenanceJob', compact('maintenance', 'job', 'selectedRound', 'rounds', 'selectedFrequency', 'frequency', 'selectedAgent', 'agents', 'selectedContract', 'contract', 'status', 'selectedStatus'));
    }

    public function round(MaintenanceN $maintenance)
    {
        $round = $maintenance->jobs->rounds;
        return view('maintenance.roundtable', compact('maintenance', 'round'));
    }

    public function file(maintenancen $maintenance)
    {
        return view('maintenance.fileupload', compact('maintenance'));
    }

    public function uploadfile(maintenancen $maintenance, Request $request)
    {
        $file = $request->file('file');
        // $validator = Validator::make($request->all(), [
        //     'file' => 'max:2060', //2MB 
        // ]);

        if ($file) {
            $fileName = $file->getClientOriginalName();
            $file->move('maintenances', $fileName);
            $filePath = "/maintenances/$fileName";
            $maintenance->files()->create([
                'title' => $fileName,
                'path' => $filePath
            ]);
        }
        // flash('File Successfully Uploaded!')->success();
        // return back();
    }

    public function deletefile(maintenancen $maintenance, File $file)
    {
        $file->delete();
        unlink(public_path($file->path));
        flash('File Successfully Deleted!')->success();
        return back();
    }

    public function notes(maintenancen $maintenance)
    {
        $notes = $maintenance->notes;
        return view('maintenance.maintenanceNotes', compact('maintenance', 'notes'));
    }

    public function addnotes(maintenancen $maintenance, Request $request)
    {
        Note::create([
            'description' => request('description'),
            'user_id' => Auth::user()->id,
            'maintenance_n_id' => $maintenance->id,
        ]);

        flash('Notes Successfully Added!')->success();
        return back();
    }

    public function deletenote(maintenancen $maintenance, Note $note)
    {
        $note->delete();
        flash('Note Successfully Deleted!')->success();
        return back();
    }

    public function print($id)
    {
        $maintenance = MaintenanceN::select()->where('id', $id)->get()->first();

        $month_key = (int)substr($maintenance->yearmonth, 4, 2);
        $task_ids = json_decode($maintenance->task_ids)->{$this->getMonthKey($month_key)};
        $tasks = $this->getTasksById($task_ids, $maintenance->lift_id);
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

        return view('maintenance.printmaintenance', compact('maintenance', 'month_label', 'tasks', 'lift', 'sopa_tasks'));
    }

    public function pdf($id)
    {
        $main = MaintenanceN::select()->where('id', $id)->get()->first();
        $logo =  storage_path() . '/logo.png';
        $maintenancedate = $main->maintenance_date;
        $job = $main->jobs->job_name;
        $month_key = (int)substr($main->yearmonth, 4, 2);
        $task_ids = json_decode($main->task_ids)->{$this->getMonthKey($month_key)};
        $tasks = $this->getTasksById($task_ids, $main->lift_id);
        $month_label = $this->getMonthLabel($month_key);
        $lift = Lift::select()->where('id', $main->lift_id)->get()->first();
        $sopa_tasks = DB::table('tasks_sopa')
            ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
            ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
            ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
            ->where('tasks_sopa.type', '=', $lift->lift_type)
            ->orderBy('tasks_sopa.name', 'asc')
            ->get();
        $maintenance = $main;
        $pdf = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'month_label', 'tasks', 'logo', 'lift', 'sopa_tasks'));

        return $pdf->download($id . "-" . $job . "-" . $maintenancedate . ".pdf");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $maintenance = MaintenanceN::findorfail($request->maintenance_id);
            $yearmonth  = $maintenance->yearmonth;
            $task_ids = $maintenance->task_ids;

            if ($maintenance->completed_id == 2) {
                //Remove maintenace completion table relation
                $month_key = (int)substr($maintenance->yearmonth, 4, 2);
                $task_ids = json_decode($maintenance->task_ids)->{$this->getMonthKey($month_key)};
                $tasks = $this->getTasksById($task_ids, $maintenance->lift_id);
                $task_count = count($tasks);

                $exist = MaintenanceComplete::select()
                    ->where('technician_id', $maintenance->technician_id)
                    ->where('job_id', $maintenance->job_id)
                    ->where('lift_id', $maintenance->lift_id)
                    ->where('yearmonth', $maintenance->yearmonth)
                    ->get()->first();

                if ($exist) {
                    $completed_tasks = $exist->completed_tasks;
                    $completed_tasks = $completed_tasks - $task_count;
                    if ($completed_tasks == 0)
                        $exist->delete();
                    else {
                        $exist->completed_tasks = $completed_tasks;
                        $exist->save();
                    }
                }
            }

            $hastasks = SopaTasks::select()
                ->where('maintenanceId', '=', $request->maintenance_id);

            if (isset($hastasks)) {
                $hastasks->delete();
            }

            $maintenance->delete();
            flash('Maintenance Successfully Deleted!')->success();
        } catch (Exception $e) {
            flash('Error deleting maintenance')->error();
        }
        return back();
    }


    public function maintenanceSendEmail(Request $request)
    {
        $path = storage_path() . '/pdf/maintenance/';
        $mainid = $request['main_id'];
        $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
        $filename = str_replace(':', ' ', (string)$main->maintenance_date);
        $month_key = (int)substr($main->yearmonth, 4, 2);
        
        $arrayTasks = json_decode($main->task_ids);
        $tasks = [];

        if (!is_array($arrayTasks) > 0) {
            $task_ids = $arrayTasks->{$this->getMonthKey($month_key)};
            $tasks = $this->getTasksById($task_ids, $main->lift_id);
        }

        $month_label = $this->getMonthLabel($month_key);
        $logo =  storage_path() . '/logo.png';
        $maintenance = $main;
        $lift = Lift::select()->where('id', $main->lift_id)->get()->first();
        $sopa_tasks = DB::table('tasks_sopa')
            ->select(['tasks_sopa.id as task_id', 'tasks_sopa.name as task_name', 'maintenancenew.id as checked'])
            ->leftJoin('tasks_sopa_maintenance', 'tasks_sopa_maintenance.taskId', '=', 'tasks_sopa.id')
            ->leftJoin('maintenancenew', 'tasks_sopa_maintenance.maintenanceId', '=', 'maintenancenew.id')
            ->where('tasks_sopa.type', '=', $lift->lift_type)
            ->where('maintenancenew.id', '=', $maintenance->id)
            ->orderBy('tasks_sopa.name', 'asc')
            ->get();

        $pdf = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'month_label', 'tasks', 'logo', 'lift', 'sopa_tasks'));
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
             <b>$lift_names</b> at <b>$address</b>.
             <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
             <p>Thankyou for your continued patronage.</p>
             <p>United Lift Services</p>               
         ";

        $from = "call@unitedlifts.com.au";
        $domain  = "unitedlifts.com.au";

        if (count($email) > 0)
            Mail::to($email)->send(new MaintenanceMail($from, $domain, $subject, $message, $filename));

        $report = Maintenancereport::select()->where('main_id', $main->id)->get()->first();

        if ($report) {
            $report->status = 'both';
            $report->save();
        } else {
            Maintenancereport::create([
                'main_id' => $main->id,
                'status' => 'sent'
            ]);
        }


        return redirect('/maintenances/finishedmaintenances');
    }

    public function maintenancePrint(Request $request)
    {
        $printerId = 'c93cc4db-d76e-1f12-3364-86dc9d640884';
        $mainid = $request['main_id'];

        $report = Maintenancereport::select()->where('main_id', $mainid)->get()->first();

        if ($report) {
            if ($report->status == 'sent') {

                $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
                $path = storage_path() . '/pdf/maintenance/';
                $filename = str_replace(':', ' ', (string)$main->maintenance_date);

                GoogleCloudPrint::asPdf()
                    ->file($path . $filename . '.pdf')
                    ->printer($printerId)
                    ->send();

                $report->status = 'both';
                $report->save();
            }
        } else {

            $main = MaintenanceN::select()->where('id', $mainid)->get()->first();
            $maintenance = $main;
            $month_key = (int)substr($maintenance->yearmonth, 4, 2);
            $task_ids = json_decode($maintenance->task_ids)->{$this->getMonthKey($month_key)};
            $tasks = $this->getTasksById($task_ids, $maintenance->lift_id);
            $month_label = $this->getMonthLabel($month_key);
            $lift = Lift::select()->where('id', $maintenance->lift_id)->get()->first();
            $path = storage_path() . '/pdf/maintenance/';
            $filename = str_replace(':', ' ', (string)$main->maintenance_date);
            $logo =  storage_path() . '/logo.png';

            $lift = Lift::select()->where('id', $main->lift_id)->get()->first();
            //generate pdf file
            $pdf = PDF::loadView('maintenance.printmaintenance', compact('maintenance', 'logo', 'month_label', 'tasks', 'lift'));
            $pdf->save($path . $filename . '.pdf');

            GoogleCloudPrint::asPdf()
                ->file($path . $filename . '.pdf')
                ->printer($printerId)
                ->send();

            Maintenancereport::create([
                'main_id' => $main->id,
                'status' => 'print'
            ]);
        }
        return redirect('/maintenances/finishedmaintenances');
    }
}
