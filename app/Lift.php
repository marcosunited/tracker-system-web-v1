<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lift extends Model
{
    protected $table ='lifts';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function callouts()
    {
        return $this->belongsToMany(Calloutn::class,'callout_lift','lift_id','calloutn_id');
    }

    public function getCalloutIdsAttribute()
    {
        return $this->callouts->pluck('id');
    }
}
