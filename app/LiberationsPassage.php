<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiberationsPassage extends Model
{
    protected $table = 'liberations_passages' ;
    protected $fillable = ['attribution'] ;
    protected $dates = ['created_at','updated_at'] ;

    const RULES = [] ;
    const MESSAGES = [] ;

    public function assignationLinked(){
      return $this->hasOne(AttributionsPassage::class,'attribution') ;
    }
}
