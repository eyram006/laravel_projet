<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AssureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assures = Assure::orderBy('id')->paginate();
        $client = Client::all();
        return view('assures.partials.tableau', compact('employes', 'entreprises'));
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
        $assure = Assure::findOrFail($id);
        return view('assures.edit', compact('assure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        // $employe = Employe::findOrFail($id);
        // $validated = $request->validate([
        //     'nom' => 'sometimes|max:255',
        //     'prenoms'=> 'sometimes|max:250',
        //     'email' => "sometimes|email|unique:users,email,{$employe->user_id}",
        //     'sexe' => 'sometimes|in:M,F',
        //      'contact' => 'nullable|string|max:20',
        //     'addresse' => 'nullable|string|max:255',
        //     'raison_social' => 'sometimes|exists:entreprises,raison_social',
        //        'is_principal' => 'sometimes|boolean',

        // ]);

        // $employe->update($validated);

        // if ($employe->user) {
        //     $employe->user->update([
        //         'name' => ($validated['nom'] ?? $employe->nom) . ' ' . ($validated['prenoms'] ?? $employe->prenoms),
        //         'email' => $validated['email'] ?? $employe->email,
        //     ]);
        // }

  try {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'email' => 'required|email',
            'user_id' => 'required|exists:users,id',
        ]);

        $assure = Assure::find($id);
        $assure->nom = $validatedData['nom'];
        $assure->prenom = $validatedData['prenom'];
        $assure->sexe = $validatedData['sexe'];
        $assure->email = $validatedData['email'];
        $assure->user_id = $validatedData['user_id'];
        $assure->save();
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

        return redirect()->route('dashboard')->with('success', 'employe mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assure = Employe::findOrFail($id);

    $assure->delete();

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
        'email' => 'required|email|unique:users,email',
        'sexe' => 'required|in:M,F',
        'contact' => 'nullable|string|max:20',
        'raison_social' => 'required|exists:entreprises,raison_social',
        'addresse' => 'nullable|string|max:255',
        'is_principal' => 'required|boolean',
    ]); 

    // Récupérer l'entreprise
    $entreprise = Entreprise::where('raison_social', $validated['raison_social'])->firstOrFail();

    // Créer l'utilisateur

    $plainPassword = Str::random(10);

     $user = User::create([
        'name' => $validated['nom'] . ' ' . $validated['prenoms'],
        'email' => $validated['email'],
        'password' => Hash::make($plainPassword),
    ]);
 // Attribution du rôle 'employe'
    $user->assignRole('employe');

    
Employe::create([
        'nom' => $validated['nom'],
        'prenoms' => $validated['prenoms'],
        'email' => $validated['email'],
        'sexe' => $validated['sexe'],
         'contact' => $validated['contact']?? null,
         'addresse' => $validated['addresse'] ?? null,
        'entreprise_id' => $entreprise->id,
         'entreprise_access_token' => $entreprise->access_token,
        'user_id' => $user->id, // si clé étrangère
        'is_principal' => $validated['is_principal'] ?? true,
    ]);
             dd($request->all());
    // Génération du mot de passe temporaire
    

   

     Mail::raw("Bienvenue ! Voici votre mot de passe temporaire : $plainPassword", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Accès à votre compte employé');
    });

    return redirect()->route('dashboard')->with('success', 'Employé créé avec succès.');
        
    }


}
