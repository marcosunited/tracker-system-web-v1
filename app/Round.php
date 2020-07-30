<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $table ='rounds';

    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function techs()
    {   
        return $this->hasMany(Technician::class);
    }
}
