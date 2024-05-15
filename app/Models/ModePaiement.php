<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    protected $fillable = ['mode', 'description'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
