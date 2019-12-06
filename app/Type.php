<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['libelle','cout_reservation','cout_repos','cout_passage'] ;
    protected $dates = ['created_at','updated_at','deleted_at'] ;
    
    const RULES = [ 'libelle' => 'required|max:150',
                    'cout_repos' => 'required|numeric',
                    'cout_reservation' => 'required|numeric',
                    'cout_passage' => 'required|numeric'
                  ] ;
    const MESSAGES = [
                       'libelle.required' => 'Le libelle est requis' ,
                       'libelle.max' => 'Maximum de caractères 25' ,
                       'cout_repos.required' => 'Le coût du repos est requis' ,
                       'cout_repos.numeric' => 'Ce coût doit être un nombre' ,
                       'cout_reservation.required' => 'Le cout de la réservation est requis' ,
                       'cout_reservation.numeric' => 'Ce cout doit être un nombre' ,
                       'cout_passage.required' => 'Le cout de passage est requis' ,
                       'cout_passage.numeric' => 'Ce cout doit être un nombre' ,
                     ] ;
    public function chambres(){
      return $this->hasMany(Chambre::class,'type') ;
    }
}
