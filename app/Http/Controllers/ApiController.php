<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batiment ;
use App\Passage ;
use App\AttributionsPassage ;
use App\Chambre ;

class ApiController extends Controller
{
    public function allRooms($batiment){
       $chambres = Batiment::with('chambres.typeLinked')->findOrFail($batiment)->chambres->all() ;
       return response()->json(['chambres' => $chambres]) ;
    }

    public function emptyRooms($batiment){
       $chambres = Batiment::with(['chambres' => function($query){$query->where('statut','=','inoccupée');},'chambres.typeLinked'])->findOrFail($batiment)->chambres->all() ;
       return response()->json(['chambres' => $chambres]) ;
    }

    public function usedRooms($batiment){
       $chambres = Batiment::with(['chambres' => function($query){$query->where('statut','=','occupée');},'chambres.typeLinked'])->findOrFail($batiment)->chambres->all() ;
       return response()->json(['chambres' => $chambres]) ;
    }

    public function attribuer(Request $request){
      //insertion du passage dans la table passage
      $passage = new Passage() ;
      $passage->heure = $request->heure ;
      $passage->chambre = $request->chambre ;
      if($request->kind === 'passage'){
        $passage->passage = true ;
        $passage->repos = false ;
      }else{
        $passage->passage = false ;
        $passage->repos = true ;
      }
      $passage->save() ;

      //modification du statut de la chambre deviendra "occupée"
      $chambre = Chambre::findOrFail($request->chambre) ;
      $chambre->statut = 'occupée' ;
      $chambre->save() ;

      //insertion de l'attribution de passage dans la table attributions_passages
      $attribution = new AttributionsPassage() ;
      $attribution->passage = $passage->id ;
      $attribution->batiment = $request->batiment ;
      $attribution->save() ;
      return response()->json(['success']) ;
    }
}
