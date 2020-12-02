<?php

namespace App\Http\Controllers;

use App\Approvisionnement;
use App\Departement;
use App\Produit;
use App\Restauration;
use App\Secondaire;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecondairesController extends Controller
{
    public function index()
    {
        $titre = 'Approvisionement des départements';
        $appros = Secondaire::with('produitLinked', 'departementLinked')->get();
        return view('stock.secondaire.index', compact('appros', 'titre'));
    }

    public function add()
    {
        $titre = 'Approvisionner selon département';
        return \view('stock.secondaire.add', compact('titre'));
    }

    public function addSession()
    {

    }

    public function storejs(Request $request)
    {
        $this->validate($request, Secondaire::RULES, Secondaire::MESSAGES);
        ['state' => $produit_disponible, 'message' => $message_verification] = self::check($request);
        if ($produit_disponible) {
            $user = User::with('departementLinked')->find(Auth::user()->id);
            $produit = Produit::find($request->produit);
            $departement = Departement::find($request->departement);
            $secondaire = new Secondaire();
            $secondaire->produit = $produit->id;
            $secondaire->departement = $departement->id;
            $secondaire->quantite = $request->quantite;
            $secondaire->user = $user->id;
            $secondaire->achat = $request->achat;
            $secondaire->save();
            $message = "le département $departement->nom a été approvisionné en \"$produit->libelle\" de $request->quantite.";
            return response()->json(['message' => $message]);
        } else {
            return response()->json(['message' => $message_verification], 422);
        }
    }

    public function getList()
    {
        $secondaires = Secondaire::selectRaw('sum(quantite) as quantite')->selectRaw('id,produit')->groupBy('produit')->get();
        return response()->json(['secondaires' => $secondaires]);
    }

    private static function check(Request $request)
    {
        //afficher l'état de consommation du produit
        $cumul_restauration = Restauration::groupBy('produit')->selectRaw('sum(quantite) as consomme,produit')->where('produit', $request->produit)->get()->first();
        //ajouter les quantité soumises
        if (!empty($cumul_restauration)) {
            $quantite_deja_consommees = $cumul_restauration->consomme;
        } else {
            $quantite_deja_consommees = (int) $cumul_restauration;
        }
        //afficher l'état d'approvisionnement du même produit
        $cumul_stock = Approvisionnement::groupBy('produit')->selectRaw('sum(quantite) as appros,produit')->where('produit', $request->produit)->get()->first();
        if (!empty($cumul_stock)) {
            $quantite_en_stock = $cumul_stock->appros - $quantite_deja_consommees;
        } else {
            $quantite_en_stock = (int) $cumul_stock;
        }
        //comparaison de l'approvisionnement à la consommation
        if ($request->quantite > $quantite_en_stock) {
            $state = false;
            $message = "Ce produit est en manque la quantité soumise de: $request->quantite, est invalide parce que le stock est insuffisant, il reste: $quantite_en_stock éléments";
        } else {
            $state = true;
            $message = "Le stock est bien suffisant";
        }
        return ['state' => $state, 'message' => $message];
    }
}
