<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiSejourController extends Controller
{
    public function index(){
      $titre = 'Attribution Séjour' ;
      //recupération de toutes les attribution de chambre relatives au sejour
      return view('attribution.sejour.index',compact('titre')) ;
    }
}
