<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['libelle','cout_reservation','cout_repos','cout_passage'] ;

    public function chambres(){
      return $this->hasMany(Chambre::class,'type') ;
    }
}
