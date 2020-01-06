<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttributionSejour ;
use App\LiberationSejour ;
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
        $chambre = Chambre::with('typeLinked')->findOrFail($request->chambre) ;
        $client = new Client() ;
        $client->nom = $request->nom ;
        $client->prenom = $request->prenom ;
        $client->contact = $request->contact ;
        $client->numero_piece = $request->numero_piece ;
        $client->piece = $request->piece ;
        $client->save() ;
        $sejour = new Sejour($request->all()) ;
        $sejour->client = $client->id ;
        $sejour->prix = $chambre->typeLinked->cout_reservation ;
        $sejour->save() ;
        $attribution = new AttributionSejour() ;
        $attribution->sejour = $sejour->id ;
        $attribution->batiment = $request->batiment ;
        $attribution->save() ;
        $chambre->setReserved() ;
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
        $attributions = AttributionSejour::with('sejourLinked.clientLinked')->whereNull('etat')->get()->all() ;

        return response()->json(['events' => $attributions]) ;
    }

    public function infos(int $attribution)
    {
      $att = AttributionSejour::with('sejourLinked.chambreLinked','sejourLinked.clientLinked','encaissement')
                                ->findOrfail($attribution) ;

      return response()->json(['infos' => $att]) ;
    }

    public function update(Request $request){
      $attribution = AttributionSejour::findOrFail($request->attribution) ;
      $sejour = Sejour::findOrFail($attribution->sejour);
      $sejour->debut = $request->debut ;
      $sejour->fin = $request->fin ;
      $sejour->save() ;
      $encaissement = Encaissement::where('sejour', $request->attribution)->get()->all()[0] ;
      $encaissement->remise = $request->remise*100 ;
      $encaissement->avance = $request->avance*100 ;
      $encaissement->quantite = $request->delais ;
      $chambre = Chambre::with('typeLinked')->findOrFail($sejour->chambre) ;
      $encaissement->prix_unitaire = $chambre->typeLinked->cout_reservation  ;
      $encaissement->save() ;
      $client = Client::findOrFail($sejour->client) ;
      $client->nom = $request->nom ;
      $client->prenom = $request->prenom ;
      $client->save() ;

      return response()->json(['chambre' => $chambre]) ;
    }

    public function liberer(Request $request){
      //changer état attribution sejour
      $attribution = AttributionSejour::with('sejourLinked')->findOrFail($request->attribution) ;
      $attribution->etat = 'libérer' ;
      $attribution->save() ;
      //enregistré libération
      LiberationSejour::create($request->all()) ;
      //changé de chambre status
      $chambre = Chambre::findOrFail($attribution->sejourLinked->chambre) ;
      $chambre->setOpen() ;
      $chambre->save() ;
      return response()->json(['chambre' => $chambre]) ;
    }

    public function delete(Request $request){
      $attribution = AttributionSejour::findOrFail($request->attribution) ;
      $sejour = Sejour::findOrFail($attribution->sejour) ;
      $encaissement = Encaissement::where('sejour', $request->attribution)->get()->all()[0] ;
      $client = Client::findOrFail($sejour->client) ;
      $chambre = Chambre::findOrFail($sejour->chambre) ;
      $encaissement->delete() ;
      $sejour->delete() ;
      $attribution->delete() ;
      $chambre->setOpen() ;
      return response()->json(['client' => $client,'chambre' => $chambre,'sejour' => $sejour]) ;
    }
}
