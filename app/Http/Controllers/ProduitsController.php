<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Produit ;
use App\SousFamille ;

class ProduitsController extends Controller
{
    public function index(){
       $produits = Produit::with('sous_familleLinked')->get()->where('genre','consommable') ;
       $titre = 'Produits' ;
       return view('parametre.produit.index',compact('produits','titre')) ;
    }

    public function store(Request $request){
      $this->validate($request,Produit::RULES,Produit::MESSAGES) ;
      $produit = new Produit($request->all()) ;
      if(!empty($request->image)){
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName) ;
        $produit->image = $imageName ;
      }
      $produit->immatriculer() ;
      $produit->save() ;
      $message = 'le produit '.$produit->libelle.'a été enregistré avec succès';
      return redirect()->route('produit_index')->with('success',$message) ;
    }

    public function plug(Request $request){
      $this->validate($request,Produit::RULES,Produit::MESSAGES) ;
      $produit = new Produit($request->all()) ;
      if(!empty($request->image)){
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName) ;
        $produit->image = $imageName ;
      }
      $produit->immatriculer() ;
      $produit->save() ;
      $message = 'le produit '.$produit->libelle.'a été enregistré avec succès';
      return redirect()->route('sous_famille_show',$request->sous_famille)->with('success',$message) ;
    }

    public function add(){
       $sous_familles = SousFamille::get()->pluck('libelle','id') ;
       $titre = 'Ajouter Produit' ;
       return view('parametre.produit.add',compact('sous_familles','titre')) ;
    }

    public function edit(int $id){
      $produit = Produit::with('sous_familleLinked')->findOrFail($id) ;
      $sous_familles = SousFamille::get()->pluck('libelle','id') ;
      $titre = 'Modifier Produit' ;
      return view('parametre.produit.edit',compact('sous_familles','titre','produit')) ;
    }

    public function update(Request $request,int $id){
      $this->validate($request,Produit::RULES,Produit::MESSAGES) ;
      $produit = Produit::with('sous_familleLinked')->findOrFail($id) ;
      $produit->libelle = $request->libelle ;
      $produit->seuil = $request->seuil ;
      $produit->prix = $request->prix ;
      $produit->sous_famille = $request->sous_famille ;
      if(!empty($request->image)){
        $oldpath = public_path('images').'/'.$produit->getOriginal('image') ;
        File::delete($oldpath) ;
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName) ;
        $produit->image = $imageName ;
      }
      $produit->save() ;
      $message = 'le produit: '.$produit->getOriginal('libelle').' a été modifié avec succès!!' ;
      // if(url()->previous() === '')
      return redirect()->route('produit_index')->with('success',$message) ;
    }

    public function delete(int $id){
       $produit = Produit::findOrFail($id) ;
       $produit->delete() ;
       $message = 'le produit: '.$produit->libelle.'a été supprimé avec succès!!' ;
       return redirect()->route('produit_index')->with('success',$message) ;
    }

    public function associer(int $id){
      $sous_famille = SousFamille::findOrFail($id) ;
      $titre = 'Associer à '.$sous_famille->libelle ;
      return view('parametre.produit.plug',compact('titre','sous_famille')) ;
    }

    //----------------------------------- accessoire stand ------------------------------
     public function accessoires(){
       $titre = 'Accéssoires' ;
       $accessoires = Produit::get()->where('genre','accessoire') ;
       return view('parametre.produit.accessoire.index', compact('accessoires','titre')) ;
     }

     public function accessoireAdd(){
        $sous_familles = SousFamille::get()->pluck('libelle','id') ;
        $titre = 'Ajouter Produit' ;
        return view('parametre.produit.accessoire.add',compact('sous_familles','titre')) ;
     }

     public function accessoireStore(Request $request){
       $this->validate($request,Produit::RULES,Produit::MESSAGES) ;
       $produit = new Produit($request->all()) ;
       if(!empty($request->image)){
         $imageName = time().'.'.$request->image->getClientOriginalExtension();
         $request->image->move(public_path('images'), $imageName) ;
         $produit->image = $imageName ;
       }
       $produit->genre = 'accessoire' ;
       $produit->immatriculer() ;
       $produit->save() ;
       $message = 'le produit '.$produit->libelle.'a été enregistré avec succès';
       return redirect()->route('accessoire_index')->with('success',$message) ;
     }

    //-------------------------------- api function ----------------------------------------------
    public function getAll(){
      $produits = Produit::select('id','libelle')->get()->all() ;
      return response()->json(['products' => $produits]) ;
    }

    public function getDetails(Request $request){
      $produit = Produit::with('sous_familleLinked')->findOrFail($request->produit) ;
      $produit->image = asset('images').'/'.$produit->image ;
      return response()->json(['produit' => $produit]) ;
    }
}
