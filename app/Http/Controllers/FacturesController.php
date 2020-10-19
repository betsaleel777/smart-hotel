<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Encaissement ;
use App\Restauration ;
use App\AttributionSejour ;
use App\AttributionsPassage ;
use App\StatsTable ;
use PDF ;

class FacturesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //pour verifier si chaque produit dans la liste a bien été facturé
    private function allpayProduct(Array $produits)
    {
        $allPayed = true ;
        foreach ($produits as $produit) {
            if($produit->etat !== 'facturer') {
                $allPayed = false ;
                break ;
            }
        }
        return $allPayed ;
    }

    public function index()
    {
        $titre = 'Factures' ;
        $factures = Encaissement::select('reference', 'client', 'id', 'quantite', 'sejour', 'passage', 'passage_nature', 'created_at')
            ->with('clientLinked', 'sejourLinked', 'passageLinked')->orderBy('id', 'DESC')->get();
        return view('facturation.index', compact('factures', 'titre'));
    }

    public function show(int $id)
    {
        $facture = Encaissement::with('clientLinked.pieceLinked', 'sejourLinked.produits', 'passageLinked.produits', 'sejourLinked.batimentLinked', 'passageLinked.batimentLinked', 'passageLinked.passageLinked.chambreLinked.typeLinked', 'sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id);
        $titre = 'Détails facture '.$facture->reference ;
        return view('facturation.show', compact('titre', 'facture'));
    }

    public function print(int $id)
    {
        $facture = Encaissement::with('clientLinked.pieceLinked', 'sejourLinked.produits', 'passageLinked.produits', 'sejourLinked.batimentLinked', 'passageLinked.batimentLinked', 'passageLinked.passageLinked.chambreLinked.typeLinked', 'sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id);
        $titre = 'Impression facture '.$facture->reference ;
        return view('facturation.print', compact('facture', 'titre'));
    }

    public function ticket(int $id)
    {
        $facture = Encaissement::with('clientLinked.pieceLinked', 'sejourLinked.produits', 'passageLinked.produits', 'sejourLinked.batimentLinked', 'passageLinked.batimentLinked', 'passageLinked.passageLinked.chambreLinked.typeLinked', 'sejourLinked.sejourLinked.chambreLinked.typeLinked')->findOrFail($id);
        $titre = 'Facture '.$facture->reference ;
        $pdf = PDF::loadView('facturation.ticket', compact('facture'))->setPaper('A6', 'landscape');
        $nom = time().$facture->reference.'.pdf' ;
        return $pdf->stream($nom);
    }

    public function solder(int $id)
    {
        //chercher l'encaissement correspondant
        $encaissement = Encaissement::with('sejourLinked', 'passageLinked')->findOrFail($id);
        //dans les deux cas il faut chercher dans restauration pour voir si cette visite y est référencé
        //voir si la restauration a bien été solder d'abord et notifier l'utilisateur au cas ou c'est pas le cas, c'est après cela qu'on peut solder la visite
        if(!empty($encaissement->sejourLinked)) {
            $restauration_sejour = Restauration::where('sejour', $encaissement->sejourLinked->id)->get()->all();
            if(!empty($restauration_sejour)) {
                $message = '<p>La libération ne peut être éffectuée car le client a éffectué un achat de consommable sans payer
                           <br><a href="'.route('resto_add', $encaissement->sejourLinked->id).'">cliquer ici pour consulter l\'achat.</a></p>' ;
                if(!$this->allpayProduct($restauration_sejour)) {
                    return redirect()->route('facture_index')->with('warning', $message);
                }
            }
            $attribution = AttributionSejour::findOrFail($encaissement->sejour);
            $attribution->etat = 'facturer' ;
            $attribution->save();
            $message = 'La facture de séjour de référence: '.$encaissement->reference.' a été soldée avec succès.' ;
            return redirect()->route('facture_index')->with('success', $message);
        }

        if(!empty($encaissement->passageLinked)) {
            $restauration_passage = Restauration::where('passage', $encaissement->passageLinked->id)->get()->all();
            if (!empty($restauration_passage)) {
                $message = '<p>La libération ne peut être éffectuée car le client a éffectué un achat de consommable sans payer
                           <br><a href="'.route('resto_new', $encaissement->passageLinked->id).'">cliquer ici pour consulter l\'achat.</a></p>' ;
                if(!$this->allpayProduct($restauration_passage)) {
                    return redirect()->route('facture_index')->with('warning', $message);
                }
            }
            $attribution = AttributionsPassage::findOrFail($encaissement->passage);
            $attribution->etat = 'facturer' ;
            $attribution->save();
            $message = 'La facture de passage de référence: '.$encaissement->reference.' a été soldée avec succès.' ;
            return redirect()->route('facture_index')->with('success', $message);
        }
    }

    public function solderTable(Request $request)
    {
        //chercher l'encaissement correspondant
        $encaissement = Encaissement::with('sejourLinked', 'passageLinked')->findOrFail($request->encaissement);

        $restauration_passage = Restauration::where('passage', $encaissement->passageLinked->id)->get()->all();
        if (!empty($restauration_passage)) {
            $message = '<p>La libération ne peut être éffectuée car le client a éffectué un achat de consommable sans payer
                        <br><a href="'.route('resto_new', $encaissement->passageLinked->id).'">cliquer ici pour consulter l\'achat.</a></p>' ;
            if(!$this->allpayProduct($restauration_passage)) {
                $request->session()->flash('warning', $message);
                return ;
            }
        }
        $attribution = AttributionsPassage::findOrFail($encaissement->passage);
        $attribution->etat = 'facturer' ;
        $attribution->save();
        $message = 'La facture de passage de référence: '.$encaissement->reference.' a été soldée avec succès.' ;
        //enregistrement des statistiques de table
        StatsTable::create($request->all());
        $request->session()->flash('success', $message);
        return  ;
    }

}
