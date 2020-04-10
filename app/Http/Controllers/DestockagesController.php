<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr ;
use App\Produit ;
use App\AttributionSejour ;
use App\Destockage ;
use App\Approvisionnement ;

class DestockagesController extends Controller
{
    //verification pour voir si des approvisionnements ont déjà été effectués et comparer les quantités
    /**
     à partir de liste des produits à enregistrer on verifie dans destockage si la somme des quantités des produit de la
    liste et ceux qui sont déjà destocké n'est pas supérieur aux quantité en stock et cela pour chaque produit de la liste
     **/
    private function checkStock(Array $liste_produit)
    {
        //recupération des id des produit de la liste
        $id_prod = [] ;
        foreach ($liste_produit as $produit) {
            $id_prod[]=(int)$produit['id'] ;
        }
        //sommation des quantités de la liste avec les produits déjà destockés
        //va chercher les produits destockes listés
        $produits_destockes = Destockage::groupBy('produit')
                          ->selectRaw('sum(quantite) as destockes,produit')
                          ->whereIn('produit', $id_prod)
                          ->get()
                          ->toArray();
        //sommation entre les valeurs des produits de la liste et ceux fournit par la DB après la requête précedente
        $list_utile = Arr::pluck($liste_produit, 'quantite', 'id');
        $produit_destockes_somme = array_map(
            function ($produit) use ($list_utile) {
                $quantite = $produit['destockes'] + $list_utile[$produit['produit']] ;
                return ['id' => $produit['produit'],'quantite' => $quantite ] ;
            }, $produits_destockes
        );
        //recherche de l'approvisionnement des produits de la liste
        $produits_appros = Approvisionnement::groupBy('produit')
                          ->selectRaw('sum(quantite) as appros,produit')
                          ->whereIn('produit', $id_prod)
                          ->get()
                          ->pluck('appros', 'produit')->all();
        //comparaison qui verifie si les produit soumis en plus de ceux qui était déjà destockés ne dépasse pas les produits en stock en terme de quantité
        $rejected = [] ;
        foreach ($produit_destockes_somme as $ligne) {
            ['id' => $id, 'quantite'=> $quantite_total_soumise] = $ligne ;
            $quantite_en_stock = $produits_appros[$id] ;
            if($quantite_total_soumise > $quantite_en_stock) {
                $rejected[] = $id ;
            }
        }
        //on rejete aussi les produits qui n'ont jamais été approvisionnés
        //ceux qui figurent dans la liste des produits soumis mais qui n'ont aucun approvisionnement en stock
        if(!empty($produits_appros)) {
            foreach ($id_prod as $id) {
                if(!array_key_exists($id, $produits_appros)) {
                    $rejected[] = $id ;
                }
            }
        }else{
            foreach ($id_prod as $id) {
                $rejected[] = $id ;
            }
        }
        return $rejected ;
    }

    private function no_repeat_product(Array $products)
    {
        $produits_sans_repetition = array_map(
            function ($product) {
                $quantite = 0 ;
                foreach ($product as $checking) {
                    $quantite += $checking['quantite'] ;
                }
                return ['id' => $checking['id'],
                    'libelle' => $checking['produit_linked']['libelle'] ,
                    'quantite' => $quantite] ;
            }, $products
        );
        return $produits_sans_repetition ;
    }

    public function addFromSejour(int $id)
    {
        $titre = 'Accéssoire de chambre' ;
        $attribution = $id ;
        $origine = 'sejour' ;
        return view('destockage.add', compact('attribution', 'titre', 'origine'));
    }

    public function addFromPassage(int $id)
    {
        $tritre = 'Accessoire de chambre' ;
        $attribution = $id ;
        $origine = 'passage' ;
        return view('destockage.add', compact('attribution', 'titre', 'origine'));
    }

    public function store(Request $request)
    {

    }

    public function save(Request $request)
    {
        $attribution = AttributionSejour::findOrFail($request->sejour);
        $rejected = $this->checkStock($request->items);
        if(empty($rejected)) {
            foreach ($request->items as $accessoire)
            {
                $calebasse = [$accessoire['id'] =>['quantite' => $accessoire['quantite'],
                                                   'user' => null,
                                                   'attribution_passage' => $request->passage ]
                                                  ] ;
                $attribution->destockes()->attach($calebasse);
            }
        }else{
            $produits = Produit::select('id', 'libelle')->whereIn('id', $rejected)->get()->toArray();
            $message = "le destockage pour les produits d'entretiens suivant: " ;
            foreach ($produits as $produit) {
                $message .=  mb_strtoupper($produit['libelle']).', ' ;
            }
            $end = "ne peut être enregistré car ils sont en manque d'approvisionnement." ;
            $message .= $end ;
            return response()->json(['warning' => $message]);
        }
    }

    public function sejourSaved(int $sejour)
    {
        $prods_without_group = Destockage::select('quantite', 'produit', 'id')
                                ->with(
                                    ['produitLinked' => function ($query) {
                                          return $query->select('libelle', 'id');
                                    }]
                                )
                                ->where('attribution_sejour', $sejour)->get();
        $products = $prods_without_group->groupBy('produit')->toArray();
        //faire disparaitre les répétitions
        $produits_sans_repetition = $this->no_repeat_product($products);
        return response()->json(['produits' => [ 'compact' => array_values($produits_sans_repetition), 'decompact' => $prods_without_group]]);
    }

    public function passageSaved(int $passage)
    {
        $prods_without_group = Destockage::select('id', 'quantite', 'produit')
                            ->with(
                                ['produitLinked' => function ($query) {
                                    return $query->select('libelle', 'id');
                                }]
                            )
                            ->where('attribution_passage', $passage)->get();
        $products = $products->groupBy('produit')->toArray();
        //faire disparaitre les répétitions
        $produits_sans_repetition = $this->no_repeat_product($products);
        return response()->json(['produits' => [ 'compact' => $produits_sans_repetition, 'decompact' => $prods_without_group]]);
    }

    public function updateSejourSaved(Request $request)
    {

    }
    public function updatePassageSaved(Request $request)
    {

    }

    public function deleteSejourSaved(int $id)
    {
        $destockage = Destockage::findOrFail($id);
        $destockage->delete();
        return response()->json(['message' => 'cette ligne de destockage de produit d\'entretien a bien été supprimé']);
    }
    public function deletePassageSaved(int $id)
    {

    }


}
