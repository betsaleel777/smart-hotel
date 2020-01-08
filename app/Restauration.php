<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restauration extends Model
{
    protected $fillable = ['quantite','sejour','passage','produit','etat','prix'] ;

    public function sejourLinked(){
      return $this->belongsTo(AttributionSejour::class,'sejour') ;
    }

    public function produitLinked(){
      return $this->belongsTo(Produit::class,'produit') ;
    }

    public function passageLinked(){
      return $this->belongsTo(AttributionsPassage::class,'passage') ;
    }

    public function setPay():void{
      $this->attributes['etat'] = 'facturer' ;
    }

}
