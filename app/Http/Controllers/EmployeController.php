<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes =Employe ::orderBy('id')->paginate();
        return view('employes.partials.tableau',compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employe = Employe::findOrFail($id);
        return view('employes.edit', compact('employe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        $employe = Employe::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|max:255',
            'prenoms'=> 'sometimes|max:250',
            'email' => "sometimes|email|unique:users,email,{$employe->user_id}",
            'sexe' => 'sometimes|in:M,F',
        ]);

          $employe->nom = $validated['nom'] ?? $employe->nom;
    $employe->prenoms = $validated['prenoms  '] ?? $employe->prenoms;
    $employe->sexe = $validated['sexe'] ?? $employe->sexe;
    $employe->save();
        $employe->update($validated);

        return redirect()->route('dashboard')->with('success', 'employe mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);

    $employe->delete();

    return redirect()->back()->with('success', 'Employé supprimé avec succès.');
    }


public function create()
    {
      // return view('employes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenoms' => 'required|string|max:255',
        'raison_sociale' => 'required|exists:entreprises,raison_sociale',
        'email' => 'required|email|unique:users,email',
    ]); 
      // Recherche de l'entreprise par raison sociale
   

     $employe = Employe::create($validated);

     
    // Génération du mot de passe temporaire
    // $plainPassword = Str::random(10);

    //  $user = User::create([
    //     'name' => $validated['nom'] . ' ' . $validated['prenom'],
    //     'email' => $validated['email'],
    //     'password' => Hash::make($plainPassword),
    // ]);

    // // Attribution du rôle 'employe'
    // $user->assignRole('employe');

    //  Mail::raw("Bienvenue ! Voici votre mot de passe temporaire : $plainPassword", function ($message) use ($user) {
    //     $message->to($user->email)
    //             ->subject('Accès à votre compte employé');
    // });

    return redirect()->route('dashboard')->with('success', 'Employé créé avec succès.');
        
    }


}
