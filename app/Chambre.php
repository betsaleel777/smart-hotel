<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $fillable = ['libelle','statut','batiment','type'] ;

    const RULES = [
                   'libelle'  => 'required|max:50',
                   'batiment'  => 'required',
                   'type'  => 'required',
                  ] ;

    const MESSAGES = [
                      'libelle.required' => 'le libelle est requis',
                      'libelle.max' => 'nombre de caractères maximum (50)',
                      'batiment' => 'le choix du batiment',
                      'type' => 'le choix du type de batiment est requis',
                     ] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function typeLinked(){
      return $this->belongsTo(Type::class,'type') ;
    }

    public function passages(){
      return $this->hasMany(Passage::class,'chambre') ;
    }
}
