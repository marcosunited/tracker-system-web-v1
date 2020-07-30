<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceNWeek extends Model
{
    protected $table ='maintenance_tasks_weekly';
    protected $guarded = ['id'];

    public function maintenance()
    {
        return $this->belongsTo(MaintenanceN::class,'maintenance_id');
    }
}
