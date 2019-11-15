<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributionsPassage extends Model
{
    protected $fillable = ['batiment','passage'] ;
    protected $table = 'attributions_passages' ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;
    const RULES = [] ;
    const MESSAGES = [] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function passageLinked(){
      return $this->belongsTo(Passage::class,'passage') ;
    }

}
