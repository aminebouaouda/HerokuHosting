<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_entry',
        'pause_exit',
        'pause_entry',
        'time_exit',
        'extra_hours',
        'date_pointage',
        'id_employee'
    ];
}
