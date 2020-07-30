<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CalloutTime extends Model
{
    protected $table ='callout_times';
    protected $guarded = ['id'];

}
