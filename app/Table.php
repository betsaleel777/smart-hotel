<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['numero', 'nombre_max'];

    const RULES = [
        'numero' => 'required|unique:tables,numero',
        'nombre_max' => 'required|numeric',
    ];

    const MESSAGES = [
        'numero.required' => 'le numero est requis',
        'numero.unique' => 'Cette valeure de numéro est déjà utilisée',
        'nombre_max.required' => 'le nombre maximum de personne est requis',
        'nombre_max.numeric' => 'Cette valeure doit être numérique',
    ];

    public static function regles(int $id)
    {
        return [
            'numero' => 'required|unique:tables,numero,' . $id,
            'nombre_max' => 'required|numeric',
        ];
    }
}
