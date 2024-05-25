<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDeplacment extends Model
{
    use HasFactory;

    protected $fillable = [
        'localiastion',
        'titel',
        'buteDeplacment',
        'is_accepte',
        'id_charges',
        'localisation_verify',
        'fine_mission',
        'mession_verify',
        'budget_total',
        'id_employee',
        'debut',
        'arriver'
    ];
}
