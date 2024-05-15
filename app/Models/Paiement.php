<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['employee_id', 'mode_paiement_id', 'type_salaire', 'periode_paiement', 'remarques', 'statut', 'montant', 'date_paiement'];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function modePaiement()
    {
        return $this->belongsTo(ModePaiement::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
