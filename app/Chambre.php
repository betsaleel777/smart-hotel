<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chambre extends Model
{
    use SoftDeletes ;

    protected $fillable = ['libelle','statut','batiment','type'] ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;
    const RULES = [
                   'libelle'  => 'required|max:50',
                   'batiment'  => 'required',
                   'type'  => 'required',
                  ] ;

    const MESSAGES = [
                      'libelle.required' => 'le libelle est requis',
                      'libelle.max' => 'nombre de caractères maximum (50)',
                      'batiment' => 'le choix du batiment',
                      'type' => 'le choix du type de batiment est requis',
                     ] ;

    public function statutChange(){
      if($this->attributes['statut'] === 'occupée'){
        $this->attributes['statut'] = 'inoccupée' ;
      }else{
        $this->attributes['statut'] = 'occupée' ;
      }
    }

    public function batimentLinked(){
      return $this->belongsTo(Batiment::class,'batiment') ;
    }

    public function typeLinked(){
      return $this->belongsTo(Type::class,'type') ;
    }

    public function passages(){
      return $this->hasMany(Passage::class,'chambre') ;
    }
}
