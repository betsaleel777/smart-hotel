<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    protected $fillable = ['libelle'];

    const RULES = ['libelle'  => 'required|max:20' ] ;
    const MESSAGES = ['libelle.required'  => 'Ce champs est requis','libelle.max' => 'maximum de caractère dépassé (20)' ] ;

    public function chambres(){
      return $this->hasMany(Chambre::class,'chambre') ;
    }
}
