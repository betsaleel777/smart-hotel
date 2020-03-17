<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batiment ;
use App\Passage ;
use App\AttributionsPassage ;
use App\Chambre ;
use App\LiberationsPassage ;
use App\Encaissement ;

class ApiPassageController extends Controller
{
    public function allRooms($batiment)
    {
        $chambres = Batiment::with('chambres.typeLinked')->findOrFail($batiment)->chambres->all() ;

        return response()->json(['chambres' => $chambres]) ;
    }

    public function emptyRooms($batiment)
    {
        $chambres = Batiment::with(['chambres' => function ($query) {
            $query->where('statut', '=', 'inoccupée');
        },'chambres.typeLinked'])->findOrFail($batiment)->chambres->all() ;

        return response()->json(['chambres' => $chambres]) ;
    }

    public function usedRooms($batiment)
    {
        $chambres = Batiment::with(['chambres' => function ($query) {
            $query->where('statut', '=', 'occupée');
        },'chambres.typeLinked'])->findOrFail($batiment)->chambres->all() ;

        return response()->json(['chambres' => $chambres]) ;
    }

    public function attribuer(Request $request)
    {    //validation
         $request->validate(AttributionsPassage::RULES,AttributionsPassage::MESSAGES) ;
        //insertion du passage dans la table passage
        $chambre = Chambre::with('typeLinked')->findOrFail($request->chambre) ;
        $passage = new Passage() ;
        $encaissement = new Encaissement() ;
        $passage->heure = $request->heure ;
        $passage->chambre = $request->chambre ;
        if ($request->kind === 'passage') {
            $passage->passage = true ;
            $passage->repos = false ;
            $encaissement->passage_nature = 'passage' ;
            $encaissement->prix_unitaire = $chambre->typeLinked->cout_passage ;
        } else {
            $passage->passage = false ;
            $passage->repos = true ;
            $encaissement->passage_nature = 'repos' ;
            $encaissement->prix_unitaire = $chambre->typeLinked->cout_repos ;
        }
        $passage->save() ;
        //modification du statut de la chambre deviendra "occupée"
        $chambre->setClosed() ;
        $chambre->save() ;
        //insertion de l'attribution de passage dans la table attributions_passages
        $attribution = new AttributionsPassage() ;
        $attribution->passage = $passage->id ;
        $attribution->batiment = $request->batiment ;
        $attribution->save() ;
        //enregistrment de l'Encaissement
        $encaissement->quantite = $request->heure ;
        $encaissement->passage = $attribution->id ;
        $encaissement->immatriculer() ;
        $encaissement->save() ;

        return response()->json(['success']) ;
    }

    public function liberer(Request $request)
    {
        //doit aller chercher la dernière attribution lié à cette chambre
        // il faut voir le cas ou il y a plusieurs fois attribution d'une chambre pour récupérer toujour la dernière
        $chambre = $request->chambre ;
        $attributions = AttributionsPassage::with(['passageLinked' => function ($query) use ($chambre) {
            $query->where('chambre', $chambre);
        }])->whereNull('etat')->get()->all() ;
        $concerned = array_filter($attributions, function ($ligne) {
            if ($ligne->passageLinked != null) {
                return $ligne;
            }
        }) ;
        $attribution = $concerned[array_key_first($concerned)] ;
        //changer l'état de l'attribution
        $concerned_attribution = AttributionsPassage::findOrFail($attribution->id) ;
        $concerned_attribution->etat = 'libéré' ;
        $concerned_attribution->save() ;
        //enregistrer ensuite la liberation de la chambre
        $liberation = new LiberationsPassage() ;
        $liberation->attribution = $attribution->id ;
        $liberation->save() ;
        //changement du statut de la chambre
        $chambre = Chambre::findOrFail($chambre) ;
        $chambre->setOpen() ;
        $chambre->save() ;

        return response()->json([$attribution->id]) ;
    }
}
