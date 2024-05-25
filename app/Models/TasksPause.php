<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksPause extends Model
{
    use HasFactory;

    protected $fillable = [
        'timesheet_id',
        'start_time',
        'end_time',
        'type',
        'note',
        'project_name',
    ];

    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }
}