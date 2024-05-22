<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentFeuille extends Model
{
    use HasFactory;

    protected $table = 'sent_feuille';

    protected $fillable = ['feuille_name', 'user_id', 'total_regular_time'];
}