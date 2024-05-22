<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    protected $fillable = [
        'user_id', 'feuille_name', 'project_name', 'day_of_week', 'start_time', 'end_time', 'total_regular_time', 'additional_hours', 'comment', 'is_am', 'is_am0'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}