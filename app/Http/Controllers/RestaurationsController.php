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
      return response()->json([$request->all()]) ;
    }

    public function saveProformas(Request $request){
      $attribution = AttributionSejour::findOrFail($request->sejour) ;
      $synchrone = [] ;
      foreach ($request->proformas as $proforma) {
        $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite']]] ;
        $synchrone += $calebasse ;
      }
      $attribution->produits()->sync($synchrone) ;
      return response()->json([$synchrone]) ;
    }

    public function supprimer(Request $request){
      $attribution = AttributionSejour::findOrfail($request->sejour) ;
      $synchrone = [] ;
      foreach ($request->proformas as $proforma) {
        $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite']]] ;
        $synchrone += $calebasse ;
      }
      $attribution->produits()->detach($synchrone) ;
      return response()->json(['proformas' => $request->all()]) ;
    }
}
