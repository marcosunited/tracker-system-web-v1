<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Lift extends Model
{
    protected $table = 'lifts';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function callouts()
    {
        return $this->belongsToMany(Calloutn::class, 'callout_lift', 'lift_id', 'calloutn_id');
    }

    public function getCalloutIdsAttribute()
    {
        return $this->callouts->pluck('id');
    }

    public function size_lift()
    {
        $abs_size = 'N/A';

        try {
            if ($this->capacity != '') {
                $abs_size = round(abs((int)$this->capacity / 75));
            }
        } catch (Exception $e) {
            return '';
        }
        return $abs_size;
    }

    public function get_function()
    {
        try {
            if (strpos(strtolower($this->function), "stairway") >= 0) {
                return '2.2.11b - Stairway Lifts';
            } else if (strpos(strtolower($this->function), "stage") >= 0) {
                return '2.2.11a - Stage Lifts';
            } else if (strpos(strtolower($this->function), "passenger") >= 0) {
                return '2.2.10 - Passenger Lifts';
            } else if (strpos(strtolower($this->function), "service") >= 0) {
                return '2.2.12 - Service Lifts';
            }
        } catch (Exception $e) {
            return '2.2.10 - Passenger Lifts';
        }
    }
}
