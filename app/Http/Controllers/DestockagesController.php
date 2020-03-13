<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\AttributionSejour ;
use App\Produit ;
use App\Destockage ;

class DestockagesController extends Controller
{
    public function addFromSejour(int $id){
      $titre = 'Accéssoire de chambre' ;
      $attribution = $id ;
      $origine = 'sejour' ;
      return view('destockage.add',compact('attribution','titre','origine')) ;
    }

    public function addFromPassage(int $id){
      $tritre = 'Accessoire de chambre' ;
      $attribution = $id ;
      $origine = 'passage' ;
      return view('destockage.add',compact('attribution','titre','origine')) ;
    }

    public function store(Request $request){

    }

    public function save(Request $request){
      foreach ($request->items as $accessoire)
      {
        $data = [$request->sejour =>
                  ['quantite' => $accessoire['quantite'],
                   'user' => null,
                   'attribution_passage' => $request->passage
                  ]
                ] ;
        $produit = Produit::findOrFail($accessoire['id']) ;
        $produit->sejourDestockes()->syncWithoutDetaching($data) ;
      }
    }

    public function sejourSaved(int $sejour){
      $products = Destockage::select('quantite','produit')
                              ->with(['produitLinked' => function($query){ return $query->select('libelle','id') ;}])
                              ->where('attribution_sejour',$sejour)->get()->all() ;
      return response()->json(['produits' => $products]) ;
    }

    public function passageSaved(int $passage){
      $products = Destockage::select('quantite','produit')
                              ->with(['produitLinked' => function($query){ return $query->select('libelle','id') ;}])
                              ->where('attribution_passage',$passage)->get()->all() ;
      return response()->json(['produits' => $products]) ;
    }

}
