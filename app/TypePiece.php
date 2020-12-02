<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypePiece extends Model
{
    protected $fillable = ['libelle'];
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'types_pieces';
    const RULES = ['libelle' => 'required|max:50|unique:types_pieces,libelle'];
    const MESSAGES = [
        'libelle.required' => 'le libellé est réquis',
        'libelle.unique' => 'Cette valeure du libellé est déjà utilisée',
        'libelle.max' => 'maximum caractère dépassé : 50',
    ];
    public static function regles(int $id): array
    {
        return ['libelle' => 'required|max:50|unique:types_pieces,libelle,' . $id];
    }
}
