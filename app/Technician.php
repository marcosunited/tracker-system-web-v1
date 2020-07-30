<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $table ='technicians';

    protected $guarded = ['id'];

    public function rounds()
    {   
        return $this->belongsTo(Round::class,'round_id');
    }

    public function callouts()
    {
        return $this->hasMany(Calloutn::class);
    }

    public function maintenances()
    {
        return $this->hasMany(MaintenanceN::class);
    }
}
