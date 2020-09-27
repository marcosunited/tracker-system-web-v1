<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistMaintenance extends Model
{
    protected $table = 'checklist_maintenance';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function activities()
    {
        return $this->belongsTo(ChecklistActivities::class, 'activity_id');
    }

    public function maintenances()
    {
        return $this->belongsTo(MaintenanceN::class, 'maintenance_id');
    }

    public function technicians()
    {
        return $this->belongsTo(Technician::class, 'user_id');
    }
}
