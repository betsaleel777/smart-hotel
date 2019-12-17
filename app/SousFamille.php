<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model
{
    protected $fillable = ['libelle','famille'] ;
    protected $table = 'sous_familles' ;

    const RULES = ['libelle' => 'required|max:100','famille' => 'required' ] ;
    const MESSAGES = [
                      'libelle.required' => 'le :attribute est requis',
                      'libelle.max' => 'nombre maximal de caractère:100' ,
                      'famille.required' => 'la :attribute est requis',
                     ] ;

    public function familleLinked(){
      return $this->belongsTo(Famille::class,'famille') ;
    }
}
