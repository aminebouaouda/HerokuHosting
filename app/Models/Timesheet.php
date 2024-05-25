<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'sent',
        'start_time',
        'end_time',
        'addhours',
        'comment',
    ];

    public function tasksPauses()
    {
        return $this->hasMany(TasksPause::class, 'timesheet_id');
    }
}