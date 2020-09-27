<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistCategories extends Model
{
    protected $table ='checklist_categories';

    protected $guarded = ['id'];

    public function activities()
    {
        return $this->hasMany(ChecklistActivities::class);
    }

}
