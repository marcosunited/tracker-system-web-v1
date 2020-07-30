<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Callout extends Model
{
    protected $table ='callouts';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function lifts()
    {
        return $this->belongsToMany(Lift::class,'callout_lift');
    }
    public function techs()
    {
        return $this->belongsTo(Technician::class,'technician_id');
    }
    public function correction()
    {
        return $this->belongsTo(Correction::class,'correction_id');
    }
    public function faults()
    {
        return $this->belongsTo(Fault::class,'fault_id');
    }
    public function techfault()
    {
        return $this->belongsTo(TechFault::class,'technician_fault_id');
    }
}
