<?php

namespace App\Http\Controllers;

use App\Restauration;
use App\StatsTable;
use App\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ServiceVentesController extends Controller
{

    public static function immatriculer(): string
    {
        $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chiffres = '0123456789';
        return substr(str_shuffle($lettres), 0, 5) . \substr(\str_shuffle($chiffres), 0, 4);

    }

    public function index()
    {
        $departement = Auth::user()->departementLinked->id;
        $titre = 'Ventes';
        if ($departement === 1) {
            $ventes = Restauration::selectRaw('etat,code, latable, sum(prix*quantite) as addition, departement')
                ->where('departement', '!=', 1)
                ->groupBy('code')
                ->get();
            $enAttente = Restauration::selectRaw('code, latable, sum(prix*quantite) as addition, departement')
                ->whereNull('etat')
                ->where('departement', '!=', 1)
                ->groupBy('code')
                ->get();

            $quantite = $enAttente->count();
        } else {
            $ventes = Restauration::selectRaw('etat, code, latable, sum(prix*quantite) as addition, departement')
                ->where('departement', $departement)
                ->groupBy('code')
                ->get();
            $enAttente = Restauration::selectRaw('code, latable, sum(prix*quantite) as addition, departement')
                ->whereNull('etat')
                ->where('departement', $departement)
                ->groupBy('code')
                ->get();

            $quantite = $enAttente->count();
        }
        session(['ventes_en_attente' => $quantite]);
        return \view('ventes.index', compact('titre', 'ventes'));
    }

    public function add()
    {
        $titre = 'Ajouter vente';
        return \view('ventes.add', compact('titre'));
    }

    public function edit(string $code)
    {
        $restauration = Restauration::where('code', $code)->get()->first();
        $titre = 'Vente ' . $code;
        return \view('ventes.edit', compact('titre', 'restauration'));
    }

    public function storejs(Request $request)
    {
        $departement = $request->departement;
        $table = $request->table;
        $code = self::immatriculer();
        $restaudatas = array_map(function ($element) use ($departement, $table, $code) {
            return [
                'produit' => $element['id'],
                'quantite' => $element['quantite'],
                'prix' => $element['prix'],
                'departement' => $departement,
                'latable' => $table,
                'code' => $code,
            ];
        }, $request->items);
        foreach ($restaudatas as $restaudata) {
            Restauration::create($restaudata);
        }
        $message = "la vente a été enregistrée avec succès !!";
        return response()->json(['message' => $message]);
    }

    public function updatejs(Request $request)
    {
        //initialisation
        $items = $request->items;
        $departement = $request->departement;
        $table = $request->table;
        $code = $request->code;

        //supprimer toutes les ventes du même code
        $toDelete = Restauration::where('code', $code)->get();
        foreach ($toDelete as $element) {
            $element->delete();
        }
        // formater les nouvelles ventes et les anciennes (modifiée ou pas)
        $restaudatas = array_map(function ($element) use ($departement, $table, $code) {
            return [
                'produit' => $element['id'],
                'quantite' => $element['quantite'],
                'prix' => $element['prix'],
                'departement' => $departement,
                'latable' => $table,
                'code' => $code,
            ];
        }, $items);
        // créer nouvelle ventes
        foreach ($restaudatas as $restaudata) {
            Restauration::create($restaudata);
        }
        session()->flash('success', "La modification de la vente $code a été effectuée avec succès");
        return;
    }

    public function solderjs(Request $request)
    {
        $toSolde = Restauration::where('code', $request->code)->get();
        foreach ($toSolde as $element) {
            $element->etat = 'facturer';
            $element->save();
        }
        session()->flash('success', "La vente $request->code a été soldée avec succès");
        return;
    }

    public function statjs(Request $request)
    {
        //vérifier si statistique déjà enregistrée
        if (!empty(StatsTable::where('restauration', $request->restauration)->get()->all())) {
            $message = "Statistique déjà enregistrée pour la vente $request->restauration";
            return response()->json(['message' => $message], 400);
        }
        //verifier si le nombre soumis est correcte
        $table = Table::find($request->table);
        if ((int) $request->nombre > (int) $table->nombre_max) {
            $message = "Valeure érronée détectée !! La table $table->numero peut acceuillir uniquement: $table->nombre_max personnes";
            return response()->json(['message' => $message], 400);
        }
        StatsTable::create($request->all());
        return;
    }

    public function show(string $code)
    {
        $ventes = Restauration::with('produitLinked', 'tableLinked')->where('code', $code)->get();
        $titre = 'Détails vente ' . $code;
        return view('ventes.show', compact('titre', 'ventes'));
    }

    function print(string $code) {
        $ventes = Restauration::with('produitLinked', 'tableLinked')->where('code', $code)->get();
        $titre = "$code";
        return view('ventes.print', compact('titre', 'ventes'));
    }

    public function recu(string $code)
    {
        $ventes = Restauration::with('produitLinked', 'tableLinked')->where('code', $code)->get();
        $pdf = PDF::loadView('ventes.recu', compact('ventes'));
        $nom = time() . 'reçu.pdf';
        return $pdf->stream($nom);

    }

    public function oldVentes(string $code)
    {
        $ventes = Restauration::with('produitLinked')->where('code', $code)->whereNull('etat')->get()->all();
        $data = array_map(function ($vente) {
            return [
                'id' => $vente->produit,
                'libelle' => $vente->produitLinked->libelle,
                'prix' => $vente->prix,
                'quantite' => $vente->quantite,
                'vente' => $vente->id,
            ];
        }, $ventes);
        return response()->json(['ventes' => $data]);
    }
    //changer la requette de point de vente pour qu'elle compte uniquement les ventes qui ont été facturée
}
