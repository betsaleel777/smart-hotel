<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributionSejour extends Model
{
    protected $fillable = ['sejour','etat','batiment'] ;
    protected $table = 'attributions_sejours' ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function sejourLinked(){
      return $this->belongsTo(Sejour::class,'sejour') ;
    }

    public function liberation(){
      return $this->belongsTo(LiberationSejour::class,'attribution') ;
    }
}
