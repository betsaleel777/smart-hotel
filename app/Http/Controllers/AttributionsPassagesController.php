<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttributionsPassage ;
use App\Batiment ;
use App\LiberationsPassage ;
use App\Chambre ;

class AttributionsPassagesController extends Controller
{
    public function index(){
       $titre = 'Passages & repos' ;
       $attributions = AttributionsPassage::with('batimentLinked','passageLinked','passageLinked.chambreLinked','passageLinked.chambreLinked.typeLinked')->whereNull('etat')->get()->all();
       return view('attribution.passage.index',compact('attributions','titre')) ;
    }

    public function add(){
      $titre = 'Attribution de Chambre' ;
      $batiments = Batiment::select('id','libelle')->get() ;
      return view('attribution.passage.add',compact('titre','batiments')) ;
    }

    public function edit($id){
      $titre = 'Modification d\'attribution' ;
      $batiments = Batiment::select('id','libelle')->get() ;
      $attribution = AttributionsPassage::with('passageLinked')->findOrFail($id) ;
      return view('attribution.passage.edit',compact('titre','attribution','batiments')) ;
    }

    public function update(Request $request,int $id){
      //mofifier le batiment de l'attribution
      //modifier le passage associé
      //redirection
    }

    public function liberer($id){
      $attribution = AttributionsPassage::with('passageLinked')->findOrFail($id) ;
      $attribution->etat = 'libéré' ;
      $attribution->save() ;
      $liberation = new LiberationsPassage() ;
      $liberation->attribution = $attribution->id ;
      $liberation->save() ;
      $chambre = Chambre::findOrFail($attribution->passageLinked->chambre) ;
      $chambre->setOpen() ;
      $chambre->save() ;
      $message = 'la chambre '.$chambre->libelle.'a été libérée avec succès !!' ;
      return redirect()->route('attributions_pass_index')->with('success',$message) ;
    }

    public function delete($id){
       $attribution = AttributionsPassage::findOrFail($id) ;
       $message = 'Suppression éffectuée avec succes !!' ;
       $attribution->delete() ;
       return redirect()->route('attributions_pass_index')->with('success',$message) ;
    }
}
