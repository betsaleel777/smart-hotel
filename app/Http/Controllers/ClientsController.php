<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client ;
use App\TypePiece ;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::get() ;
        $titre = 'Clients' ;

        return view('parametre.client.index', compact('clients','titre')) ;
    }

    public function edit($id)
    {
      $client = Client::with('pieceLinked')->findOrFail($id) ;
      $pieces = TypePiece::get()->pluck('libelle','id') ;
      $titre = 'Modifier Client '.$client->nom ;
      return view('parametre.client.edit',compact('client','titre','pieces')) ;
    }

    public function update(Request $request, $id)
    {
      $client = Client::findOrFail($id) ;
      $this->validate($request,Client::rules($id),Client::MESSAGES) ;
      $client->nom = $request->nom ;
      $client->prenom = $request->prenom ;
      $client->contact = $request->contact ;
      $client->piece = $request->piece ;
      $client->numero_piece = $request->numero_piece ;
      $client->save() ;
      $message = 'la modification du client '.$client->nom.' '.$client->prenom.' à été enregistrée avec succès !' ;
      return \redirect()->route('client_index')->with('success',$message) ;
    }

    public function delete(int $id){
      $client = Client::findOrFail($id) ;
      $client->delete() ;
      $message = 'Le type de pièce:'.$client->nom.' '.$client->prenom.' a été supprimé avec succès!!' ;
      return redirect()->route('type_piece_index')->with('success',$message) ;
    }
}
