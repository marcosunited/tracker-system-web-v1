<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ESTask extends Model
{
    protected $table ='_escalator_tasks';
    protected $guarded = ['task_id'];//['task_id'];
}
