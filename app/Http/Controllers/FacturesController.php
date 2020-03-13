<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Encaissement ;
use PDF;

class FacturesController extends Controller
{
    public function index(){
      $titre = 'Factures' ;
      $factures = Encaissement::select('reference','client','id','quantite','sejour','passage','passage_nature','created_at')
                  ->with('clientLinked','sejourLinked','passageLinked')->get() ;
      return view('facturation.index',compact('factures','titre')) ;
    }

    public function show(int $id){
      $facture = Encaissement::with('clientLinked.pieceLinked','sejourLinked.produits','passageLinked.produits','sejourLinked.batimentLinked','passageLinked.batimentLinked','passageLinked.passageLinked.chambreLinked.typeLinked','sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id) ;
      $titre = 'Détails facture '.$facture->reference ;
      return view('facturation.show',compact('titre','facture')) ;
    }

    public function print(int $id){
      $facture = Encaissement::with('clientLinked.pieceLinked','sejourLinked.produits','passageLinked.produits','sejourLinked.batimentLinked','passageLinked.batimentLinked','passageLinked.passageLinked.chambreLinked.typeLinked','sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id) ;
      $titre = 'Impression facture '.$facture->reference ;
      return view('facturation.print',compact('facture','titre')) ;
    }

    public function ticket(int $id){
      $facture = Encaissement::with('clientLinked.pieceLinked','sejourLinked.produits','passageLinked.produits','sejourLinked.batimentLinked','passageLinked.batimentLinked','passageLinked.passageLinked.chambreLinked.typeLinked','sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id) ;
      $titre = 'Facture '.$facture->reference ;
      $pdf = PDF::loadView('facturation.ticket',compact('facture'))->setPaper('A6', 'landscape') ;
      $nom = time().$facture->reference.'.pdf' ;
      return $pdf->stream($nom) ;
    }

}
