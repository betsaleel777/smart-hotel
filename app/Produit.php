<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['libelle','sous_famille','reference','seuil','image','prix'] ;
    const RULES = [
                   'libelle' => 'required|max:100' ,
                   'sous_famille' => 'required' ,
                   'seuil' => 'required|numeric' ,
                   'prix' => 'required|numeric' ,
                  ];

    const MESSAGES = [
                       'libelle.required' => 'le :attribute est requis' ,
                       'libelle.max' => 'Nombre maximal de caractère:100' ,
                       'sous_famille.required' => 'le choix de la sous famille est requis' ,
                       'seuil.required' => ' le :attribute est requis' ,
                       'seuil.numeric' => 'le seuil doit être un nombre' ,
                       'prix.required' => 'le :attribute est requis' ,
                       'prix.numeric' => 'le prix doit être un nombre' ,
                     ] ;
    public function immatriculer():void{
         $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
         $chiffres = '0123456789' ;
         $this->attributes['reference'] = substr(str_shuffle($lettres),0,6).\substr(\str_shuffle($chiffres),0,4) ;
    }
}
