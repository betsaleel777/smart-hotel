<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['nom','prenom','piece','numero_piece','contact'] ;
    protected $dates = ['created_at','updated_at'] ;
    
    public function pieceLinked(){
      return $this->belongsTo(TypePiece::class,'piece') ;
    }
}
