<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = [
        'type',
        'start_date',
        'end_date',
        'description',
        'file',
        'status',
        'employee_id',
        'company_name',
    ];

    // Define the relationship with the User model
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
