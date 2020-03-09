<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approvisionnement ;

class ApprovisionnementsController extends Controller
{
  public function index(){
    $titre = 'Approvisionnement' ;
    $appros = Approvisionnement::with('userLinked','produitLinked')->get() ;
    return view('stock.appro.index', compact('titre','appros')) ;
  }

  public function add(){
    $titre = 'Approvisionner des produits' ;
    return view('stock.appro.add', compact('titre')) ;
  }

  public function save(Request $request){
   return response()->json([$request->all()]) ;
  }

  public function edit(int $id){

  }

  public function update(Request $request,int $id){

  }

  public function delete(int $id){

  }
}
