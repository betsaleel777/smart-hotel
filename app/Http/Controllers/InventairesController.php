<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventairesController extends Controller
{
    function index(){
      $titre = 'Inventaire' ;
      return view('stock.inventaire.index') ;
    }

}
