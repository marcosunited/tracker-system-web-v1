<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table ='_contract';

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
