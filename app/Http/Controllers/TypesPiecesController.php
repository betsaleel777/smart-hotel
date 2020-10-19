<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypePiece ;

class TypesPiecesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pieces()
    {
        $pieces = TypePiece::get();

        return response()->json(['pieces' => $pieces]);
    }

    public function index()
    {
        $titre = 'Types de Pièces' ;
        $pieces = TypePiece::get();
        return view('parametre.typePiece.index', compact('titre', 'pieces'));
    }

    public function add()
    {
        $titre = 'Ajouter Type de Pièce' ;
        return view('parametre.typePiece.add', compact('titre'));
    }

    public function store(Request $request)
    {
        $this->validate($request, TypePiece::RULES, TypePiece::MESSAGES);
        TypePiece::create($request->all());
        $message = 'la pièce ' . $request->libelle . ' a été crée avec succès' ;

        return redirect()->route('type_piece_index')->with('success', $message);
    }

    public function edit(int $id)
    {
        $piece = TypePiece::findOrFail($id);
        $titre = 'Modifier Type de Pièce' ;
        return view('parametre.typePiece.edit', compact('titre', 'piece'));
    }

    public function update(Request $request,int $id)
    {
        $piece = TypePiece::findOrFail($id);
        $this->validate($request, TypePiece::RULES, TypePiece::MESSAGES);
        TypePiece::update($request->all());
        if($request->libelle === $piece->libelle) {
            $message = 'Aucune modification détectée' ;
            \redirect()->route('type_piece_index')->with('infos', $message);
        }
        $message = 'la modification du libelle de la pièce a bien été enregistrée' ;
        redirect()->route('type_piece_index')->with('success', $message);
    }

    public function delete(int $id)
    {
        $piece = TypePiece::findOrFail($id);
        $piece->delete();
        $message = 'Le type de pièce:'.$piece->libelle.' a été supprimé avec succès!!' ;
        return redirect()->route('type_piece_index')->with('success', $message);
    }
}
