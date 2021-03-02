<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SopaTasks extends Model
{
    protected $table = 'tasks_sopa_maintenance';

    protected $guarded = ['id'];
    
    public $timestamps = false;

    public function maintenances()
    {
        return $this->belongsTo(MaintenanceN::class, 'maintenance_id');
    }
}
