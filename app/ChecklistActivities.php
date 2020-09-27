<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistActivities extends Model
{
    protected $table ='checklist_activities';

    protected $guarded = ['id'];

    public function categories()
    {   
        return $this->belongsTo(ChecklistCategories::class,'category_id');
    }
}
