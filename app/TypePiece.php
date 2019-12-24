<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypePiece extends Model
{
    use SoftDeletes ;
    protected $fillable = ['libelle'] ;
    protected $dates = ['created_at','updated_at'] ;
    protected $table = 'types_pieces' ;
    const RULES = ['libelle' => 'required|max:50'] ;
    const MESSAGES = [
                       'libelle.required' => 'le libellé est réquis',
                       'libelle.max' => 'maximum caractère dépassé : 50',
                     ] ;
}
