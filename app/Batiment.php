<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batiment extends Model
{
    use SoftDeletes ;
    
    protected $fillable = ['libelle'];
    protected $dates = ['created_at','updated_at','deleted_at'] ;
    const RULES = ['libelle'  => 'required|max:20' ] ;
    const MESSAGES = ['libelle.required'  => 'Ce champs est requis','libelle.max' => 'maximum de caractère dépassé (20)' ] ;

    public function chambres(){
      return $this->hasMany(Chambre::class,'batiment') ;
    }

    public function attributions_passages(){
      return $this->hasMany(AttributionsPassage::class,'batiment');
    }
}
