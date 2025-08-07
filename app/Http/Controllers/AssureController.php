<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Exports\AssuresExport;
use Maatwebsite\Excel\Facades\Excel;




class AssureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assures = Assure::orderBy('id')->paginate();
        $clients = Client::all();
        return view('assures.partials.tableau', compact('assures', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Assure $assure)
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
        
        $assure = Assure::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|max:255',
            'prenoms'=> 'sometimes|max:250',
            'email' => "sometimes|email|unique:users,email,{$assure->user_id}",
            'sexe' => 'sometimes|in:M,F',
            'contact' => 'nullable|string|max:20',
            'addresse' => 'nullable|string|max:255',
            'client_id' => 'sometimes|exists:clients,id',
            'is_principal' => 'sometimes|boolean',
        ]);

        $assure->update($validated);

        if ($assure->user) {
            $assure->user->update([
                'name' => ($validated['nom'] ?? $assure->nom) . ' ' . ($validated['prenoms'] ?? $assure->prenoms),
                'email' => $validated['email'] ?? $assure->email,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Assuré mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assure = Assure::findOrFail($id);

        $assure->delete();

        return redirect()->back()->with('success', 'Assuré supprimé avec succès.');
    }


    public function create()
    {
        // return view('assures.create');
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
        'client_id' => 'required|exists:clients,id',
    ]); 

    // Récupérer le client
    $client = Client::findOrFail($validated['client_id']);

    // Créer l'utilisateur
    $user = User::create([
        'name' => $validated['nom'] . ' ' . $validated['prenoms'],
        'email' => $validated['email'],
        'password' => Hash::make('password123'), // Mot de passe temporaire
    ]);

    // Attribuer le rôle 'assure'
    $user->assignRole('assure');

    // Créer l'assuré associé
    $assure = Assure::create([
        'nom' => $validated['nom'],
        'prenoms' => $validated['prenoms'],
        'email' => $validated['email'],
        'sexe' => $validated['sexe'],
        'user_id' => $user->id,
        'client_id' => $client->id,
    ]);

    return redirect()->route('dashboard')->with('success', 'Assuré créé avec succès.');
        
    }

    public function export() 
    {
        return Excel::download(new AssuresExport, 'assures.xlsx');
    }






}
