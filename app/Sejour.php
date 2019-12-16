<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sejour extends Model
{
  protected $fillable = ['debut','fin','chambre','client'] ;
  protected $dates = ['created_at','updated_at','debut','fin'] ;

  public function chambreLinked(){
    return $this->belongsTo(Chambre::class,'chambre') ;
  }

  public function attributions_sejour(){
    return $this->hasOne(AttributionSejour::class,'sejour');
  }

  public function clientLinked(){
    return $this->belongsTo(Client::class,'client') ;
  }
}
