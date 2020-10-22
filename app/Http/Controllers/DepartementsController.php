<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departement ;

class DepartementsController extends Controller
{
    public function index()
    {

    }

    public function add()
    {

    }

    public function storejs(Request $request)
    {
        $this->validate($request, Departement::RULES, Departement::MESSAGES);
        Departement::create($request->all());
        $message = "le departement $request->nom a été enregistré avec succès" ;
        return response()->json(['message' => $message]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Departement::RULES, Departement::MESSAGES);
        Departement::create($request->all());
        $message = "le departement $request->nom a été enregistré avec succès" ;
        return redirect()->route('departement_index')->with('success', $message)->withErrors($request->all());
    }

    public function edit(int $id)
    {

    }

    public function update(Request $request)
    {

    }

    public function delete(int $id)
    {

    }

    public function getDepartements()
    {
      $departements = Departement::select('id','nom')->get() ;
      return response()->json(['departements' => $departements]) ;
    }
}
