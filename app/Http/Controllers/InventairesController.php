<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB   ;

class InventairesController extends Controller
{
    public function index()
    {
        $titre = 'Inventaire' ;
        return view('stock.inventaire.index', compact('titre'));
    }

    private function generalChecking($request)
    {

        if (empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides
                if ($request->type === 'accessoire') {
                    $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) AS quantite FROM
                              destockages INNER JOIN produits p ON p.id=destockages.produit GROUP BY destockages.produit)
                              SELECT r.prix, r.libelle,a.produit, r.quantite AS sortie,sum(a.quantite) AS entree FROM approvisionnements a,r
                              WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $query = sprintf($texte);
                } else {
                    $texte = "WITH r AS (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) AS quantite
                              FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit GROUP BY restaurations.produit)
                              SELECT r.prix, r.libelle,a.produit, r.quantite AS sortie,sum(a.quantite) AS entree FROM approvisionnements a,r
                              WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $query = sprintf($texte);
                }
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->sous_famille)) {
            //sous_famille existe
               if ($request->type === 'accessoire') {
                    $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) AS quantite FROM
                              destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %1\$s GROUP BY destockages.produit)
                              SELECT r.prix, r.libelle,a.produit, r.quantite AS sortie,sum(a.quantite) AS entree FROM approvisionnements a,r
                              WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $condition_accessoire = "p.sous_famille = $request->sous_famille" ;
                    $query = sprintf($texte, $condition_accessoire);
                } else {
                    $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) AS quantite
                              FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit)
                              SELECT r.prix, r.libelle,a.produit, r.quantite AS sortie,sum(a.quantite) AS entree FROM approvisionnements a,r
                              WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $condition_consommable = "p.sous_famille = $request->sous_famille" ;
                    $query = sprintf($texte, $condition_consommable);
                }
            return DB::select(DB::Raw($query));

        } elseif (!empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = s.id" ;
                if ($request->type === 'accessoire') {
                    //reste avant
                    $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) AS quantite FROM
                              destockages INNER JOIN produits p ON p.id=destockages.produit %2\$s WHERE %1\$s  GROUP BY destockages.produit)
                              SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) AS entree FROM approvisionnements a,r
                              WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $condition_accessoire = "s.famille = $request->famille" ;
                    $query = sprintf($texte, $condition_accessoire, $jointure);
                } else {
                    $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %2\$s WHERE %1\$s GROUP BY restaurations.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit GROUP BY a.produit" ;
                    $condition_consommable = "s.famille = $request->famille" ;
                    $query = sprintf($texte, $condition_consommable, $jointure);
                }
            return DB::select(DB::Raw($query));
        }
    }

    public function searchDefault(Request $request)
    {
        $inventaire = $this->generalChecking($request);
        return response()->json(['inventaire' => $inventaire]);
    }
}
