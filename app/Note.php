<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table ='notes';
    protected $guarded = ['id'];

    public function callouts()
    {
        return $this->belongsTo(Calloutn::class,'calloutn_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // public function latest()
    // {
    //     return $this::orderBy('created_at', 'desc')->get();
    // }

    public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function repairs()
    {
        return $this->belongsTo(Repair::class,'repair_id');
    }
}

