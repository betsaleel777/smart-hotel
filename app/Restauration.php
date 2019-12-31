<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restauration extends Model
{
    protected $fillable = ['quantite','sejour','passage','produit','etat'] ;

    public function sejourLinked(){
      return $this->belongsTo(AttributionSejour::class,'sejour') ;
    }
    public function passageLinked(){
      return $this->belongsTo(AttributionsPassage::class,'passage') ;
    }

    public function setPay():void{
      $this->attributes['etat'] = 'facturer' ;
    }

}
