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
            $condition_vente = "AND DATE_FORMAT(r.created_at,'%Y-%m-%d') = '$request->oneDate'";
        } elseif ($fonction === 'par_intervale_de_date') {
            $condition_vente = "AND DATE_FORMAT(r.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'";
        } elseif ($fonction === 'par_defaut') {
            $condition_vente = "AND MONTH(r.created_at) = MONTH(CURRENT_DATE())";
        }

        if (empty($request->famille) and empty($request->sous_famille)) {
            //famille et sous famille sont vides
            $texte = "SELECT p.id, p.libelle, sum(r.quantite) AS sortie, r.prix FROM restaurations r INNER JOIN produits p ON p.id = r.produit
                      WHERE r.departement = $request->departement %1\$s  GROUP BY r.produit";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
            $texte = "SELECT p.id, p.libelle, sum(r.quantite) AS sortie, r.prix FROM restaurations r INNER JOIN produits p ON p.id = r.produit
                      WHERE r.departement = $request->departement %1\$s  GROUP BY r.produit";
            $condition_vente .= " AND produits.sous_famille = $request->sous_famille";
            $query = sprintf($texte, $condition_vente);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON produits.sous_famille = s.id";
            $texte = "SELECT p.libelle, sum(r.quantite) AS sortie, r.prix FROM restaurations r INNER JOIN produits p ON p.id = r.produit %2\$s
                      WHERE r.departement = $request->departement %1\$s  GROUP BY r.produit";
            $condition_vente .= " AND s.famille = $request->famille";
            $query = sprintf($texte, $condition_vente, $jointure);
            return DB::select(DB::Raw($query));
        }

    }

    public function searchByDate(Request $request)
    {
        $point = self::generalChecking($request, 'par_date');
        return response()->json(['point' => $point]);
    }

    public function searchByDateInterval(Request $request)
    {
        $point = self::generalChecking($request, 'par_intervale_de_date');
        return response()->json(['point' => $point]);
    }

    public function searchDefault(Request $request)
    {
        $point = self::generalChecking($request, 'par_defaut');
        return response()->json(['point' => $point]);
    }
}
/**
 * SELECT p.libelle, sum(r.quantite) AS sortie, r.prix FROM restaurations r INNER JOIN produits p ON p.id = r.produit
WHERE r.departement = 15 AND MONTH(r.created_at) = MONTH(CURRENT_DATE()) GROUP BY r.produit
 */
