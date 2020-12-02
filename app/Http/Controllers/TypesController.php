<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $titre = 'Types de chambre';
        $types = Type::get();
        return view('parametre.type.index', compact('titre', 'types'));
    }

    public function add()
    {
        $titre = 'Ajouter Type de Chambre';
        return view('parametre.type.add', compact('titre'));
    }

    public function store(Request $request)
    {
        $this->validate($request, Type::RULES, Type::MESSAGES);
        Type::create($request->all());
        $message = 'Nouveau type de chambre: "' . $request->libelle . '" a bien été enregistré !!';
        return \redirect()->route('type_index')->with('success', $message);
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $titre = 'Modifier Type de Chambre';
        return view('parametre.type.edit', compact('titre', 'type'));
    }

    public function update(Request $request, int $id)
    {
        $type = Type::findOrFail($id);
        $this->validate($request, Type::regles($id), Type::MESSAGES);
        $type->update($request->all());
        $message = 'Le Type de chambre a été modifier en: "' . $request->libelle . '" avec succes !!';
        return redirect()->route('type_index')->with('success', $message);
    }

    public function delete($id)
    {
        $type = Type::findOrFail($id);
        $message = 'Le type de chambre"' . $type->libelle . '" a été supprimé avec succes !!';
        $type->delete();
        return \redirect()->route('type_index')->with('success', $message);
    }
}
