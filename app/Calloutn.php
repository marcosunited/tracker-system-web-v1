<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Calloutn extends Model
{
    protected $table ='calloutsnew';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function lifts()
    {
        return $this->belongsToMany(Lift::class,'callout_lift','calloutn_id','lift_id');
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
