<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secondaire extends Model
{
    protected $fillable = ['quantite'] ;

    function departement()
    {
        return $this->belongsTo(Departement::class, 'departement');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    function produit()
    {
        return $this->belongsTo(Produit::class, 'user');
    }
}
