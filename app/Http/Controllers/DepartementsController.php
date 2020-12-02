<?php

namespace App\Http\Controllers;

use App\Departement;
use Illuminate\Http\Request;

class DepartementsController extends Controller
{
    public function index()
    {
        $titre = 'Départements';
        $departements = Departement::get();
        return view('departement.index', \compact('titre', 'departements'));
    }

    /**
     * créer un département de façon asynchronne
     **/
    public function storejs(Request $request)
    {
        $this->validate($request, Departement::RULES, Departement::MESSAGES);
        Departement::create($request->all());
        $message = "le departement $request->nom a été enregistré avec succès";
        return response()->json(['message' => $message]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Departement::RULES, Departement::MESSAGES);
        Departement::create($request->all());
        $message = "le departement $request->nom a été enregistré avec succès";
        return redirect()->route('departement_index')->with('success', $message)->withErrors($request->all());
    }

    public function edit(int $id)
    {
        $departement = Departement::find($id);
        $titre = 'Modifier ' . $departement->nom;
        return \view('departement.edit', \compact('departement', 'titre'));
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, Departement::regles($id), Departement::MESSAGES);
        $departement = Departement::find($id);
        $departement->nom = $request->nom;
        $departement->save();
        $message = "modification du département enregistrée avec succès";
        return redirect()->route('departement_index')->with('success', $message);
    }

    /**
     * recupère tout les départements de façon asynchronne
     **/
    public function getDepartements()
    {
        $departements = Departement::select('id', 'nom')->get();
        return response()->json(['departements' => $departements]);
    }
}
