<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Exports\AssuresExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

/**
 * Import des assurés depuis un fichier Excel
 */

class AssureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assures = Assure::orderBy('id', 'asc')->paginate();
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
    public function update(Request $request, $id)
    {

        $assure = Assure::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|max:255',
            'prenoms' => 'sometimes|max:250',
            'email' => "sometimes|email|unique:users,email,{$assure->user_id}",
            'sexe' => 'sometimes|in:M,F',
            'contact' => 'nullable|string|max:20',
            'addresse' => 'nullable|string|max:255',
            'client_id' => 'sometimes|exists:clients,id',
            'is_principal' => 'sometimes|boolean',
        ]);

        foreach ($validated as $key => $value) {
            $assure->$key = $value;
        }
        $assure->save();

        if ($assure->user) {
            $assure->user->fill([
                'name' => ($validated['nom'] ?? $assure->nom) . ' ' . ($validated['prenoms'] ?? $assure->prenoms),
                'email' => $validated['email'] ?? $assure->email,
            ])->save();
        }

        return redirect()->route('dashboard')->with('success', 'Assuré mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assure = Assure::findOrFail($id);

        $assure->delete($id);

        return redirect()->back()->with('success', 'Assuré supprimé avec succès.');
    }


    public function create()
    {
        // return view('assures.create');
    }




    /**
     * Store a newly created resource in storage.
     */
    

    // public function export()
    // {
    //     return Excel::download(new AssuresExport, 'assures.xlsx');
    // }

    /**
     * Affiche le formulaire d'import
     */
    public function showImport()
    {
        $clients = Client::all();
        return view('assures.import', compact('clients'));
    }



    
