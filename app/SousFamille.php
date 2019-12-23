<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model
{
  protected $fillable = ['libelle','famille'];
  const RULES = ['libelle' => 'required|max:100',
                 'famille' => 'required|numeric'] ;
  const MESSAGES = [
                     'libelle.required' => 'le libelle de la sous catégorie est obligatoire',
                     'libelle.max' => 'Ce libelle est trop long',
                     'famille.required' => 'le choix de la famille est obligatoire',
                     'famille.numeric' => 'doit être un nombre',
                   ] ;

  public function familleLinked(){
    return $this->belongsTo(Famille::class,'famille') ;
  }

  public function produits(){
    return $this->hasMany(Produit::class,'sous_famille') ;
  }

}
