<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use App\Calloutn;
use App\Job;
use App\CalloutLift;
use App\Lift;
use Carbon;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $alarms;

    public function __construct() {
        $this->alarms = $this->showAsidePopup();

        View::share ( 'alarms', $this->alarms );
    }

    public function showAsidePopup() 
    {
        $week = [];
        $callouts_groupbyJob = Calloutn::select('job_id')->whereBetween('callout_time',[
            Carbon\Carbon::parse('last monday')->startOfDay(),
            Carbon\Carbon::parse('next sunday')->endOfDay(),
        ])->groupBy('job_id')->get();
        
        foreach ($callouts_groupbyJob as $group_one) {
            $callout_job = Calloutn::select('calloutsnew.*','jobs.job_name as job_name')
                        ->leftjoin('jobs','jobs.id','=','calloutsnew.job_id')->where('calloutsnew.job_id',$group_one->job_id)->get();
            //dd($callout_job);
            if (count($callout_job) >=2) {
                foreach ($callout_job as $c_job) {
                    $tp = [];
                    $tp['callout'] = $c_job;
                    $lifts = CalloutLift::select()->where('calloutn_id',$c_job->id)->get();
                    $tp_lift = [];
                    foreach ($lifts as $lift ) {
                        $lift = Lift::select()->where('id',$lift->lift_id)->get()->first();
                        $tp_lift[] = $lift;
                    }
                    $tp['lift'] = $tp_lift;                    

                    $week[] = $tp;
                }
            }
        }
     

       // dd($week);
        $month = [];
        $callouts_groupbyJob = Calloutn::select('job_id')->whereBetween('callout_time',[
            Carbon\Carbon::now()->startOfMonth(),
            Carbon\Carbon::now()->endOfMonth(),
        ])->groupBy('job_id')->get();


        $month = [];

        foreach ($callouts_groupbyJob as $group_one) {
            $callout_job = Calloutn::select('calloutsnew.*','jobs.job_name as job_name')
                        ->leftjoin('jobs','jobs.id','=','calloutsnew.job_id')->where('calloutsnew.job_id',$group_one->job_id)->get();
            if (count($callout_job) >=7) {
                foreach ($callout_job as $c_job) {
                    $tp = [];
                    $tp['callout'] = $c_job;
                    $lifts = CalloutLift::select()->where('calloutn_id',$c_job->id)->get();
                    $tp_lift = [];
                    foreach ($lifts as $lift ) {
                        $lift = Lift::select()->where('id',$lift->lift_id)->get()->first();
                        $tp_lift[] = $lift;
                    }
                    $tp['lift'] = $tp_lift;                    

                    $month[] = $tp;
                }
            }
        }      
           
        return ['week'=>$week,'month'=>$month,
                'start_week'=>Carbon\Carbon::parse('last monday')->startOfDay(),'end_week'=> Carbon\Carbon::parse('next sunday')->endOfDay(),
                'start_month'=>   Carbon\Carbon::now()->startOfMonth(), 'end_month'=>   Carbon\Carbon::now()->endOfMonth()
                ];

    }
}
