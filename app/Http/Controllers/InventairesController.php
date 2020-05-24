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

    private function generalChecking($request, $fonction)
    {
        $condition_accessoire = '' ;
        $condition_consommable = '' ;
        $condition_appro = '' ;

        //conditions ou jointure qui s'applique en fonction de la requette
        if ($fonction === 'par_date') {
            $condition_accessoire = "DATE_FORMAT(destockages.created_at,'%Y-%m-%d') = '$request->oneDate'" ;
            $condition_consommable = "DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') = '$request->oneDate'" ;
            $condition_appro = " AND DATE_FORMAT(a.created_at,'%Y-%m-%d') = '$request->oneDate'" ;
        } elseif ($fonction === 'par_intervale_de_date') {
            $condition_accessoire = "DATE_FORMAT(destockages.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'" ;
            $condition_consommable = "DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'" ;
            $condition_appro = "AND DATE_FORMAT(a.created_at,'%Y-%m-%d') BETWEEN '$request->debut' AND '$request->fin'" ;
        } elseif ($fonction === 'par_defaut') {
            $condition_accessoire = "DATE_FORMAT(destockages.created_at,'%Y-%m-%d') = CURRENT_DATE" ;
            $condition_consommable = "DATE_FORMAT(restaurations.created_at,'%Y-%m-%d') = CURRENT_DATE" ;
            $condition_appro = " AND DATE_FORMAT(a.created_at,'%Y-%m-%d') = CURRENT_DATE" ;
        }

        if (($request->type === 'all') and empty($request->sous_famille) and empty($request->famille)) {
            //le type est par defaut et la sous famille vide ce qui inclut pas de famille
            $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit UNION SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %2\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %3\$s GROUP BY a.produit" ;
            $query = sprintf($texte, $condition_consommable, $condition_accessoire, $condition_appro);

            return DB::select(DB::Raw($query));
        } elseif (($request->type !== 'all') and empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %1\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $query = sprintf($texte, $condition_accessoire, $condition_appro);
            } else {
                $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $query = sprintf($texte, $condition_consommable, $condition_appro);
            }

            return DB::select(DB::Raw($query));
        } elseif (!empty($request->sous_famille) and ($request->type === 'all')) {
            //sous_famille existe mais le type est par defaut
            $condition_accessoire .= " AND p.sous_famille = $request->sous_famille" ;
            $condition_consommable .= " AND p.sous_famille = $request->sous_famille" ;
            $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit UNION SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %2\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %3\$s GROUP BY a.produit" ;
            $query = sprintf($texte, $condition_consommable, $condition_accessoire, $condition_appro);

            return DB::select(DB::Raw($query));
        } elseif (!empty($request->sous_famille) and ($request->type !== 'all')) {
            //sous_famille existe et le type aussi
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %1\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_accessoire .= " AND p.sous_famille = $request->sous_famille" ;
                $query = sprintf($texte, $condition_accessoire, $condition_appro);
            } else {
                $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_consommable .= " AND p.sous_famille = $request->sous_famille" ;
                $query = sprintf($texte, $condition_consommable, $condition_appro);
            }

            return DB::select(DB::Raw($query));
        } elseif (($request->type !== 'all') and !empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type sont spécifié les deux
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = s.id" ;
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit %3\$s WHERE %1\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_accessoire .= " AND s.famille = $request->famille" ;
                $query = sprintf($texte, $condition_accessoire, $condition_appro, $jointure);
            } else {
                $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_consommable .= " AND s.famille = $request->famille" ;
                $query = sprintf($texte, $condition_consommable, $condition_appro, $jointure);
            }

            return DB::select(DB::Raw($query));
        } elseif (($request->type !== 'all') and !empty($request->sous_famille)) {
            //le type est spécifié et la sous famille aussi
            if ($request->type === 'accessoire') {
                $texte = "WITH r as (SELECT p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit WHERE %1\$s GROUP BY destockages.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_accessoire .= " AND p.sous_famille = $request->sous_famille" ;
                $query = sprintf($texte, $condition_accessoire, $condition_appro);
            } else {
                $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit WHERE %1\$s GROUP BY restaurations.produit) SELECT r.prix, r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %2\$s GROUP BY a.produit" ;
                $condition_consommable .= " AND p.sous_famille = $request->sous_famille" ;
                $query = sprintf($texte, $condition_consommable, $condition_appro);
            }

            return DB::select(DB::Raw($query));
        } elseif (($request->type === 'all') and !empty($request->famille) and empty($request->sous_famille)) {
            //la famille est spécifiée mais le type est par defaut
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = s.id" ;
            $condition_consommable .= " AND s.famille = $request->famille" ;
            $condition_accessoire  .= " AND s.famille = $request->famille" ;
            $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %4\$s WHERE %1\$s GROUP BY restaurations.produit UNION SELECT r.prix, p.libelle,destockages.produit ,destockages.prix, sum(destockages.quantite) as quantite FROM destockages INNER JOIN produits p ON p.id=destockages.produit %4\$s WHERE %2\$s GROUP BY destockages.produit) SELECT r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit %3\$s GROUP BY a.produit" ;
            $query = sprintf($texte, $condition_consommable, $condition_accessoire, $condition_appro, $jointure);

            return DB::select(DB::Raw($query));
        }
    }

    public function searchByDate(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_date');
        return response()->json(['inventaire' => $inventaire]);
    }

    public function searchByDateInterval(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_intervale_de_date');
        return response()->json(['inventaire' => $inventaire]);
    }

    public function searchDefault(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_defaut');
        return response()->json(['inventaire' => $inventaire]);
    }
}
