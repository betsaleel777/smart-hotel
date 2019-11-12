<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function allRooms(Request $request){
      return 'tout rentre bien' ;
    }

    public function emptyRooms(Request $request){

    }

    public function usedRooms(Request $request){

    }
}
