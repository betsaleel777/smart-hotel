<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restauration ;

class RestaurationsController extends Controller
{
    public function index(){
      $restaurations = Restauration::get() ;
      $titre = 'Restaurations' ;
      return \view('restauration.index',compact('titre','restaurations')) ;
    }
    public function add(int $attribution){
      $titre = 'Plats & Boissons' ;
      return \view('restauration.add',compact('titre','attribution')) ;
    }

}
