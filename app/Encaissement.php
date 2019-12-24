<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encaissement extends Model
{
    use SoftDeletes ;
    protected $fillable = ['passage_nature','quantite','prix_unitaire','remise','avance','reference','sejour','client','passage'] ;

    public function immatriculer():void{
      $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
      $chiffres = '0123456789' ;
      $this->attributes['reference'] = substr(str_shuffle($lettres),0,5).\substr(\str_shuffle($chiffres),0,4) ;
    }

    public function clientLinked(){
      return $this->belongsTo(Client::class,'client') ;
    }

    public function passageLinked(){
      return $this->belongsTo(AttributionsPassage::class,'passage') ;
    }

    public function sejourLinked(){
      return $this->belongsTo(AttributionSejour::class,'sejour') ;
    }

}
