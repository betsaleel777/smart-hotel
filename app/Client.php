<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['nom', 'prenom', 'piece', 'numero_piece', 'contact'];
    protected $dates = ['created_at', 'updated_at'];

    const MESSAGES = [
        'nom.required' => 'le :attribute est requis',
        'prenom.required' => 'le :attribute est requis',
        'piece.required' => 'le choix du type de pièce est requis',
        'numero_piece.required' => 'Le numéro de la pièce est requis',
        'numero_piece.unique' => 'Numero de pièce déjà utilisé ',
        'contact.required' => 'Le contact du client est requis',
        'contact.unique' => 'Contact déjà utilisé',
    ];
    public static function rules(int $id)
    {
        return [
            'nom' => 'required',
            'prenom' => 'required',
            'piece' => 'required',
            'numero_piece' => 'required|unique:clients,numero_piece,' . $id,
            'contact' => 'required|unique:clients,contact,' . $id,
        ];
    }

    public function pieceLinked()
    {
        return $this->belongsTo(TypePiece::class, 'piece');
    }

    public function sejours()
    {
        return $this->hasMany(Client::class, 'client');
    }

    public function encaissements()
    {
        return $this->hasMany(Encaissement::class, 'client');
    }
}
