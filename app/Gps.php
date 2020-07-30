<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gps extends Model
{
    protected $table ='_gps_pos';
    protected $guarded = ['id'];
}