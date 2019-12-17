<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $fillable = ['libelle'] ;
    const RULES = ['libelle' => 'required|max:100'] ;
    const MESSAGES = [
                      'libelle.required' => 'le :attribute est requis' ,
                      'libelle.max' => 'nombre maximale de caractère:100'
                     ] ;

    public function sous_familles(){
      return $this->hasMany(SousFamille::class,'famille') ;
    }

}
