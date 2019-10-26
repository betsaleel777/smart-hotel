<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function dashboard(){
      $titre = 'Tableau de Bord' ;
      return \view('dashboard',compact('titre')) ;
    }
}
