<?php

namespace App\Http\Controllers;

use App\Restauration;
use Illuminate\Http\Request;

class ServiceVentesController extends Controller
{
    public function index()
    {
        $titre = 'Ventes';
        return \view('ventes.index', compact('titre'));
    }

    public function storejs(Request $request)
    {
        $departement = $request->departement;
        $restaudatas = array_map(function ($element) use ($departement) {
            return [
                'produit' => $element['id'],
                'quantite' => $element['quantite'],
                'prix' => $element['prix'],
                'departement' => $departement,
            ];
        }, $request->items);
        foreach ($restaudatas as $restaudata) {
            Restauration::create($restaudata);
        }
        $message = "la vente a été enregistrée avec succès !!";
        return response()->json(['message' => $message]);
    }
}
