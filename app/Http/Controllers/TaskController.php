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

use App\EStask;
use App\LiftTask;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_lift()
    {
        $tasks = LiftTask::select()->orderBy('task_id','asc')->get();         
        $type = 'l';
        return view('tasks.allTasks',compact('tasks','type'));
    }  
    public function index_escalator()
    {
        $tasks = ESTask::select()->orderBy('task_id','asc')->get();         
        $type = 'e';
        return view('tasks.allTasks',compact('tasks','type'));
    }  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        return view('tasks.createTask');
    }
    public function store(Request $request)
    {
        $months = $request['task_months'];
        $tp_sm_rs = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($months as $tp) $tp_sm_rs[$tp-1] = 1;       
        if ($request['task_type']=='L') {
            LiftTask::create([
                'task_name'=>$request['task_name'],
                'month1'=> $tp_sm_rs[0],
                'month2'=> $tp_sm_rs[1],
                'month3'=> $tp_sm_rs[2],
                'month4'=> $tp_sm_rs[3],
                'month5'=> $tp_sm_rs[4],
                'month6'=> $tp_sm_rs[5],
                'month7'=> $tp_sm_rs[6],
                'month8'=> $tp_sm_rs[7],
                'month9'=> $tp_sm_rs[8],
                'month10'=> $tp_sm_rs[9],
                'month11'=> $tp_sm_rs[10],
                'month12'=> $tp_sm_rs[11]
            ]);
        } else {
            ESTask::create([
                'task_name'=>$request['task_name'],
                'month1'=> $tp_sm_rs[0],
                'month2'=> $tp_sm_rs[1],
                'month3'=> $tp_sm_rs[2],
                'month4'=> $tp_sm_rs[3],
                'month5'=> $tp_sm_rs[4],
                'month6'=> $tp_sm_rs[5],
                'month7'=> $tp_sm_rs[6],
                'month8'=> $tp_sm_rs[7],
                'month9'=> $tp_sm_rs[8],
                'month10'=> $tp_sm_rs[9],
                'month11'=> $tp_sm_rs[10],
                'month12'=> $tp_sm_rs[11]
            ]);
        }
        flash('Task Successfully Added!')->success();
        return back();
    }
    public function show($type,$id)
    {
        if ($type=='l')
            $task = LiftTask::select()->where('task_id',$id)->get()->first();
        else
            $task = ESTask::select()->where('task_id',$id)->get()->first();            
        return view('tasks.taskDetail',compact('task','type'));
    }
    public function update($type, $id, Request $request)
    {
       // dd($request);
        $months = $request['task_months'];
        $tp_sm_rs = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($months as $tp) $tp_sm_rs[$tp-1] = 1;
        if ($type == 'l')
            $tasks = LiftTask::select()->where('task_id',$id);
        else
            $tasks = ESTask::select()->where('task_id',$id);
        //dd($tasks);
        $tasks->update([
            'task_id' => $id,
            'task_name'=>$request['task_name'],           
            'month1'=> $tp_sm_rs[0],
            'month2'=> $tp_sm_rs[1],
            'month3'=> $tp_sm_rs[2],
            'month4'=> $tp_sm_rs[3],
            'month5'=> $tp_sm_rs[4],
            'month6'=> $tp_sm_rs[5],
            'month7'=> $tp_sm_rs[6],
            'month8'=> $tp_sm_rs[7],
            'month9'=> $tp_sm_rs[8],
            'month10'=> $tp_sm_rs[9],
            'month11'=> $tp_sm_rs[10],
            'month12'=> $tp_sm_rs[11]
        ]);
        flash('Task Successfully Updated!')->success();
        return back();
    }
   
}
