<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $fillable = ['libelle','statut','batiment','type'] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'chambre') ;
    }

    public function typeLinked(){
      return $this->belongsTo(Type::class,'type') ;
    }
}
