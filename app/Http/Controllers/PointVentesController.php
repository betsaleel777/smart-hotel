<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointVentesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $titre = 'Point de vente';
        return view('stock.point.index', compact('titre'));
    }

    private static function generalChecking($request, $fonction)
    {
        $condition_vente = '';

        //conditions ou jointure qui s'applique en fonction de la requette
        if ($fonction === 'par_date') {
            $condition_vente = "AND DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') = '$request->oneDate'";
        } elseif ($fonction === 'par_intervale_de_date') {
            $condition_vente = "AND DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'";
        } elseif ($fonction === 'par_defaut') {
            $condition_vente = "AND MONTH(restaurations.created_at) = MONTH(CURRENT_DATE())";
        }

        if (empty($request->famille) and empty($request->sous_famille)) {
            //famille et sous famille sont vides
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, approvisionnements.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN approvisionnements ON
                      approvisionnements.produit = produits.id WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, approvisionnements.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN approvisionnements ON
                      approvisionnements.produit = produits.id WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $condition_vente .= " AND produits.sous_famille = $request->sous_famille";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON produits.sous_famille = s.id";
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, approvisionnements.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN approvisionnements ON
                      approvisionnements.produit = produits.id %2\$s WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $condition_vente .= " AND s.famille = $request->famille";
            $query = sprintf($texte, $condition_vente, $jointure);
            return DB::select(DB::Raw($query));
        }
    }

    private static function generalCheckingByDepartement($request, $fonction)
    {
        $condition_vente = '';

        //conditions ou jointure qui s'applique en fonction de la requette
        if ($fonction === 'par_date') {
            $condition_vente = "AND DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') = '$request->oneDate'";
        } elseif ($fonction === 'par_intervale_de_date') {
            $condition_vente = "AND DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'";
        } elseif ($fonction === 'par_defaut') {
            $condition_vente = "AND MONTH(restaurations.created_at) = MONTH(CURRENT_DATE())";
        }

        if (empty($request->famille) and empty($request->sous_famille)) {
            //famille et sous famille sont vides
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, secondaires.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN secondaires ON
                      secondaires.produit = produits.id WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, secondaires.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN secondaires ON
                      secondaires.produit = produits.id WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $condition_vente .= " AND produits.sous_famille = $request->sous_famille";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON produits.sous_famille = s.id";
            $texte = "SELECT produits.id, produits.libelle, restaurations.prix, secondaires.achat, sum(restaurations.quantite) as sortie
                      FROM produits INNER JOIN restaurations ON restaurations.produit = produits.id INNER JOIN secondaires ON
                      secondaires.produit = produits.id %2\$s WHERE restaurations.departement = $request->departement %1\$s GROUP BY restaurations.produit";
            $condition_vente .= " AND s.famille = $request->famille";
            $query = sprintf($texte, $condition_vente, $jointure);
            return DB::select(DB::Raw($query));
        }
    }

    public function searchByDate(Request $request)
    {
        if ($request->departement === 1) {
            $point = self::generalChecking($request, 'par_date');
        } else {
            $point = self::generalCheckingByDepartement($request, 'par_date');
        }
        return response()->json(['point' => $point]);
    }

    public function searchByDateInterval(Request $request)
    {
        if ($request->departement === 1) {
            $point = self::generalChecking($request, 'par_intervale_de_date');
        } else {
            $point = self::generalCheckingByDepartement($request, 'par_intervale_de_date');
        }

        return response()->json(['point' => $point]);
    }

    public function searchDefault(Request $request)
    {
        if ($request->departement === 1) {
            $point = self::generalChecking($request, 'par_defaut');
        } else {
            $point = self::generalCheckingByDepartement($request, 'par_defaut');
        }
        return response()->json(['point' => $point]);
    }
}
