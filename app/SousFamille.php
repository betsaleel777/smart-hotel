<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model
{
    protected $fillable = ['libelle', 'famille'];
    const RULES = [
        'libelle' => 'required|max:100|unique:sous_familles,libelle',
        'famille' => 'required|numeric',
    ];
    const MESSAGES = [
        'libelle.unique' => 'Cette valeure du libelle est déjà utilisée',
        'libelle.required' => 'le libelle de la sous catégorie est obligatoire',
        'libelle.max' => 'Ce libelle est trop long',
        'famille.required' => 'le choix de la famille est obligatoire',
        'famille.numeric' => 'doit être un nombre',
    ];

    public static function regles(int $id)
    {
        return [
            'libelle' => 'required|max:100|unique:sous_familles,libelle,' . $id,
            'famille' => 'required|numeric',
        ];
    }

    public function familleLinked()
    {
        return $this->belongsTo(Famille::class, 'famille');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'sous_famille');
    }

}
