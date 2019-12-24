<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use SoftDeletes ;
    protected $fillable = ['libelle','sous_famille','reference','seuil','image','prix'] ;
    const RULES = [
                   'libelle' => 'required|max:100' ,
                   'sous_famille' => 'required' ,
                   'seuil' => 'required|numeric' ,
                   'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                   'prix' => 'required|numeric' ,
                  ];

    const MESSAGES = [
                       'libelle.required' => 'le :attribute est requis' ,
                       'libelle.max' => 'Nombre maximal de caractère dépassé' ,
                       'sous_famille.required' => 'le choix de la sous famille est requis' ,
                       'seuil.required' => ' le :attribute est requis' ,
                       'seuil.numeric' => 'le seuil doit être un nombre' ,
                       'prix.required' => 'le :attribute est requis' ,
                       'prix.numeric' => 'le prix doit être un nombre' ,
                       'image.image' => 'Ce choix doit être une :attribute' ,
                       'image.mimes' => 'Les format supportés sont: jpeg,jpg,png' ,
                       'image.max' => 'taille maximum dépassée !!' ,
                     ] ;
    public function immatriculer():void{
         $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
         $chiffres = '0123456789' ;
         $this->attributes['reference'] = substr(str_shuffle($lettres),0,6).\substr(\str_shuffle($chiffres),0,4) ;
    }

    public function sous_familleLinked(){
      return $this->belongsTo(SousFamille::class,'sous_famille') ;
    }
}
