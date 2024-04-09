<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'remark',
        'file',
        'is_accept',
        'date_demande',
        'id_employee',
    ];

    // Assuming 'file' attribute is a file path
    // You can define an accessor to generate a full URL for the file
    public function getFileUrlAttribute()
    {
        // Assuming the 'file' attribute stores the file path in public directory
        return asset('storage/' . $this->file);
    }

    // Define a relationship with the User model (assuming id_employee is the foreign key)
    public function employee()
    {
        return $this->belongsTo(User::class, 'id_employee');
    }
}
