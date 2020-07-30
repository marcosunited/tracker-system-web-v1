<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Calloutreport extends Model
{
    protected $table ='callout_reports';
    protected $guarded = ['id'];
}