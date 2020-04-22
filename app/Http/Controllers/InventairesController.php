<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approvisionnement ;

class InventairesController extends Controller
{

    function index()
    {
        $titre = 'Inventaire' ;
        return view('stock.inventaire.index', compact('titre'));
    }

    function searchByDate(Request $request)
    {
        return response()->json([$request->all()]);
    }

    function searchByDateInterval(Request $request)
    {
        return response()->json([$request->all()]);
    }

    function searchDefault(Request $request)
    {
        //requette générale sans condition relié aux variables type sous_famille et famille
        $query = Approvisionnement::selectRaw('produits.libelle, restaurations.produit, restaurations.prix, sum(DISTINCT restaurations.quantite) as sortie, sum(DISTINCT approvisionnements.quantite) as entree')
                                    ->join('produits', 'approvisionnements.produit', '=', 'produits.id')
                                    ->join('restaurations', 'restaurations.produit', '=', 'approvisionnements.produit')
                                    ->whereRaw("DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') = CURRENT_DATE()")
                                    ->groupBy('restaurations.produit', 'approvisionnements.produit', 'produits.libelle', 'restaurations.prix');

        if(empty($request->type) and empty($request->sous_famille)) {
            //pas de type et pas de sous_famille ce qui inclut pas de famille
            $inventaire = $query->get()->all() ;
        }elseif (!empty($request->type) and empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides
            $inventaire = $query->orWhere('produits.genre', '=', $request->type)
                                ->get()
                                ->all();
        }elseif (!empty($request->sous_famille) and empty($request->type)) {
            //sous_famille existe mais le type n'existe pas
            $inventaire = $query->orWhere('produits.sous_famille','=',$request->sous_famille)
                                ->get()
                                ->all();
        }elseif (!empty($request->sous_famille) and !empty($request->type)) {
            //sous_famille n'existe et le type aussi
            $inventaire = $query->orWhere('produits.sous_famille','=',$request->sous_famille)
                                ->orWhere('produits.genre','=',$request->type)
                                ->get()
                                ->all();
        }elseif (!empty($request->type) and !empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type existe tous les deux
            $inventaire = $query->join('sous_familles','sous_familles.id','=','produits.sous_famille')
                                ->orWhere('sous_familles','sous_familles.famille',$request->famille) ;
        }elseif (empty($request->type) and !empty($request->famille)) {
            //la famille uniquement tous les autres sont vide
            $inventaire = $query->join('sous_familles','sous_familles.id','=','produits.sous_famille')
                                ->orWhere('sous_familles','sous_familles.famille',$request->famille)
                                ->orWhere('produits.genre','=',$request->type) ;
        }
        return response()->json([$inventaire]);
    }
}