public function store(Request $request)
{
    try {
        // Validation des données gynécologiques conditionnelle
        $this->validateGynecologicalData($request);

        // Validation des données
        $validatedData = $request->validate([
            // Données personnelles de base (pour table assures)
            'donnees_medicales.informations_personnelles.nom' => 'required|string|max:255',
            'donnees_medicales.informations_personnelles.prenom' => 'required|string|max:255',
            'donnees_medicales.informations_personnelles.sexe' => 'required|in:M,F',
            'donnees_medicales.informations_personnelles.date_naissance' => 'required|date|before:today',
            'donnees_medicales.informations_sociodemographiques.email' => 'required|email|unique:assures,email',
            'donnees_medicales.informations_sociodemographiques.telephone' => 'required|string|unique:assures,contact',
            
            // Données socio-démographiques
            'donnees_medicales.informations_sociodemographiques.situation_matrimoniale' => 'required|string',
            'donnees_medicales.informations_sociodemographiques.niveau_etudes' => 'required|string',
            'donnees_medicales.informations_sociodemographiques.quartier' => 'required|string|max:255',
            'donnees_medicales.informations_sociodemographiques.employeur' => 'required|string|max:255',
            'donnees_medicales.informations_sociodemographiques.profession' => 'required|string|max:255',
            
            // Contact d'urgence
            'donnees_medicales.contact_urgence.personne_a_prevenir' => 'required|string|max:255',
            
            // Couverture santé
            'donnees_medicales.couverture_sante.deja_beneficie' => 'required|in:oui,non',
            'donnees_medicales.couverture_sante.periode' => 'nullable|string|max:255',
            
            // Antécédents médicaux
            'donnees_medicales.antecedents_medicaux.maladie_6_mois' => 'nullable|string',
            'donnees_medicales.antecedents_medicaux.maladie_chronique' => 'required|string',
            'donnees_medicales.antecedents_medicaux.traitement_en_cours' => 'required|string',
            'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante' => 'required|numeric|min:0',
            'donnees_medicales.antecedents_medicaux.porte_lunettes' => 'required|in:oui,non',
            
            // Allergies et antécédents
            'donnees_medicales.allergies_antecedents.allergies' => 'required|string',
            'donnees_medicales.allergies_antecedents.antecedents_chirurgicaux' => 'required|string',
            'donnees_medicales.allergies_antecedents.antecedents_familiaux' => 'required|string',
            
            // Mode de vie
            'donnees_medicales.mode_vie.consommation_alcool_semaine' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.consommation_cola_jour' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.annees_tabagisme' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.cigarettes_par_jour' => 'required|integer|min:0',
            
            // Données gynécologiques (conditionnelles)
            'donnees_medicales.gynecologie.age_premieres_regles' => 'nullable|integer|min:0|max:30',
            'donnees_medicales.gynecologie.methode_contraceptive' => 'nullable|string',
            'donnees_medicales.gynecologie.maladie_seins' => 'nullable|string',
            'donnees_medicales.gynecologie.autre_maladie_genitale' => 'nullable|string',
            'donnees_medicales.gynecologie.maladie_col_uterus' => 'nullable|string',
            'donnees_medicales.gynecologie.nombre_grossesses' => 'nullable|integer|min:0',
            'donnees_medicales.gynecologie.nombre_accouchements' => 'nullable|integer|min:0',
            'donnees_medicales.gynecologie.particularites_derniere_grossesse' => 'nullable|string',
            'donnees_medicales.gynecologie.cesarienne_details' => 'nullable|string',
        ], [
            // Messages d'erreur personnalisés
            'donnees_medicales.informations_personnelles.nom.required' => 'Le nom est obligatoire',
            'donnees_medicales.informations_personnelles.prenom.required' => 'Le prénom est obligatoire',
            'donnees_medicales.informations_personnelles.sexe.required' => 'Le sexe est obligatoire',
            'donnees_medicales.informations_personnelles.sexe.in' => 'Le sexe doit être M ou F',
            'donnees_medicales.informations_personnelles.date_naissance.required' => 'La date de naissance est obligatoire',
            'donnees_medicales.informations_personnelles.date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'donnees_medicales.informations_sociodemographiques.email.required' => 'L\'email est obligatoire',
            'donnees_medicales.informations_sociodemographiques.email.unique' => 'Cet email est déjà utilisé',
            'donnees_medicales.informations_sociodemographiques.telephone.unique' => 'Ce numéro de téléphone est déjà utilisé',
        ]);

        DB::beginTransaction();

        // Utiliser l'ID de l'utilisateur connecté comme client_id
        $clientId = Auth::id();

        // Récupérer les informations du client pour l'access_token
        $client = Client::where('user_id', $clientId)->first();
        if (!$client) {
            throw new \Exception('Aucun client associé à cet utilisateur. Veuillez contacter l\'administrateur.');
        }

        // Création de l'adresse complète
        $adresse = $this->buildAddress($validatedData);

        // Calculer l'âge de l'assuré
        $dateNaissance = Carbon::parse($validatedData['donnees_medicales']['informations_personnelles']['date_naissance']);
        $anciennete = $this->calculateAge($dateNaissance->format('Y-m-d'));

        // Créer l'assuré
        $assure = Assure::create([
            'nom' => $validatedData['donnees_medicales']['informations_personnelles']['nom'],
            'prenoms' => $validatedData['donnees_medicales']['informations_personnelles']['prenom'],
            'sexe' => $validatedData['donnees_medicales']['informations_personnelles']['sexe'],
            'email' => $validatedData['donnees_medicales']['informations_sociodemographiques']['email'],
            'contact' => $validatedData['donnees_medicales']['informations_sociodemographiques']['telephone'],
            'addresse' => $adresse,
            'client_id' => $client->id,
            'client_access_token' => $client->access_token,
            'user_id' => $clientId,
            'date_naissance' => $dateNaissance,
            'anciennete' => $anciennete . ' ans',
            'statut' => 'en attente',
            'is_principal' => $request->input('is_principal', true),
            // Stockage direct des données médicales dans le champ JSON
            'donnees_medicales' => json_encode($validatedData['donnees_medicales'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ]);

        DB::commit();

        // Log de l'activité
        Log::info('Nouvel assuré créé', [
            'assure_id' => $assure->id,
            'user_id' => $clientId,
            'client_id' => $client->id,
            'email' => $assure->email,
            'nom' => $assure->nom,
            'prenoms' => $assure->prenoms
        ]);

        return redirect()->route('assures.index')
            ->with('success', 'Assuré créé avec succès! Votre demande est en cours de traitement.')
            ->with('assure_data', [
                'id' => $assure->id,
                'nom' => $assure->nom,
                'prenoms' => $assure->prenoms,
                'email' => $assure->email
            ]);

    } catch (ValidationException $e) {
        DB::rollBack();
        Log::warning('Erreur de validation lors de la création d\'assuré', [
            'errors' => $e->errors(),
            'user_id' => Auth::id()
        ]);
        
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Veuillez corriger les erreurs dans le formulaire');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de la création d\'assuré', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::id(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage());
    }
}




}
