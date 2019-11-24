<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batiment ;

class BatimentsController extends Controller
{
    public function index(){
      $batiments = Batiment::get() ;
      $titre = 'Batiments' ;
      return view('parametre.batiment.index',compact('titre','batiments')) ;
    }

    public function add(){
      $titre = 'Ajouter Batiment' ;
      return view('parametre.batiment.add',compact('titre')) ;
    }

    public function store(Request $request){
      $this->validate($request,Batiment::RULES,Batiment::MESSAGES) ;
      Batiment::create($request->all()) ;
      $message = 'le batiment "'.$request->libelle.'" a été ajouté avec success !!!!' ;
      return redirect()->route('batiment_index')->with('success',$message) ;
    }

    public function edit($id){
       $batiment = Batiment::findOrFail($id) ;
       $titre = 'Modifier Batiment' ;
       return view('parametre.batiment.edit',compact('batiment','titre')) ;
    }

    public function update(Request $request, $id){
      $batiment = Batiment::findOrFail($id) ;
      $libelleOld= $batiment->libelle ;
      $this->validate($request,Batiment::RULES,Batiment::MESSAGES) ;
      $batiment->update($request->all()) ;

      if( $libelleOld === $request->libelle){
        $message = 'Aucune modification détectée !!' ;
        return redirect()->route('batiment_index')->with('info',$message) ;
      }else {
        $message = 'Le batiment "'.$libelleOld.'" a été modifier en: "'.$request->libelle.'" avec succes !!' ;
        return redirect()->route('batiment_index')->with('success',$message) ;
      }
    }

    public function show($id){
      $batiment = Batiment::with('chambres')->findOrFail($id) ;
      $titre = 'Détail du batiment '.$batiment->libelle ;
      return view('parametre.batiment.show',compact('titre','batiment')) ;
    }

    public function delete($id){
      $batiment = Batiment::findOrFail($id) ;
      $message = 'le Batiment "'.$batiment->libelle.'" a été supprimé avec succes !!' ;
      $batiment->delete() ;
      return \redirect()->route('batiment_index')->with('success',$message) ;
    }
}
