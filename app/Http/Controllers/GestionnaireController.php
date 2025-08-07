<?php

namespace App\Http\Controllers;

use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use  Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateGestionnaireRequest;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $gestionnaires =Gestionnaire ::orderBy('id')->paginate();
        return view('gestionnaires.tableau',compact('gestionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $users= User::all();
       return view('gestionnaires.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'sexe' => 'required|in:M,F',
        'email' => 'required|email|unique:users,email',
       
    ]);
     
 $plainPassword = Str::random(10);

   
    $mp=$plainPassword;
 $user = User::create([
            'name' => $validated['nom'] . ' ' . $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($plainPassword),
        ]);

        // Attribution du rôle "gestionnaire"
        $user->assignRole('gestionnaire');

    Gestionnaire::create(['nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'sexe' => $validated['sexe'],
            'user_id' => $user->id,
        ]);
   
        // Mail::raw("Bienvenue ! Voici votre mot de passe temporaire : $plainPassword\n\n", function ($message) use ($user) {
        // $message->to($user->email)
        //         ->subject('Accès à votre compte gestionnaire');

        Mail::raw(
        "Bienvenue sur l'application !\n\nVoici vos accès :\nEmail : {$user->email}\nMot de passe temporaire : $plainPassword\n\nVeuillez le changer dès votre première connexion.",
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Accès à votre compte gestionnaire');
        }
    );
   
      return redirect()->route('dashboard.index')->with('success', 'Gestionnaire ajouté avec succès.');
   }

    /**
     * Display the specified resource.
     */
    // public function show( $id)
    // {
    //      $gestionnaire = Gestionnaire::findOrFail($id);

    //  $gestionnaire->delete();

    // return redirect()->back()->with('success', ' gestionnaire supprimé avec succès.');
    // }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
         $gestionnaire = Gestionnaire::findOrFail($id);
        return view('gestionnaires.edit', compact('gestionnaire'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $gestionnaire = Gestionnaire::findOrFail($id);
        // dd($id);
         $validated = $request->validate([
        'nom' => 'sometimes|string|max:255',
        'prenom' => 'sometimes|string|max:255',
        'sexe' => 'sometimes|in:M,F', 
        'email' => "sometimes|email|unique:users,email,{$gestionnaire->user_id}",
      
    ]);
    // Mise à jour
    $gestionnaire->update($validated);

   dd($validated);

    if ($gestionnaire->user) {
            $gestionnaire->user->update([
                'name' => ($validated['nom'] ?? $gestionnaire->nom) . ' ' . ($validated['prenom'] ?? $gestionnaire->prenom),
                'email' => $validated['email'] ?? $gestionnaire->user->email,
            ]);
        }

    
        return redirect()->back()->with('error', $e->getMessage());
    }
   // return redirect()->back();
//    return redirect()->route('dashboard.index');

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $gestionnaire = Gestionnaire::findOrFail($id);

    $gestionnaire->delete();
    //return view("gestionniare.tableau");

    return redirect()->route('dashboard.index')->with('success', 'Employé supprimé avec succès.');
    }
    }

