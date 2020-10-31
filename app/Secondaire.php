<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secondaire extends Model
{
    protected $fillable = ['quantite'];

    const RULES = [
        'quantite' => 'required|numeric',
        'departement' => 'required',
        'produit' => 'required',
    ];

    const MESSAGES = [
        'quantite.required' => 'la quantité est requise',
        'quantite.numeric' => 'la valeur de la quantité doit être un nombre',
        'produit.required' => 'le choix du produit est obligatoire',
        'departement.required' => 'le choix du département est obligatoire',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'user');
    }
}
