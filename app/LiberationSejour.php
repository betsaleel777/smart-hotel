<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiberationSejour extends Model
{
  protected $table = 'liberations_sejours' ;
  protected $fillable = ['attribution'] ;
  protected $dates = ['created_at','updated_at'] ;

  const RULES = [] ;
  const MESSAGES = [] ;

  public function assignationLinked(){
    return $this->hasOne(AttributionSejour::class,'attribution') ;
  }
}
