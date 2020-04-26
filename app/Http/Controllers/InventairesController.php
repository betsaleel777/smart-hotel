<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approvisionnement ;
use Illuminate\Support\Facades\DB   ;

class InventairesController extends Controller
{

    function index()
    {
        $titre = 'Inventaire' ;
        return view('stock.inventaire.index', compact('titre'));
    }

    private function generalChecking($request, $fonction)
    {
         $conditions = null ;
         $jointure = null ;

        //requette générale sans condition relié aux variables type sous_famille et famille
        if($fonction === 'par_date') {
            $texte = "WITH r AS (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) AS quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %1\$s WHERE DATE_FORMAT(restaurations.created_at,'%%Y-%%m-%%d') = '$request->oneDate' %2\$s GROUP BY restaurations.produit) SELECT r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) AS entree FROM approvisionnements a,r WHERE r.produit = a.produit AND DATE_FORMAT(a.created_at,'%%Y-%%m-%%d') = '$request->oneDate' GROUP BY a.produit" ;

        }elseif ($fonction === 'par_intervale_de_date') {
            $texte = "WITH r AS (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) AS quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %1\$s WHERE DATE_FORMAT(restaurations.created_at,'%%Y-%%m-%%d') BETWEEN '$request->debut' AND '$request->fin' %1\$s GROUP BY restaurations.produit) SELECT r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) AS entree FROM approvisionnements a,r WHERE r.produit = a.produit AND DATE_FORMAT(a.created_at,'%%Y-%%m-%%d') BETWEEN '$request->debut' AND '$request->fin' GROUP BY a.produit" ;

        }elseif($fonction === 'par_defaut') {
            $texte = "WITH r as (SELECT p.libelle,restaurations.produit ,restaurations.prix, sum(restaurations.quantite) as quantite FROM restaurations INNER JOIN produits p ON p.id=restaurations.produit %1\$s WHERE DATE_FORMAT(restaurations.created_at,'%%Y-%%m-%%d') = CURRENT_DATE %2\$s GROUP BY restaurations.produit) SELECT r.libelle,a.produit, r.quantite as sortie,sum(a.quantite) as entree FROM approvisionnements a,r WHERE r.produit = a.produit AND DATE_FORMAT(a.created_at,'%%Y-%%m-%%d') = CURRENT_DATE GROUP BY a.produit" ;
        }

        if(empty($request->type) and empty($request->sous_famille)) {
            //pas de type et pas de sous_famille ce qui inclut pas de famille
            $query = sprintf($texte, $jointure, $conditions);
            return DB::select(DB::Raw($query));

        }elseif (!empty($request->type) and empty($request->famille) and empty($request->sous_famille)) {
            //le type existe mais famille et sous famille sont vides
            $conditions = "AND p.genre = '$request->type'" ;
            $query = sprintf($texte, $jointure, $conditions);
            return DB::select(DB::Raw($query));

        }elseif (!empty($request->sous_famille) and empty($request->type)) {
            //sous_famille existe mais le type n'existe pas
            $conditions = "AND p.sous_famille = $request->sous_famille" ;
            $query = sprintf($texte, $jointure, $conditions);
            dd($query);
            return DB::select(DB::Raw($query));

        }elseif (!empty($request->sous_famille) and !empty($request->type)) {
            //sous_famille n'existe et le type aussi
            $conditions = "AND p.sous_famille = $request->sous_famille" ;
            $conditions .= " AND p.genre = '$request->type'" ;
            $query = sprintf($texte, $jointure, $conditions);
            return DB::select(DB::Raw($query));

        }elseif (!empty($request->type) and !empty($request->famille) and empty($request->sous_famille)) {
            //la famille et le type existe tous les deux
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = sous_familles.id" ;
            $conditions = "AND p.genre = '$request->type'" ;
            $conditions  .= " AND s.famille = '$request->famille'" ;
            $query = sprintf($texte, $jointure, $conditions);
            return DB::select(DB::Raw($query));

        }elseif (empty($request->type) and !empty($request->famille)) {
            $jointure = "INNER JOIN sous_familles s ON p.sous_famille = sous_familles.id" ;
            $conditions  = "AND s.famille = '$request->famille'" ;
            $query = sprintf($texte, $jointure, $conditions);
            return DB::select(DB::Raw($query));

        }
    }

    function searchByDate(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_date');
        return response()->json([$inventaire, 'message' => 'passe bien par searchByDate']);
    }

    function searchByDateInterval(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_intervale_de_date');
        return response()->json([$inventaire, 'message' => 'passe bien par searchByDateInterval']);
    }

    function searchDefault(Request $request)
    {
        $inventaire = $this->generalChecking($request, 'par_defaut');
        return response()->json(['inventaire' => $inventaire]);
    }

}
