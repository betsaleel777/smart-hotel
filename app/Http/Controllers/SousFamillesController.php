<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SousFamille ;
use App\Famille ;

class SousFamillesController extends Controller
{
  public function index(){
    $titre = 'Sous Familles' ;
    $sous_familles = SousFamille::with('familleLinked')->get() ;
    return \view('parametre.sous_famille.index',compact('sous_familles','titre')) ;
  }

  public function add(){
    $titre = 'Ajouter Sous Famille' ;
    $familles = Famille::get()->pluck('libelle','id') ; ;
    return \view('parametre.sous_famille.add',compact('titre','familles')) ;
  }

  public function store(Request $request){
    $this->validate($request,SousFamille::RULES,SousFamille::MESSAGES) ;
    SousFamille::create($request->all()) ;
    $message = 'la sous famille '.$request->libelle.' a été enregistrée avec succèss' ;
    return redirect()->route('sous_famille_index')->with('success',$message) ;
  }

  public function plug(Request $request){
    $this->validate($request,SousFamille::RULES,SousFamille::MESSAGES) ;
    SousFamille::create($request->all()) ;
    $message = 'la sous famille '.$request->libelle.' a été enregistrée avec succèss' ;
    return redirect()->route('famille_show',$request->famille)->with('success',$message) ;
  }

  public function edit(int $id){
    $sous_famille = SousFamille::with('familleLinked')->findOrFail($id) ;
    $familles = Famille::get()->pluck('libelle','id') ;
    $titre = 'Modifier Sous Famille' ;
    return view('parametre.sous_famille.edit',compact('titre','sous_famille','familles')) ;
  }

  public function update(Request $request,int $id){
    $sous_famille = SousFamille::findOrFail($id) ;
    $this->validate($request,SousFamille::RULES,SousFamille::MESSAGES) ;
    $sous_famille->libelle = $request->libelle ;
    $sous_famille->famille = $request->famille ;
    $sous_famille->save() ;
    $message = 'la sous famille a été modifiée avec succes' ;
    return redirect()->route('sous_famille_index')->with('success',$message) ;
  }

  public function delete(int $id){
    $sous_famille = SousFamille::findOrFail($id) ;
    $sous_famille->delete() ;
    $message = 'la sous famille: '.$sous_famille->libelle.' a été supprimée avec succès' ;
    return redirect()->route('sous_famille_index')->with('success',$message) ;
  }

  public function show(int $id){
    $sous_famille = SousFamille::with(['produits' => function($query){
      $query->where('genre','consommable') ;
    }])->findOrFail($id) ;
    $titre = 'Produits de '.$sous_famille->libelle ;
    return view('parametre.sous_famille.show',compact('titre','sous_famille')) ;
  }

  public function associer(int $id){
    $famille = Famille::findOrFail($id) ;
    $titre = 'Associer à '.$famille->libelle ;
    return view('parametre.sous_famille.plug',compact('titre','famille')) ;
  }
}
