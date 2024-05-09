<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_order_deployment',
        'id_employee',
        'text',
        'budget_total',
        'images'
    ];
}
