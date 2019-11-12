<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttributionsPassage ;
use App\Batiment ;

class AttributionsPassagesController extends Controller
{
    public function index(){
      //liste des attribution dejà effectuée avec un pourcentage montrant que l'avancement
      //du temps d'utilisation de la chambre
       $titre = 'Passages & repos' ;
       $attributions = AttributionsPassage::with('batimentLinked','passageLinked')->get() ;
       return view('attribution.passage.index',compact('attributions','titre')) ;

    }

    public function add(){
      $titre = 'Attribution de Chambre' ;
      $batiments = Batiment::select('id','libelle')->get() ;
      return view('attribution.passage.add',compact('titre','batiments')) ;
    }

    public function store(Request $request){
      //enregistrment du passage en recupérant son id
      //enregistrement de l'attribution avec l'id du passage
    }

    public function edit($id){

    }

    public function update(Request $request,int $id){

    }

    public function delete($id){

    }
}
