<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sejour extends Model
{
  use SoftDeletes ;
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
