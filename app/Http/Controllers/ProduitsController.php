<?php

namespace App\Http\Controllers;

use App\Produit;
use App\SousFamille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProduitsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $produits = Produit::with('sous_familleLinked')->get()->where('genre', 'consommable');
        $titre = 'Produits';
        return view('parametre.produit.index', compact('produits', 'titre'));
    }

    public function store(Request $request)
    {
        $this->validate($request, Produit::RULES, Produit::MESSAGES);
        $produit = new Produit($request->all());
        if (!empty($request->image)) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->immatriculer();
        $produit->save();
        $message = 'le produit ' . $produit->libelle . ' a été enregistré avec succès';
        return redirect()->route('produit_index')->with('success', $message);
    }

    public function plug(Request $request)
    {
        $this->validate($request, Produit::RULES, Produit::MESSAGES);
        $produit = new Produit($request->all());
        if (!empty($request->image)) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->immatriculer();
        $produit->save();
        $message = 'le produit ' . $produit->libelle . ' a été enregistré avec succès';
        return redirect()->route('sous_famille_show', $request->sous_famille)->with('success', $message);
    }

    public function add()
    {
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Ajouter Produit';
        return view('parametre.produit.add', compact('sous_familles', 'titre'));
    }

    public function edit(int $id)
    {
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Modifier Produit';
        return view('parametre.produit.edit', compact('sous_familles', 'titre', 'produit'));
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, Produit::RULES, Produit::MESSAGES);
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $produit->libelle = $request->libelle;
        $produit->seuil = $request->seuil;
        $produit->prix = $request->prix;
        $produit->achat = $request->achat;
        $produit->sous_famille = $request->sous_famille;
        if (!empty($request->image)) {
            $oldpath = public_path('images') . '/' . $produit->getOriginal('image');
            File::delete($oldpath);
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->save();
        $message = 'le produit: ' . $produit->getOriginal('libelle') . ' a été modifié avec succès!!';
        return redirect()->route('produit_index')->with('success', $message);
    }

    public function delete(int $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        $message = 'le produit: ' . $produit->libelle . ' a été supprimé avec succès!!';
        return redirect()->route('produit_index')->with('success', $message);
    }

    public function associer(int $id)
    {
        $sous_famille = SousFamille::findOrFail($id);
        $titre = 'Associer à ' . $sous_famille->libelle;
        return view('parametre.produit.plug', compact('titre', 'sous_famille'));
    }

    //----------------------------------- accessoire stand ------------------------------
    public function accessoires()
    {
        $titre = 'Accéssoires';
        $accessoires = Produit::get()->where('genre', 'accessoire');
        return view('parametre.produit.accessoire.index', compact('accessoires', 'titre'));
    }

    public function accessoireAdd()
    {
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Ajouter Accessoire';
        return view('parametre.produit.accessoire.add', compact('sous_familles', 'titre'));
    }

    public function accessoireStore(Request $request)
    {
        $this->validate($request, Produit::RULES, Produit::MESSAGES);
        $produit = new Produit($request->all());
        if (!empty($request->image)) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->genre = 'accessoire';
        $produit->immatriculer();
        $produit->save();
        $message = 'l\'accessoire ' . $produit->libelle . ' a été enregistré avec succès';
        return redirect()->route('accessoire_index')->with('success', $message);
    }

    public function accessoireEdit(int $id)
    {
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Modifier Accessoire';
        return view('parametre.produit.accessoire.edit', compact('sous_familles', 'titre', 'produit'));
    }

    public function accessoireUpdate(Request $request, int $id)
    {
        $this->validate($request, Produit::regles($id), Produit::MESSAGES);
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $produit->libelle = $request->libelle;
        $produit->seuil = $request->seuil;
        $produit->prix = $request->prix;
        $produit->achat = 0;
        $produit->sous_famille = $request->sous_famille;
        if (!empty($request->image)) {
            $oldpath = public_path('images') . '/' . $produit->getOriginal('image');
            File::delete($oldpath);
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->save();
        $message = 'l\'accessoire: ' . $produit->getOriginal('libelle') . ' a été modifié avec succès!!';
        return redirect()->route('accessoire_index')->with('success', $message);
    }

    public function accessoireDelete(int $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        $message = 'l\'accessoire: ' . $produit->libelle . ' a été supprimé avec succès!!';
        return redirect()->route('accessoire_index')->with('success', $message);
    }

    //------------------------------consommable stand ----------------------------------------

    public function consommables()
    {
        $titre = 'Consommables';
        $consommables = Produit::get()->where('genre', 'consommable');
        return view('parametre.produit.consommable.index', compact('consommables', 'titre'));
    }

    public function consommableAdd()
    {
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Ajouter Accessoire';
        return view('parametre.produit.consommable.add', compact('sous_familles', 'titre'));
    }

    public function consommableStore(Request $request)
    {
        $this->validate($request, Produit::RULES, Produit::MESSAGES);
        $produit = new Produit($request->all());
        if (!empty($request->image)) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->genre = 'consommable';
        $produit->immatriculer();
        $produit->save();
        $message = 'le consommable ' . $produit->libelle . ' a été enregistré avec succès';
        return redirect()->route('consommable_index')->with('success', $message);
    }

    public function consommableEdit(int $id)
    {
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $sous_familles = SousFamille::get()->pluck('libelle', 'id');
        $titre = 'Modifier Consommable';
        return view('parametre.produit.consommable.edit', compact('sous_familles', 'titre', 'produit'));
    }

    public function consommableUpdate(Request $request, int $id)
    {
        $this->validate($request, Produit::regles($id), Produit::MESSAGES);
        $produit = Produit::with('sous_familleLinked')->findOrFail($id);
        $produit->libelle = $request->libelle;
        $produit->seuil = $request->seuil;
        $produit->prix = $request->prix;
        $produit->achat = $request->achat;
        $produit->sous_famille = $request->sous_famille;
        if (!empty($request->image)) {
            $oldpath = public_path('images') . '/' . $produit->getOriginal('image');
            File::delete($oldpath);
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $produit->image = $imageName;
        }
        $produit->save();
        $message = 'le consommable: ' . $produit->getOriginal('libelle') . ' a été modifié avec succès!!';
        return redirect()->route('consommable_index')->with('success', $message);
    }

    public function consommableDelete(int $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        $message = 'le consommable: ' . $produit->libelle . ' a été supprimé avec succès!!';
        return redirect()->route('consommable_index')->with('success', $message);
    }

    //-------------------------------- api function ----------------------------------------------
    public function getAll()
    {
        $produits = Produit::select('id', 'libelle')->get()->all();
        return response()->json(['products' => $produits]);
    }

    public function getConsommables()
    {
        $produits = Produit::select('id', 'libelle')->where('genre', 'consommable')->get()->all();
        return response()->json(['products' => $produits]);
    }

    public function getConsommablesByDep(int $dep)
    {
        $produits = Produit::selectRaw(' distinct produits.id,libelle')
            ->join('secondaires', function ($join) use ($dep) {
                $join->on('produits.id', '=', 'secondaires.produit')
                    ->where('secondaires.departement', '=', $dep);
            })
            ->where('genre', 'consommable')
            ->get()
            ->all();
        return response()->json(['products' => $produits]);
    }

    public function getDetails(Request $request)
    {
        $produit = Produit::with('sous_familleLinked')->findOrFail($request->produit);
        $produit->image = asset('images') . '/' . $produit->image;
        return response()->json(['produit' => $produit]);
    }

    public function getAccessoires()
    {
        $accessoires = Produit::select('id', 'libelle')->where('genre', 'accessoire')->get()->all();
        return response()->json(['accessoires' => $accessoires]);
    }

}
