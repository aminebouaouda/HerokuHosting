<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;

    protected $fillable = [
        'morning_entry',
        'morning_exit',
        'evening_entry',
        'evening_exit',
        'totale_hours',
        'extra_hours',
        'date_pointage',
        'is_absent_morning',
        'is_absent_evening',
        'id_pointeur',
        'id_employee'
    ];
}
