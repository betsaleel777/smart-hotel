<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventairesController extends Controller
{

    function index(){
      $titre = 'Inventaire' ;
      return view('stock.inventaire.index',compact('titre')) ;
    }

    function searchByDate(Request $request){
      return response()->json([$request->all()]) ;
    }

    function searchByDateInterval(Request $request){
      return response()->json([$request->all()]) ;
    }

    function searchDefault(Request $request){
      
      return response()->json([$request->all()]) ;
    }
}


/* requette d'inventaire
SELECT restaurations.produit ,restaurations.prix , sum(restaurations.quantite) as sortie , sum(approvisionnements.quantite) as entree ,
produits.libelle FROM approvisionnements inner join produits on produits.id = approvisionnements.produit INNER JOIN
restaurations on restaurations.produit = approvisionnements.produit GROUP BY restaurations.produit,restaurations.prix,produits.libelle
*/
