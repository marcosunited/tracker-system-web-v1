<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table ='_frequency';

    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
