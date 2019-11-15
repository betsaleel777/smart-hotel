<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttributionsPassage ;
use App\Batiment ;

class AttributionsPassagesController extends Controller
{
    public function index(){
       $titre = 'Passages & repos' ;
       $attributions = AttributionsPassage::with('batimentLinked','passageLinked','passageLinked.chambreLinked','passageLinked.chambreLinked.typeLinked')->get()->all();
       return view('attribution.passage.index',compact('attributions','titre')) ;
    }

    public function add(){
      $titre = 'Attribution de Chambre' ;
      $batiments = Batiment::select('id','libelle')->get() ;
      return view('attribution.passage.add',compact('titre','batiments')) ;
    }

    public function edit($id){

    }

    public function update(Request $request,int $id){

    }

    public function delete($id){

    }
}
