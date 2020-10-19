<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Chambre ;
use App\Type ;
use App\Batiment ;

class ChambresController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $titre = 'Chambres' ;
        $chambres = Chambre::with('typeLinked', 'batimentLinked')->get()->all();
        return view('parametre.chambre.index', compact('titre', 'chambres'));
    }

    public function add()
    {
        $titre = 'Ajouter Chambre' ;
        $types = Type::get()->pluck('libelle', 'id');
        $batiments = Batiment::get()->pluck('libelle', 'id');
        return view('parametre.chambre.add', compact('titre', 'types', 'batiments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, Chambre::RULES, Chambre::MESSAGES);
        Chambre::create($request->all());
        $message = 'La nouvelle chambre: "'.$request->libelle.'" a bien été enregistrée !!' ;
        return  \redirect()->route('chambre_index')->with('success', $message);
    }

    public function edit($id)
    {
        $chambre = Chambre::findOrFail($id);
        $titre = 'Modifier Chambre' ;
        $types = Type::get()->pluck('libelle', 'id');
        $batiments = Batiment::get()->pluck('libelle', 'id');
        return view('parametre.chambre.edit', compact('titre', 'chambre', 'types', 'batiments'));
    }

    public function update(Request $request,int $id)
    {
        $chambre = Chambre::findOrFail($id);
        $this->validate($request, Chambre::RULES, Chambre::MESSAGES);
        $chambre->update($request->all());
        $message = 'La Chambre a été modifier avec succes !!' ;
        return redirect()->route('chambre_index')->with('success', $message);
    }

    public function delete($id)
    {
        $chambre = Chambre::findOrFail($id);
        $message = 'La chambre "'.$chambre->libelle.'" a été supprimé avec succes !!' ;
        $chambre->delete();
        return redirect()->route('chambre_index')->with('success', $message);
    }

    public function details(int $chambre)
    {
        $chambre = Chambre::with('typeLinked')->findOrFail($chambre);
        return response()->json(['chambre' => $chambre ]);
    }
}
