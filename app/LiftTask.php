<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiftTask extends Model
{
    protected $table ='_lift_tasks';
    protected $guarded = ['task_id'];//['task_id'];
}
