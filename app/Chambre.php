<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{

    protected $fillable = ['libelle', 'statut', 'batiment', 'type'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    const RULES = [
        'libelle' => 'required|max:50|unique:chambres,libelle',
        'batiment' => 'required',
        'type' => 'required',
    ];

    const MESSAGES = [
        'libelle.required' => 'le libelle est requis',
        'libelle.unique' => 'Cette valeure du libellé est déjà utilisée',
        'libelle.max' => 'nombre de caractères maximum (50)',
        'batiment' => 'le choix du batiment',
        'type' => 'le choix du type de batiment est requis',
    ];

    public static function regles(int $id)
    {
        return [
            'libelle' => 'required|max:50|unique:chambres,libelle,' . $id,
            'batiment' => 'required',
            'type' => 'required',
        ];

    }

    public function setClosed(): void
    {
        $this->attributes['statut'] = 'occupée';
    }

    public function setReserved(): void
    {
        $this->attributes['statut'] = 'reservée';
    }

    public function setOpen(): void
    {
        $this->attributes['statut'] = 'inoccupée';
    }

    public function batimentLinked()
    {
        return $this->belongsTo(Batiment::class, 'batiment');
    }

    public function typeLinked()
    {
        return $this->belongsTo(Type::class, 'type');
    }

    public function passages()
    {
        return $this->hasMany(Passage::class, 'chambre');
    }

    public function sejours()
    {
        return $this->hasMany(Sejour::class, 'chambre');
    }
}
