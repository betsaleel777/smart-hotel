<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = ['nom'] ;

    const RULES = ['nom' => 'required|max:90|unique:departements,nom'] ;
    const MESSAGES = ['nom.required' => 'Le nom est requis',
                      'nom.max' => 'Nombre de caractère maximal dépassé',
                      'nom.unique' => 'Ce département existe déjà'
                     ] ;

    public function users(){
      return $this->hasMany(User::class,'departement') ;
    }
}
