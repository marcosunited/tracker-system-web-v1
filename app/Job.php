<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table ='jobs';
    protected $guarded = ['id'];


    public function lifts()
    {
        return $this->hasMany(Lift::class);
    }

    public function callouts()
    {
        return $this->hasMany(Calloutn::class);
    }

    public function maintenances()
    {
        return $this->hasMany(MaintenanceN::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function rounds(){
        return $this->belongsTo(Round::class,'round_id');
    }

    public function agents(){
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function contract(){
        return $this->belongsTo(Contract::class,'contract_id');
    }

    public function status(){
        return $this->belongsTo(JobStatus::class,'status_id');
    }

    public function frequency()
    {
        return $this->belongsTo(Frequency::class,'frequency_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function addLift($lift)
    {
       $this->lifts()->create($lift);
    }
}
