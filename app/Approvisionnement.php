<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    protected $fillable = ['quantite','produit','user','achat'] ;

    public function produitLinked()
    {
        return $this->belongsTo(Produit::class, 'produit');
    }

    public function userLinked()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
