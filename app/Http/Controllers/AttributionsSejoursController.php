<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttributionSejour ;
use App\Sejour ;
use App\Client ;
use App\Chambre ;
use App\Encaissement ;

class AttributionsSejoursController extends Controller
{
    public function index()
    {
        $titre = 'Attribution Séjour' ;
        //recupération de toutes les attribution de chambre relatives au sejour
        return view('attribution.sejour.index', compact('titre')) ;
    }

    public function add(Request $request)
    {
        $client = new Client() ;
        $client->nom = $request->nom ;
        $client->prenom = $request->prenom ;
        $client->contact = $request->contact ;
        $client->numero_piece = $request->numero_piece ;
        $client->piece = $request->piece ;
        $client->save() ;
        $sejour = new Sejour($request->all()) ;
        $sejour->client = $client->id ;
        $sejour->save() ;
        $attribution = new AttributionSejour() ;
        $attribution->sejour = $sejour->id ;
        $attribution->batiment = $request->batiment ;
        $attribution->save() ;
        $chambre = Chambre::with('typeLinked')->findOrFail($request->chambre) ;
        $chambre->statutChange() ;
        $chambre->save() ;
        $encaissement = new Encaissement() ;
        $encaissement->remise = $request->remise*100 ;
        $encaissement->avance = $request->avance*100 ;
        $encaissement->client = $client->id ;
        $encaissement->sejour = $attribution->id ;
        $encaissement->quantite = $request->delais ;
        $encaissement->prix_unitaire = $chambre->typeLinked->cout_reservation ;
        $encaissement->immatriculer() ;
        $encaissement->save() ;

        return response()->json(['chambre' => $chambre]) ;
    }

    public function getAll()
    {
        $attributions = AttributionSejour::with('sejourLinked.clientLinked')->get()->all() ;

        return response()->json(['events' => $attributions]) ;
    }

    public function infos(int $attribution)
    {
      $att = AttributionSejour::with('sejourLinked.chambreLinked','sejourLinked.clientLinked','encaissement')
                                ->findOrfail($attribution) ;

      return response()->json(['infos' => $att]) ;
    }
}
