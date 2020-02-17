<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestockagesController extends Controller
{
    public function add(int $id){
      $titre = 'Accéssoire de chambre' ;
      $attribution = $id ;
      return view('destockage.add',compact('attribution','titre')) ;
    }

    public function store(Request $request){

    }

}
