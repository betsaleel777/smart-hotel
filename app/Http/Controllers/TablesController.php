<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    public function getAll()
    {
        $tables = Table::select('id', 'numero')->get()->all();
        return response()->json(['tables' => $tables]);
    }

    public function index()
    {
        $tables = Table::get();
        $titre = 'Tables';
        return view('parametre.table.index', compact('titre', 'tables'));
    }

    public function add()
    {
        $titre = 'Nouvelle table';
        return view('parametre.table.add', compact('titre'));
    }

    public function store(Request $request)
    {
        $this->validate($request, Table::RULES, Table::MESSAGES);
        Table::create($request->all());
        $message = "la table $request->numero a été crée avec succès";
        return redirect()->route('table_index')->with('success', $message);
    }

    public function edit(int $id)
    {
        $table = Table::find($id);
        $titre = 'Modifier la table ' . $table->numero;
        return view('parametre.table.edit', compact('table', 'titre'));
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, Table::regles($id), Table::MESSAGES);
        $table = Table::find($id);
        $table->numero = $request->numero;
        $table->nombre_max = $request->nombre_max;
        $table->save();
        $message = "la modification de la table a été effectuée avec succès";
        return redirect()->route('table_index')->with('success', $message);

    }

    public function delete(int $id)
    {
        $table = Table::find($id);
        $message = "la table $table->numero a été supprimée avec succès";
        $table->delete();
        return redirect()->route('table_index')->with('success', $message);
    }
}
