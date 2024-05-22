<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['time_tracking_id', 'task_name', 'time'];

    public function timeTracking()
    {
        return $this->belongsTo(TimeTracking::class);
    }
}