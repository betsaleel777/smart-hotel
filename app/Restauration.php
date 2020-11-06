<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restauration extends Model
{
    protected $fillable = ['quantite', 'sejour', 'passage', 'produit', 'etat', 'prix', 'departement'];

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

    public function sejourLinked()
    {
        return $this->belongsTo(AttributionSejour::class, 'sejour');
    }

    public function produitLinked()
    {
        return $this->belongsTo(Produit::class, 'produit');
    }

    public function passageLinked()
    {
        return $this->belongsTo(AttributionsPassage::class, 'passage');
    }

    public function setPay(): void
    {
        $this->attributes['etat'] = 'facturer';
    }

}
