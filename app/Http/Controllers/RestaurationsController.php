<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restauration ;
use App\AttributionSejour ;
use App\Produit ;
use App\AttributionsPassage ;
use App\Approvisionnement ;
use PDF;

class RestaurationsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $restaurations = Restauration::get();
        $titre = 'Restaurations' ;
        return \view('restauration.index', compact('titre', 'restaurations'));
    }

    public function add(int $attribution)
    {
        $titre = 'Plats & Boissons' ;
        $attribution = AttributionSejour::with('sejourLinked')->findOrFail($attribution);
        return \view('restauration.sejour.add', compact('titre', 'attribution'));
    }

    public function new(int $attribution)
    {
        $titre = 'Plats & Boissons' ;
        $attribution = AttributionsPassage::with('passageLinked')->findOrFail($attribution);
        return view('restauration.passage.add', compact('titre', 'attribution'));
    }

    public function getProformas(Request $request)
    {
        $proformas = Restauration::with('sejourLinked.sejourLinked', 'produitLinked')->where('sejour', $request->attribution)->whereNull('etat')->get()->all();
        $proformas = array_map(
            function ($proforma) {
                $calebasse = [] ;
                $calebasse = array(
                           'id' => $proforma->produit,
                           'quantite' => $proforma->quantite,
                           'libelle' => $proforma->produitLinked->libelle,
                           'prix' => $proforma->prix,
                         ) ;
                return $calebasse ;
            }, $proformas
        );
        return response()->json(['proformas' => $proformas]);
    }

    public function getPassageProformas(Request $request)
    {
        $proformas = Restauration::with('sejourLinked.sejourLinked', 'produitLinked')->where('passage', $request->attribution)->whereNull('etat')->get()->all();
        $proformas = array_map(
            function ($proforma) {
                $calebasse = [] ;
                $calebasse = array(
                           'id' => $proforma->produit,
                           'quantite' => $proforma->quantite,
                           'libelle' => $proforma->produitLinked->libelle,
                           'prix' => $proforma->prix,
                         ) ;
                return $calebasse ;
            }, $proformas
        );
        return response()->json(['proformas' => $proformas]);
    }

    public function saveProformas(Request $request)
    {
        $attribution = AttributionSejour::with('encaissement')->findOrFail($request->attribution);
        $synchrone = [] ;
        foreach ($request->proformas as $proforma) {
            $produit = Produit::findOrFail($proforma['id']);
            $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite'], 'prix' => $produit->prix ]] ;
            $synchrone += $calebasse ;
        }
        $message = 'la facture proforma de référence '.$attribution->encaissement->reference.' a été enregistrée avec succès !!' ;
        $attribution->produits()->sync($synchrone);
        return response()->json(['message' => $message]);
    }

    public function savePassageProformas(Request $request)
    {
        $attribution = AttributionsPassage::with('encaissement')->findOrFail($request->attribution);
        $synchrone = [] ;
        foreach ($request->proformas as $proforma) {
            $produit = Produit::findOrFail($proforma['id']);
            $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite'], 'prix' => $produit->prix ]] ;
            $synchrone += $calebasse ;
        }
        $message = 'la facture proforma de référence '.$attribution->encaissement->reference.' a été enregistrée avec succès !!' ;
        $attribution->produits()->sync($synchrone);
        return response()->json(['message' => $message]);
    }

    public function solder(Request $request)
    {
        $attribution = AttributionSejour::with('encaissement')->findOrFail($request->attribution);
        $synchrone = [] ;
        foreach ($request->proformas as $proforma) {
            $produit = Produit::findOrFail($proforma['id']);
            $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite'], 'prix' => $produit->prix,'etat' => 'facturer']] ;
            $synchrone += $calebasse ;
        }
        $attribution->produits()->sync($synchrone);
        //$attribution->setPay();
        $attribution->save();
        $message = 'facture de référence '.$attribution->encaissement->reference.' a été enregistrée avec succès !!' ;
        return response()->json(['message' => $message]);
    }

    public function passageSolder(Request $request)
    {
        $attribution = AttributionsPassage::with('encaissement')->findOrFail($request->attribution);
        $synchrone = [] ;
        foreach ($request->proformas as $proforma) {
            $produit = Produit::findOrFail($proforma['id']);
            $calebasse = [$proforma['id'] => ['quantite' => $proforma['quantite'], 'prix' => $produit->prix, 'etat' => 'facturer' ]] ;
            $synchrone += $calebasse ;
        }
        $attribution->produits()->sync($synchrone);
        //$attribution->setPay();
        $attribution->save();
        $message = 'facture de référence '.$attribution->encaissement->reference.' a été enregistrée avec succès !!' ;
        return response()->json(['message' => $message]);
    }

    public function passageProformaPdf(int $attribution)
    {
        $attribution = AttributionsPassage::with('encaissement', 'produits', 'passageLinked.chambreLinked.typeLinked', 'batimentLinked')->findOrFail($attribution);
        $pdf = PDF::loadView('restauration.passage.proforma', compact('attribution'));
        $nom = time().'proforma.pdf' ;
        return $pdf->stream($nom);
    }

    public function sejourProformaPdf(int $attribution)
    {
        $attribution = AttributionSejour::with('encaissement', 'produits', 'sejourLinked.clientLinked.pieceLinked', 'sejourLinked.chambreLinked.typeLinked', 'batimentLinked')->findOrFail($attribution);
        $pdf = PDF::loadView('restauration.sejour.proforma', compact('attribution'));
        $nom = time().'proforma.pdf' ;
        return $pdf->stream($nom);
    }

    public function sejourFacturePdf(int $attribution)
    {
        $attribution = AttributionSejour::with('encaissement', 'produits', 'sejourLinked.clientLinked.pieceLinked', 'sejourLinked.chambreLinked.typeLinked', 'batimentLinked')->findOrFail($attribution);
        if($attribution->etat === null) {
            $message = 'Le client n\'a pas encore soldé la facture '.$attribution->encaissement->reference.'.' ;
            return redirect()->route('attributions_sejour_index')->with('warning', $message);
        }
        $pdf = PDF::loadView('restauration.sejour.facture', compact('attribution'));
        $nom = time().'facture.pdf' ;
        return $pdf->stream($nom);
    }

    public function passageFacturePdf(int $attribution)
    {
        $attribution = AttributionsPassage::with('encaissement', 'produits', 'passageLinked.chambreLinked.typeLinked', 'batimentLinked')->findOrFail($attribution);
        if($attribution->etat === null) {
            $message = 'Le client n\'a pas encore soldé la facture '.$attribution->encaissement->reference.'.' ;
            return redirect()->route('attributions_pass_index')->with('warning', $message);
        }
        $pdf = PDF::loadView('restauration.passage.facture', compact('attribution'));
        $nom = time().'facture.pdf' ;
        return $pdf->stream($nom);
    }

    public function delete(Request $request)
    {
        $attribution = AttributionSejour::findOrfail($request->attribution);
        $attribution->produits()->detach();
        return response()->json(['proformas' => $request->all()]);
    }

    public function passageDelete(Request $request)
    {
        $attribution = AttributionsPassage::findOrfail($request->attribution);
        $attribution->produits()->detach();
        return response()->json(['proformas' => $request->all()]);
    }

    public function check(Request $request)
    {
        //afficher l'état de consommation du produit
        $cumul_restauration = Restauration::groupBy('produit')->selectRaw('sum(quantite) as consomme,produit')->where('produit', $request->produit)->get()->first();
        //ajouter les quantité soumises
        if(!empty($cumul_restauration)) {
            $quantite_deja_consommees = $cumul_restauration->consomme ;
        }else{
            $quantite_deja_consommees = (int)$cumul_restauration ;
        }
        $total_soumis = $quantite_deja_consommees + $request->quantite ;
        //afficher l'état d'approvisionnement du même produit
        $cumul_stock = Approvisionnement::groupBy('produit')->selectRaw('sum(quantite) as appros,produit')->where('produit', $request->produit)->get()->first();
        if(!empty($cumul_stock)) {
            $quantite_en_stock = $cumul_stock->appros ;
        }else{
            $quantite_en_stock = (int)$cumul_stock ;
        }
        //comparaison de l'approvisionnement à la consommation
        if($total_soumis > $quantite_en_stock) {
            $state = false ;
            $message = "Ce produit ne peut être consommer pour la quantité de: $total_soumis, parce que le stock est insuffisant,il reste: ".$quantite_en_stock." éléments" ;
        }else{
            $state = true ;
            $message = "Le stock est bien suffisant" ;
        }
        return response()->json(['state' => $state,'message' => $message]);
    }
}
