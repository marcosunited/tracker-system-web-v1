<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceN extends Model
{
    protected $table ='maintenancenew';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function techs()
    {
        return $this->belongsTo(Technician::class,'technician_id');
    }

    // public function lifts()
    // {
    //     return $this->belongsToMany(Lift::class,'maintenance_lift','maintenancen_id','lift_id');
    // }

    public function lifts()
    {
        return $this->belongsTo(Lift::class,'lift_id');
    }

    public function getTagIdsAttribute()
    {
        return $this->lifts->pluck('id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
