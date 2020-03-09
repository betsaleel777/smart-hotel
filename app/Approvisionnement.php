<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    protected $fillable = ['quantite','produit','user'] ;

    public function produitLinked(){
      return $this->belongsTo(Produit::class,'produit') ;
    }

    public function userLinked(){
      return $this->hasOne(User::class,'user') ;
    }
}
