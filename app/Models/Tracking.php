<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'pointage'; // Set the table name

    protected $fillable = [
        'employee_id',
        'project_id',
        'start_time',
        'end_time',
        'pause_start_time',
        'pause_end_time',
        'task_description',
        'total_worked_hours',
        'total_pause_hours',
        'status',
        'location',
        'remarks',
    ];

    // Define relationships with User and Project models
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
