<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table ='file';
    protected $guarded = ['id'];

    public function callouts()
    {
        return $this->belongsTo(Calloutn::class,'calloutn_id');
    }

    public function jobs()
    {
        return $this->belongsTo(Calloutn::class,'job_id');
    }
}
