<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restauration ;
use App\AttributionSejour ;

class RestaurationsController extends Controller
{
    public function index(){
      $restaurations = Restauration::get() ;
      $titre = 'Restaurations' ;
      return \view('restauration.index',compact('titre','restaurations')) ;
    }
    public function add(int $attribution){
      $titre = 'Plats & Boissons' ;
      $attribution = AttributionSejour::with('sejourLinked')->findOrFail($attribution) ;
      return \view('restauration.add',compact('titre','attribution')) ;
    }

    public function getProformas(Request $request){
      //recuperer id,quantite,prix pour toute les restaurations d'etat null relatives à cette attribution de sejour
      $proformas = Restauration::with('sejourLinked.sejourLinked','produitLinked')->where('sejour',$request->sejour)->whereNull('etat')->get()->all() ;
      $proformas = array_map(function($proforma){
        $calebasse = [] ;
        $calebasse = array(
                           'id' => $proforma->produit,
                           'quantite' => $proforma->quantite,
                           'libelle' => $proforma->produitLinked->libelle,
                           'prix' => $proforma->sejourLinked->sejourLinked->prix,
                         ) ;
       return $calebasse ;
      },$proformas) ;
      return response()->json(['proformas' => $proformas]) ;
    }

    public function saveProformas(Request $request){
      $attribution = AttributionSejour::findOrFail($request->sejour) ;
      $synchrone = [] ;
      foreach ($request->proformas as $proforma) {
        $produit = Produit::findOrFail($proforma['id']) ;
        $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite'], 'prix' => $produit->prix ]] ;
        $synchrone += $calebasse ;
      }
      $attribution->produits()->sync($synchrone) ;
      return response()->json([$synchrone]) ;
    }

    public function passageFacturePdf(int $attribution){

    }

    public function passageProformaPdf(int $attribution){

    }

    public function sejourProformaPdf(int $attribution){
      $attribution = AttributionSejour::with('encaissement','produits','sejourLinked.clientLinked.pieceLinked','sejourLinked.chambreLinked.typeLinked','batimentLinked')->findOrFail($attribution) ;
      $pdf = PDF::loadView('restauration.sejour.proforma',compact('attribution')) ;
      $nom = time().'proforma.pdf' ;
      return $pdf->download($nom) ;
    }

    public function sejourFacturePdf(int $attribution){

    }

    public function delete(Request $request){
      $attribution = AttributionSejour::findOrfail($request->sejour) ;
      $attribution->produits()->detach() ;
      return response()->json(['proformas' => $request->all()]) ;
    }
}
