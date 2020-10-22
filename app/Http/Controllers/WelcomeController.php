<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User ;

class WelcomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {  
        $titre = 'Tableau de Bord' ;
        return \view('dashboard', compact('titre'));
    }
}
