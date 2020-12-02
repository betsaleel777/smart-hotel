<?php

namespace App\Http\Controllers;

use App\Restauration;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $titre = 'Tableau de Bord';
        $departement = Auth::user()->departementLinked->id;
        if ($departement === 1) {
            $ventes = Restauration::selectRaw('code, latable, sum(prix*quantite) as addition, departement')
                ->whereNull('etat')
                ->where('departement', '!=', 1)
                ->groupBy('code')
                ->get();
            $quantite = $ventes->count();
        } else {
            $ventes = Restauration::selectRaw('code, latable, sum(prix*quantite) as addition, departement')
                ->whereNull('etat')
                ->where('departement', $departement)
                ->groupBy('code')
                ->get();
            $quantite = $ventes->count();
        }
        session(['ventes_en_attente' => $quantite]);
        return \view('dashboard', compact('titre'));
    }
}
