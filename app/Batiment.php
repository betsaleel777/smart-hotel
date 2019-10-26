<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    protected $fillable = ['libelle'];

    public function chambres(){
      return $this->hasMany(Chambre::class,'chambre') ;
    }
}
