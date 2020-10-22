<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash ;
use App\User ;
use App\Departement ;

class ComptesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private const RULES = ['name' => 'required|max:90',
                          'email' => 'required|email|unique:users,email',
                          'departement' => 'required',
                          'password' => 'required|min:6|confirmed'
                         ] ;
    private const MESSAGES = ['name.required' => 'le nom est requis',
                              'name.max' => 'nombre de caractère maximum dépassé',
                              'email.required' => 'l\'adresse email est requise',
                              'email.email' => 'veuillez renseigner une adresse valide',
                              'email.unique' => 'cette adresse est déjà utilisée',
                              'password.required' => 'le mot de passe est requis',
                              'password.min' => 'le mot de passe doit contenir minimum 6 caractères',
                              'password.confirmed' => 'veuilez renseigner le même mot de passe',
                              'departement' => 'le choix du département est requis'
                              ] ;

    private static function regles(int $id,bool $noPassword = true)
    {
        $noPasswordRules = ['name' => 'required|max:90',
                            'email' => 'required|email|unique:users,email,'.$id,
                            'oldPassword' => 'nullable|min:6',
                            'departement' => 'required',
                            'password' => 'nullable|min:6|confirmed'
                           ] ;
        $passwordRules = ['name' => 'required|max:90',
                          'email' => 'required|email|unique:users,email,'.$id,
                          'oldPassword' => 'required|min:6',
                          'departement' => 'required',
                          'password' => 'required|min:6|confirmed'
                         ] ;
        return $noPassword ? $noPasswordRules : $passwordRules ;
    }

    public function index()
    {
        $titre = 'Gestion des comptes' ;
        $comptes = User::with('departementLinked')->get();
        return view('parametre.compte.index', compact('comptes', 'titre'));
    }

    public function add()
    {
        $titre = 'Créer un compte' ;
        $departements = Departement::get();
        return view('parametre.compte.add', compact('departements', 'titre'));
    }

    public function store(Request $request)
    {
        $this->validate($request, self::RULES, self::MESSAGES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        $message = "l'utilisateur $user->name a été ajouté avec succès !" ;
        return redirect()->route('compte_index')->with('success', $message)->withErrors($request->except('password'));
    }

    public function edit(int $id)
    {
        $compte = User::with('departementLinked')->find($id);
        $titre = 'Modifier '.$compte->name ;
        $departements = Departement::get();
        return \view('parametre.compte.edit', \compact('titre', 'compte', 'departements'));
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, self::regles($id), self::MESSAGES);
        $compte = User::find($id);

        if(!empty($request->oldPassword) or !empty($request->password_confirmation)) {

            // dd(self::regles($id, false)) ;
            $this->validate($request, self::regles($id, false), self::MESSAGES);

            if(Hash::check($request->oldPassword, $compte->password)) {
                $compte->password = Hash::make($request->password);
            }else{
                $message = "le mot de passe n'est pas correcte veuillez renseigner le bon." ;
                return redirect()->route('compte_edit',$compte)->with('error', $message);
            }
        }
        $compte->name = $request->name ;
        $compte->email = $request->email ;
        $compte->departement = $request->departement ;
        $compte->save();
        $message = "la modification du compte a été effectuée avec succès" ;
        return redirect()->route('compte_index')->with('success', $message);
    }

    public function delete(int $id)
    {
        $compte = User::find($id);
        $message = "l'utilisateur $compte->name a été supprimé avec succès" ;
        $compte->delete();
        return redirect()->route()->with('success', $message);
    }
}
