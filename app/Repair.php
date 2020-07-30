<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $table ='repairs';

    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function lifts()
    {
        return $this->belongsToMany(Lift::class,'repair_lift','repair_id','lift_id');
    }
    public function techs()
    {
        return $this->belongsTo(Technician::class,'technician_id');
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
