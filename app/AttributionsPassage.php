<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributionsPassage extends Model
{
    use SoftDeletes ;

    protected $fillable = ['batiment','passage','restHeure'] ;
    protected $table = 'attributions_passages' ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;
    const RULES = ['heure' => 'required|numeric'] ;
    const MESSAGES = ['heure.required' => 'le nombre d\'heures est requis','heure.numeric' => 'doit être un nombre'] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function passageLinked(){
      return $this->belongsTo(Passage::class,'passage') ;
    }

    public function liberation(){
      return $this->belongsTo(LiberationsPassage::class,'attribution') ;
    }

    public function encaissement(){
      return $this->hasOne(Encaissement::class,'passage') ;
    }

    public function produits(){
      return $this->belongsToMany(AttributionSejour::class,'restaurations' ,'produit','passage')->withPivot('quantite','etat') ;
    }

}
