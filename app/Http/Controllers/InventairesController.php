<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventairesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $titre = 'Inventaire';
        return view('stock.inventaire.index', compact('titre'));
    }

    private static function generalChecking($request)
    {

        if (empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit , sum(destockages.quantite) AS quantite FROM
                          destockages INNER JOIN produits p ON p.id=destockages.produit GROUP BY destockages.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie,sum(a.quantite) AS entree FROM approvisionnements a LEFT JOIN r
                          ON r.produit = a.produit INNER JOIN produits p ON p.id = a.produit WHERE p.genre = 'accessoire' GROUP BY a.produit";
                $query = sprintf($texte);
            } else {
                $texte = "WITH r AS (SELECT p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                          FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit GROUP BY restaurations.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie, sum(a.quantite) AS entree FROM approvisionnements a
                          LEFT JOIN r ON r.produit = a.produit INNER JOIN produits p ON p.id=a.produit WHERE p.genre = 'consommable' GROUP BY a.produit";
                $query = sprintf($texte);
            }
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit , sum(destockages.quantite) AS quantite FROM
                          destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %1\$s GROUP BY destockages.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie,sum(a.quantite) AS entree FROM approvisionnements a LEFT JOIN r
                          ON r.produit = a.produit INNER JOIN produits p ON p.id = a.produit WHERE %1\$s AND p.genre = 'accessoire' GROUP BY a.produit";
                $condition_accessoire = "p.sous_famille = $request->sous_famille";
                $query = sprintf($texte, $condition_accessoire);
            } else {
                $texte = "WITH r AS (SELECT p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                          FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie, sum(a.quantite) AS entree FROM approvisionnements a
                          LEFT JOIN r ON r.produit = a.produit INNER JOIN produits p ON p.id=a.produit WHERE %1\$s AND p.genre = 'consommable' GROUP BY a.produit";
                $condition_consommable = "p.sous_famille = $request->sous_famille";
                $query = sprintf($texte, $condition_consommable);
            }
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = s.id";
            if ($request->type === 'accessoire') {
                //reste avant
                $texte = "WITH r as (SELECT p.libelle,destockages.produit , sum(destockages.quantite) AS quantite FROM
                          destockages INNER JOIN produits p ON p.id=destockages.produit %2\$s WHERE %1\$s GROUP BY destockages.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie,sum(a.quantite) AS entree FROM approvisionnements a LEFT JOIN r
                          ON r.produit = a.produit INNER JOIN produits p ON p.id = a.produit %2\$s WHERE %1\$s AND p.genre = 'accessoire' GROUP BY a.produit";
                $condition_accessoire = "s.famille = $request->famille";
                $query = sprintf($texte, $condition_accessoire, $jointure);
            } else {
                $texte = "WITH r AS (SELECT p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                          FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %2\$s WHERE %1\$s GROUP BY restaurations.produit)
                          SELECT p.libelle, a.produit, IFNULL(r.quantite,0) AS sortie, sum(a.quantite) AS entree FROM approvisionnements a
                          LEFT JOIN r ON r.produit = a.produit INNER JOIN produits p ON p.id=a.produit %2\$s WHERE %1\$s AND p.genre = 'consommable' GROUP BY a.produit";
                $condition_consommable = "s.famille = $request->famille";
                $query = sprintf($texte, $condition_consommable, $jointure);
            }
            return DB::select(DB::Raw($query));
        }
    }

    private static function checkingDepartement($request)
    {
        //les accessoire ne compte plus car dans tout les départements à part siège on utilise que des consommables
        if (empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides

            $texte = "WITH r AS (SELECT restaurations.departement, p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                      FROM restaurations INNER JOIN produits p ON p.id = restaurations.produit WHERE restaurations.departement = $request->departement GROUP BY restaurations.produit)
                      SELECT p.libelle, s.produit, IFNULL(r.quantite,0) AS sortie, sum(s.quantite) AS entree FROM secondaires s
                      LEFT JOIN r ON r.produit = s.produit INNER JOIN produits p ON p.id = s.produit WHERE s.departement = $request->departement GROUP BY s.produit";
            $query = sprintf($texte);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
            $texte = "WITH r AS (SELECT restaurations.departement, p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                      FROM restaurations INNER JOIN produits p ON p.id = restaurations.produit WHERE %1\$s AND restaurations.departement = $request->departement GROUP BY restaurations.produit)
                      SELECT p.libelle, s.produit, IFNULL(r.quantite,0) AS sortie, sum(s.quantite) AS entree FROM secondaires s
                      LEFT JOIN r ON r.produit = s.produit INNER JOIN produits p ON p.id = s.produit WHERE %1\$s AND s.departement = $request->departement GROUP BY s.produit";
            $condition_consommable = "p.sous_famille = $request->sous_famille";
            $query = sprintf($texte, $condition_consommable);
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = s.id";

            $texte = "WITH r AS (SELECT restaurations.departement, p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
                      FROM restaurations INNER JOIN produits p ON p.id = restaurations.produit %2\$s WHERE %1\$s AND restaurations.departement = $request->departement GROUP BY restaurations.produit)
                      SELECT p.libelle, s.produit, IFNULL(r.quantite,0) AS sortie, sum(s.quantite) AS entree FROM secondaires s
                      LEFT JOIN r ON r.produit = s.produit INNER JOIN produits p ON p.id = s.produit %2\$s WHERE %1\$s AND s.departement = $request->departement GROUP BY s.produit";
            $condition_consommable = "s.famille = $request->famille";
            $query = sprintf($texte, $condition_consommable, $jointure);

            return DB::select(DB::Raw($query));
        }

    }

    public function searchDefault(Request $request)
    {
        $inventaire = self::generalChecking($request);
        return response()->json(['inventaire' => $inventaire]);
    }

    public function searchByDepartement(Request $request)
    {
        $inventaire = self::checkingDepartement($request);
        return response()->json(['inventaire' => $inventaire]);
    }
}
/**
 * WITH r AS (SELECT restaurations.departement, p.libelle, restaurations.produit, sum(restaurations.quantite) AS quantite
FROM restaurations INNER JOIN produits p ON p.id = restaurations.produit WHERE restaurations.departement = 15 GROUP BY restaurations.produit)
SELECT p.libelle, s.produit, IFNULL(r.quantite,0) AS sortie, sum(s.quantite) AS entree FROM secondaires s
LEFT JOIN r ON r.produit = s.produit INNER JOIN produits p ON p.id = s.produit WHERE s.departement = 15 GROUP BY s.produit
 */
