<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechFault extends Model
{
    protected $table ='_technician_faults';
    protected $guarded = ['id'];
}
