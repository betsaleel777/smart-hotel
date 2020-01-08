<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributionSejour extends Model
{
    use SoftDeletes ;
    protected $fillable = ['sejour','etat','batiment'] ;
    protected $table = 'attributions_sejours' ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;

    const RULES = ['batiment' => 'required'] ;
    const MESSAGES = ['batiment.required' => 'le choix du batiment est requis'] ;

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function sejourLinked(){
      return $this->belongsTo(Sejour::class,'sejour') ;
    }

    public function liberation(){
      return $this->belongsTo(LiberationSejour::class,'attribution') ;
    }

    public function encaissement(){
      return $this->hasOne(Encaissement::class,'sejour') ;
    }

    public function produits(){
        return $this->belongsToMany(Produit::class,'restaurations' ,'sejour','produit')->withPivot('quantite','etat','prix')->withTimestamps() ;
    }
}
