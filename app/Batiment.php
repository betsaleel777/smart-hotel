<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{

    protected $fillable = ['libelle'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    const RULES = ['libelle' => 'required|max:20|unique:batiments,libelle'];
    const MESSAGES = [
        'libelle.required' => 'Ce champs est requis',
        'libelle.unique' => 'Cette valeure du libellé est déjà utilisée',
        'libelle.max' => 'maximum de caractère dépassé (20)',
    ];

    public static function regles(int $id)
    {
        return ['libelle' => 'required|max:20|unique:batiments,libelle,' . $id];
    }

    public function chambres()
    {
        return $this->hasMany(Chambre::class, 'batiment');
    }

    public function attributions_passages()
    {
        return $this->hasMany(AttributionsPassage::class, 'batiment');
    }
}
