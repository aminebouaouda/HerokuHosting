<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = ['numero', 'employee_id', 'paiement_id', 'description', 'date_emission', 'date_echeance', 'montant', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}
