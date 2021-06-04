<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Lift extends Model
{
    protected $table = 'lifts';
    protected $guarded = ['id'];
    protected $functions = [
        "2.2.11b" => "2.2.11b - Stairway Lifts",
        "2.2.11a" => "2.2.11a - Stage Lifts",
        "2.2.10" => "2.2.10 - Passenger Lifts",
        "2.2.12" => "2.2.12 -Service Lifts"
    ];


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
            if (
                strpos(strtolower($this->functions['2.2.11b']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.11b']), strtolower($this->function)) >= 0
            ) {
                return $this->functions['2.2.11b'];
            } else if (
                strpos(strtolower($this->functions['2.2.11a']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.11a']), strtolower($this->function)) >= 0
            ) {
                return $this->functions['2.2.11a'];
            } else if (
                strpos(strtolower($this->functions['2.2.10']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.10']), strtolower($this->function)) >= 0
            ) {
                return $this->functions['2.2.10'];
            } else if (
                strpos(strtolower($this->functions['2.2.12']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.12']), strtolower($this->function)) >= 0
            ) {
                return $this->functions['2.2.12'];
            }
        } catch (Exception $e) {
            return $this->functions['2.2.10'];
        }
    }

    public function get_code_function()
    {
        try {
            if (
                strpos(strtolower($this->functions['2.2.11b']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.11b']), strtolower($this->function)) >= 0
            ) {
                return '2.2.11b';
            } else if (
                strpos(strtolower($this->functions['2.2.11a']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.11a']), strtolower($this->function)) >= 0
            ) {
                return '2.2.11a';
            } else if (
                strpos(strtolower($this->functions['2.2.10']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.10']), strtolower($this->function)) >= 0
            ) {
                return '2.2.10';
            } else if (
                strpos(strtolower($this->functions['2.2.12']), strtolower($this->function)) != false &&
                strpos(strtolower($this->functions['2.2.12']), strtolower($this->function)) >= 0
            ) {
                return '2.2.12';
            }
        } catch (Exception $e) {
            return '2.2.10';
        }
    }
}
