<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table ='agents';
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
