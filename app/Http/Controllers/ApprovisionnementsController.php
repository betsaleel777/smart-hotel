<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approvisionnement ;

class ApprovisionnementsController extends Controller
{
    public function index()
    {
        $titre = 'Approvisionnement' ;
        $appros = Approvisionnement::with(
            ['produitLinked' => function ($query) {
                return $query->select('id', 'libelle', 'seuil');
            } ]
        )->get();
        return view('stock.appro.index', compact('titre', 'appros'));
    }

    public function accessoires()
    {
        $titre = 'Approvisionnement Accéssoire' ;
        $appros = Approvisionnement::with(
            ['produitLinked' => function ($query) {
                return $query->where('genre', 'accessoire')->select('id', 'libelle', 'seuil');
            } ]
        )->get()->all();
        $appros = array_values(
            array_filter(
                $appros, function ($appro) {
                    return !empty($appro->produitLinked)??$appro ;
                }
            )
        );
        return view('stock.appro.index', compact('titre', 'appros'));
    }

    public function consommables()
    {
        $titre = 'Approvisionnement Consommables' ;
        $appros = Approvisionnement::with(
            ['produitLinked' => function ($query) {
                return $query->where('genre', 'consommable')->select('id', 'libelle', 'seuil');
            } ]
        )->get()->all();
        $appros = array_values(
            array_filter(
                $appros, function ($appro) {
                    return !empty($appro->produitLinked)??$appro ;
                }
            )
        );
        return view('stock.appro.index', compact('titre', 'appros'));
    }

    public function add()
    {
        $titre = 'Approvisionner des produits' ;
        return view('stock.appro.add', compact('titre'));
    }

    public function save(Request $request)
    {
        foreach ($request->items as $produit) {
            $data = ['produit' => $produit['id'],
              'quantite' => $produit['quantite'],
              'user' => null
             ] ;
            Approvisionnement::create($data);
        }
        session()->flash('success',"les produit de la liste soumise ont bien été enregistrés comme approvisionnement") ;
    }

    public function edit(Request $request)
    {
        $appro = Approvisionnement::findOrFail($request->id);
        $appro->quantite = $request->quantite ;
        $appro->save();
        session()->flash('success',"la modification de la quantité a bien été prise en compte") ;
    }

    public function delete(int $id)
    {

    }
    
}
