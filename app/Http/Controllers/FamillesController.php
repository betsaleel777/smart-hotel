<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famille ;

class FamillesController extends Controller
{
    public function index(){
      $titre = 'Familles' ;
      $familles = Famille::get() ;
      return \view('parametre.famille.index',compact('familles','titre')) ;
    }

    public function add(){
      $titre = 'Ajouter Famille' ;
      return \view('parametre.famille.add',compact('titre')) ;
    }

    public function store(Request $request){
      $this->validate($request,Famille::RULES,Famille::MESSAGES) ;
      Famille::create($request->all()) ;
      $message = 'la famille '.$request->libelle.' a été enregistrée avec succèss' ;
      return redirect()->route('famille_index')->with('success',$message) ;
    }

    public function edit(int $id){
      $famille = Famille::findOrFail($id) ;
      $titre = 'Modifier Famille' ;
      return view('parametre.famille.edit',compact('titre','famille')) ;
    }

    public function update(Request $request,int $id){
      $famille = Famille::findOrFail($id) ;
      $this->validate($request,Famille::RULES,Famille::MESSAGES) ;
      $famille->libelle = $request->libelle ;
      $famille->save() ;
      $message = 'la famille a été modifié avec succèss' ;
      return redirect()->route('famille_index')->with('success',$message) ;
    }

    public function show(int $id){
      $famille = Famille::with('sous_familles')->findOrFail($id) ;
      $titre = 'Sous Famille '.$famille->libelle ;
      return view('parametre.famille.show',compact('famille','titre')) ;
    }

    public function delete(int $id){
      $famille = Famille::findOrFail($id) ;
      $famille->delete() ;
      $message = 'la famille: '.$famille->libelle.' a été supprimée avec succès' ;
      return redirect()->route('famille_index')->with('success',$message) ;
    }
}
