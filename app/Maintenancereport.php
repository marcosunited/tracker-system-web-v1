<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Maintenancereport extends Model
{
    protected $table ='maintenance_reports';
    protected $guarded = ['id'];
}