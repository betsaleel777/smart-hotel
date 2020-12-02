<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $fillable = ['libelle'];
    const RULES = ['libelle' => 'required|max:100|unique:familles,libelle'];
    const MESSAGES = [
        'libelle.required' => 'le :attribute est requis',
        'libelle.unique' => 'Cette valeure du libellé est déjà utilisée',
        'libelle.max' => 'nombre maximale de caractère:100',
    ];

    public static function regles(int $id)
    {
        return ['libelle' => 'required|max:100|unique:familles,libelle,' . $id];

    }

    public function sous_familles()
    {
        return $this->hasMany(SousFamille::class, 'famille');
    }

}
