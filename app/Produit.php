<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['libelle', 'sous_famille', 'reference', 'seuil', 'image', 'prix', 'genre', 'achat'];
    const RULES = [
        'libelle' => 'required|max:100|unique:produits,libelle',
        'sous_famille' => 'required',
        'seuil' => 'required|numeric',
        'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        'achat' => 'nullable|numeric',
        'prix' => 'required|numeric',
    ];

    const MESSAGES = [
        'libelle.required' => 'le :attribute est requis',
        'libelle.max' => 'Nombre maximal de caractère dépassé',
        'libelle.unique' => 'Cette valeure du libellé est déjà utilisée',
        'sous_famille.required' => 'le choix de la sous famille est requis',
        'seuil.required' => ' le :attribute est requis',
        'seuil.numeric' => 'le seuil doit être un nombre',
        'prix.required' => 'le :attribute est requis',
        'prix.numeric' => 'le prix doit être un nombre',
        'image.image' => 'Ce choix doit être une :attribute',
        'image.mimes' => 'Les format supportés sont: jpeg,jpg,png',
        'image.max' => 'taille maximum dépassée !!',
        'achat.numeric' => 'le prix doit être un nombre',
    ];

    public static function regles(int $id)
    {
        return [
            'libelle' => 'required|max:100|unique:produits,libelle,' . $id,
            'sous_famille' => 'required',
            'seuil' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'achat' => 'nullable|numeric',
            'prix' => 'required|numeric',
        ];

    }
    public function immatriculer(): void
    {
        $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chiffres = '0123456789';
        $this->attributes['reference'] = substr(str_shuffle($lettres), 0, 6) . \substr(\str_shuffle($chiffres), 0, 4);
    }

    public function scopeConsommable($query)
    {
        return $query->where('genre', 'consommable');
    }

    public function sous_familleLinked()
    {
        return $this->belongsTo(SousFamille::class, 'sous_famille');
    }

    public function sejours()
    {
        return $this->belongsToMany(AttributionSejour::class, 'restaurations', 'produit', 'sejour')->withPivot('quantite', 'etat');
    }

    public function passages()
    {
        return $this->belongsToMany(AttributionsPassage::class, 'restaurations', 'produit', 'passage')->withPivot('quantite', 'etat');
    }

    public function passageDestockes()
    {
        return $this->belongsToMany(AttributionsPassage::class, 'destockages', 'produit', 'attribution_passage')->withPivot('quantite', 'user', 'attribution_sejour')->withTimestamps();
    }

    public function sejourDestockes()
    {
        return $this->belongsToMany(AttributionSejour::class, 'destockages', 'produit', 'attribution_sejour')->withPivot('quantite', 'user', 'attribution_passage')->withTimestamps();
    }
}
