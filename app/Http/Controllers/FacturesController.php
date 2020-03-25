<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Encaissement ;
use App\Restauration ;
use App\AttributionSejour ;
use App\AttributionsPassage ;
use PDF;

class FacturesController extends Controller
{
    public function index()
    {
        $titre = 'Factures' ;
        $factures = Encaissement::select('reference', 'client', 'id', 'quantite', 'sejour', 'passage', 'passage_nature', 'created_at')
                  ->with('clientLinked', 'sejourLinked', 'passageLinked')->get();
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
            if(!empty($restauration_passage)) {
                $message = '<p>La libération ne peut être éffectuée car le client a éffectué un achat de consommable sans payer
                            <br><a href="'.route('resto_new', $encaissement->sejourLinked->id).'">cliquer ici pour consulter l\'achat.</a></p>' ;
                if($restauration_passage[0]->etat !== 'facturer') {
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
            if (!empty($restauration_sejour)) {
                $message = '<p>La libération ne peut être éffectuée car le client a éffectué un achat de consommable sans payer
                            <br><a href="'.route('resto_add', $encaissement->passageLinked->id).'">cliquer ici pour consulter l\'achat.</a></p>' ;
                if($restauration_sejour[0]->etat !== 'facturer') {
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

}
