<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destockage extends Model
{
    protected $fillable = ['user','attribution_passage','attribution_sejour','quantite','produit'] ;

    public function sejourLinked(){
      return $this->belongsTo(AttributionSejour::class,'attribution_sejour') ;
    }

    public function produitLinked(){
      return $this->belongsTo(Produit::class,'produit') ;
    }

    public function passageLinked(){
      return $this->belongsTo(AttributionsPassage::class,'attribution_passage') ;
    }

    public function userLinked(){
      return $this->belongsTo(User::class,'user') ;
    }
}
